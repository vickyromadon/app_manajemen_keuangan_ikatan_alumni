<?php

namespace App\Http\Controllers\Admin;

use App\Models\DanaContribution;
use App\Models\TotalContribution;
use App\Models\User;
use App\Models\IncomeReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DanaContributionController extends Controller
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

            $total = DanaContribution::with(['user', 'bank', 'contribution'])
                ->where("nominal", 'LIKE', "%$search%")
                ->orWhere("transfer_date", 'LIKE', "%$search%")
                ->orWhere("status", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = DanaContribution::with(['user', 'bank', 'contribution'])
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
        return $this->view(['data' => DanaContribution::find($id)]);
    }

    public function approve(Request $request)
    {
        $statusRes = false;

        DB::transaction(function () use ($request, &$statusRes) {
            $danaContribution = DanaContribution::find($request->id);
            $danaContribution->status = "approve";

            if ($danaContribution->save()) {
                $incomeReport                       = new IncomeReport();
                $incomeReport->entry_date           = $danaContribution->transfer_date;
                $incomeReport->type                 = "contribution";
                $incomeReport->nominal              = $danaContribution->nominal;
                $incomeReport->description          = "Iuran untuk " . $danaContribution->contribution->title;
                $incomeReport->dana_contribution_id = $danaContribution->id;
                $incomeReport->user_id              = $danaContribution->user_id;
                $incomeReport->bank_id              = $danaContribution->bank_id;

                if ($incomeReport->save()) {
                    $totalContribution = TotalContribution::find(1);
                    $totalContribution->dana += $danaContribution->nominal;

                    if ($totalContribution->save()) {
                        $statusRes = true;
                    } else {
                        $statusRes = false;
                    }
                } else {
                    $statusRes = false;
                }
            } else {
                $statusRes = false;
            }
        });

        if ($statusRes) {
            $danaContribution = DanaContribution::find($request->id);
            $user = User::find($danaContribution->user_id);

            if ($user->email != null) {
                $data = array(
                    'title' => $danaContribution->contribution->title,
                    'nominal' => $danaContribution->nominal
                );

                \Mail::send('emails.contributionapprove', $data, function ($message) use ($danaContribution, $user) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                    $message->to($user->email)->subject('Contribution ' . $danaContribution->contribution->title);
                });
            }

            $notification               = new Notification();
            $notification->type         = "Iuran di Setujui";
            $notification->message      = $user->name . " Iuran anda untuk " . $danaContribution->contribution->title . " sebesar Rp." . number_format($danaContribution->nominal) . " telah di setujui oleh pengurus";
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
        $danaContribution = DanaContribution::find($request->id);
        $danaContribution->status = "reject";

        if ($danaContribution->save()) {
            $user = User::find($danaContribution->user_id);

            if ($user->email != null) {
                $data = array(
                    'title' => $danaContribution->contribution->title,
                    'nominal' => $danaContribution->nominal
                );

                \Mail::send('emails.contributionreject', $data, function ($message) use ($danaContribution, $user) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                    $message->to($user->email)->subject('Contribution ' . $danaContribution->contribution->title);
                });
            }

            $notification               = new Notification();
            $notification->type         = "Iuran di tolak";
            $notification->message      = $user->name . " Iuran anda untuk " . $danaContribution->contribution->title . " sebesar Rp." . number_format($danaContribution->nominal) . " telah di tolak oleh pengurus";
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
