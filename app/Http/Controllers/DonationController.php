<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Bank;
use App\Models\DanaDonation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    public function index()
    {
        return $this->view([
            'donation' => Donation::orderBy('created_at', 'desc')->paginate(5)
        ]);
    }

    public function show($id)
    {
        return $this->view([
            'data' => Donation::find($id),
            'bank' => Bank::all(),
        ]);
    }

    public function danaDonationAdd(Request $request)
    {
        $validator = $request->validate([
            'nominal'       => 'required|numeric',
            'transfer_date' => 'required|date',
            'proof'         => 'required|mimes:jpeg,jpg,png|max:5000',
            'bank_id'       => 'required',
            'donation_id'   => 'required',
            'descripiton'   => 'nullable|string',
        ]);

        $danaDonation                  = new DanaDonation();
        $danaDonation->donation_id     = $request->donation_id;
        $danaDonation->bank_id         = $request->bank_id;
        $danaDonation->user_id         = Auth::user()->id;
        $danaDonation->nominal         = $request->nominal;
        $danaDonation->transfer_date   = $request->transfer_date;
        $danaDonation->description     = $request->description;
        $danaDonation->proof           = $request->file('proof')->store('dana_donation/' . Auth::user()->id);

        if ($danaDonation->save()) {
            if ( Auth::user()->email != null ) {
                $data = array(
                    'title' => $danaDonation->donation->title,
                    'nominal' => $danaDonation->nominal
                );

                \Mail::send('emails.donationpending', $data, function ($message) use ($danaDonation) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                    $message->to(Auth::user()->email)->subject('Donasi ' . $danaDonation->donation->title);
                });
            }

            return response()->json([
                'success'   => true,
                'message'   => 'Donasi Dana Berhasil'
            ]);
        } else {
            if ($request->hasFile('proof')) {
                $fileDelete = DanaDonation::where('proof', '=', $danaDonation->proof)->first();
                Storage::delete($fileDelete->proof);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Donasi Dana Gagal'
            ]);
        }
    }
}
