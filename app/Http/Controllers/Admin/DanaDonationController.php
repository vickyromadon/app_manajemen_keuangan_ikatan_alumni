<?php

namespace App\Http\Controllers\Admin;

use App\Models\DanaDonation;
use App\Models\IncomeReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DanaDonationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $search;
            $start = $request->start;
            $length = $request->length;

            if (!empty($request->search))
                $search = $request->search['value'];
            else
                $search = null;

            $column = [
                "",
                "nominal",
                "transfer_date",
                "",
                "",
                "status",
                "created_at",

            ];

            $total = DanaDonation::with(['user', 'bank', 'donation'])
                ->where("nominal", 'LIKE', "%$search%")
                ->orWhere("transfer_date", 'LIKE', "%$search%")
                ->orWhere("status", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = DanaDonation::with(['user', 'bank', 'donation'])
                ->where("nominal", 'LIKE', "%$search%")
                ->orWhere("transfer_date", 'LIKE', "%$search%")
                ->orWhere("status", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
                ->skip($start)
                ->take($length)
                ->get();

            $response = [
                'data' => $data,
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ];

            return response()->json($response);
        }

        return $this->view();
    }

    public function show($id)
    {
        return $this->view(['data' => DanaDonation::find($id)]);
    }

    public function approve(Request $request)
    {
        $statusRes = false;

        DB::transaction(function () use ($request, &$statusRes) {
            $danaDonation = DanaDonation::find($request->id);
            $danaDonation->status = "approve";

            if ($danaDonation->save()) {
                $incomeReport                   = new IncomeReport();
                $incomeReport->entry_date       = $danaDonation->transfer_date;
                $incomeReport->type             = "donation";
                $incomeReport->nominal          = $danaDonation->nominal;
                $incomeReport->description      = "Donasi untuk " . $danaDonation->donation->title;
                $incomeReport->dana_donation_id = $danaDonation->id;
                $incomeReport->user_id          = $danaDonation->user_id;
                $incomeReport->bank_id          = $danaDonation->bank_id;

                if ($incomeReport->save()) {
                    $statusRes = true;
                } else {
                    $statusRes = false;
                }
            } else {
                $statusRes = false;
            }
        });


        if ($statusRes) {
            $danaDonation = DanaDonation::find($request->id);
            $user = User::find($danaDonation->user_id);

            if ($user->email != null) {
                $data = array(
                    'title' => $danaDonation->donation->title,
                    'nominal' => $danaDonation->nominal
                );

                \Mail::send('emails.donationapprove', $data, function ($message) use ($danaDonation, $user) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                    $message->to($user->email)->subject('Donasi ' . $danaDonation->donation->title);
                });
            }

            $notification               = new Notification();
            $notification->type         = "Donasi di Setujui";
            $notification->message      = $user->name . " Donasi anda untuk " . $danaDonation->donation->title . " sebesar Rp." . number_format($danaDonation->nominal) . " telah di setujui oleh pengurus";
            $notification->link         = "";
            $notification->sender_id    = Auth::user()->id;
            $notification->receiver_id  = $user->id;
            $notification->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Disetujui'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Disetujui'
            ]);
        }
    }

    public function reject(Request $request)
    {
        $danaDonation = DanaDonation::find($request->id);
        $danaDonation->status = "reject";

        if ($danaDonation->save()) {
            $user = User::find($danaDonation->user_id);

            if ($user->email != null) {
                $data = array(
                    'title' => $danaDonation->donation->title,
                    'nominal' => $danaDonation->nominal
                );

                \Mail::send('emails.donationreject', $data, function ($message) use ($danaDonation, $user) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                    $message->to($user->email)->subject('Donasi ' . $danaDonation->donation->title);
                });
            }

            $notification               = new Notification();
            $notification->type         = "Donasi di tolak";
            $notification->message      = $user->name . " Donasi anda untuk " . $danaDonation->donation->title . " sebesar Rp." . number_format($danaDonation->nominal) . " telah di tolak oleh pengurus";
            $notification->link         = "";
            $notification->sender_id    = Auth::user()->id;
            $notification->receiver_id  = $user->id;
            $notification->save();

            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Ditolak'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Ditolak'
            ]);
        }
    }
}
