<?php

namespace App\Http\Controllers\Admin;

use App\Models\DanaEvent;
use App\Models\IncomeReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DanaEventController extends Controller
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
                "code",
                "",
                "nominal",
                "transfer_date",
                "",
                "",
                "status",
                "created_at",

            ];

            $total = DanaEvent::with(['user', 'bank', 'event'])
                ->where("nominal", 'LIKE', "%$search%")
                ->orWhere("code", 'LIKE', "%$search%")
                ->orWhere("transfer_date", 'LIKE', "%$search%")
                ->orWhere("status", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = DanaEvent::with(['user', 'bank', 'event'])
                ->where("nominal", 'LIKE', "%$search%")
                ->orWhere("code", 'LIKE', "%$search%")
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
        return $this->view(['data' => DanaEvent::find($id)]);
    }

    public function approve(Request $request)
    {
        $statusRes = false;

        DB::transaction(function () use ($request, &$statusRes) {
            $danaEvent = DanaEvent::find($request->id);
            $danaEvent->status = "approve";

            if ($danaEvent->save()) {
                $incomeReport                   = new IncomeReport();
                $incomeReport->entry_date       = $danaEvent->transfer_date;
                $incomeReport->type             = "event";
                $incomeReport->nominal          = $danaEvent->nominal;
                $incomeReport->description      = "Galang dana untuk " . $danaEvent->event->title;
                $incomeReport->dana_event_id    = $danaEvent->id;
                $incomeReport->user_id          = $danaEvent->user_id;
                $incomeReport->bank_id          = $danaEvent->bank_id;

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
            $danaEvent = DanaEvent::find($request->id);
            $user = User::find($danaEvent->user_id);

            if ($user->email != null) {
                $data = array(
                    'title' => $danaEvent->event->title,
                    'nominal' => $danaEvent->nominal
                );

                \Mail::send('emails.eventapprove', $data, function ($message) use ($danaEvent, $user) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                    $message->to($user->email)->subject('Event ' . $danaEvent->event->title);
                });
            }

            $notification               = new Notification();
            $notification->type         = "Galang Dana di Setujui";
            $notification->message      = $user->name . " Galang Dana anda untuk " . $danaEvent->event->title . " sebesar Rp." . number_format($danaEvent->nominal) . " telah di setujui oleh pengurus";
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
        $danaEvent = DanaEvent::find($request->id);
        $danaEvent->status = "reject";

        if ($danaEvent->save()) {
            $user = User::find($danaEvent->user_id);

            if ($user->email != null) {
                $data = array(
                    'title' => $danaEvent->event->title,
                    'nominal' => $danaEvent->nominal
                );

                \Mail::send('emails.eventreject', $data, function ($message) use ($danaEvent, $user) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                    $message->to($user->email)->subject('Event ' . $danaEvent->event->title);
                });
            }

            $notification               = new Notification();
            $notification->type         = "Galang Dana di tolak";
            $notification->message      = $user->name . " Galang Dana anda untuk " . $danaEvent->event->title . " sebesar Rp." . number_format($danaEvent->nominal) . " telah di tolak oleh pengurus";
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
