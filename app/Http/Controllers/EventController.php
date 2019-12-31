<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Bank;
use App\Models\DanaEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        return $this->view([
            'event' => Event::orderBy('created_at', 'desc')->paginate(5)
        ]);
    }

    public function show($id)
    {
        return $this->view([
            'data' => Event::find($id),
            'bank' => Bank::all(),
        ]);
    }

    public function danaEventAdd(Request $request)
    {
        $validator = $request->validate([
            'nominal'       => 'required|numeric',
            'transfer_date' => 'required|date',
            'proof'         => 'required|mimes:jpeg,jpg,png|max:5000',
            'bank_id'       => 'required',
            'event_id'      => 'required',
            'descripiton'   => 'nullable|string',
        ]);

        $danaEvent                  = new DanaEvent();
        $danaEvent->event_id        = $request->event_id;
        $danaEvent->bank_id         = $request->bank_id;
        $danaEvent->user_id         = Auth::user()->id;
        $danaEvent->nominal         = $request->nominal;
        $danaEvent->transfer_date   = $request->transfer_date;
        $danaEvent->description     = $request->description;
        $danaEvent->proof           = $request->file('proof')->store('dana_event/' . Auth::user()->id);

        if ($danaEvent->save()) {
            if (Auth::user()->email != null) {
                $data = array(
                    'title' => $danaEvent->event->title,
                    'nominal' => $danaEvent->nominal
                );

                \Mail::send('emails.eventpending', $data, function ($message) use ($danaEvent) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                    $message->to(Auth::user()->email)->subject('Event ' . $danaEvent->event->title);
                });
            }

            return response()->json([
                'success'   => true,
                'message'   => 'Galang Dana Berhasil'
            ]);
        } else {
            if ($request->hasFile('proof')) {
                $fileDelete = DanaEvent::where('proof', '=', $danaEvent->proof)->first();
                Storage::delete($fileDelete->proof);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Galang Dana Gagal'
            ]);
        }
    }
}
