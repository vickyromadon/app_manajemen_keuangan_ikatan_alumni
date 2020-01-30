<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\DanaContribution;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContributionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->isMethod('post')) {
                $search;
                $start = $request->start;
                $length = $request->length;

                if (!empty($request->search))
                    $search = $request->search['value'];
                else
                    $search = null;

                $column = [
                    "title",
                    "open_date",
                    "close_date",
                    "status",
                ];

                $total = Contribution::where("title", 'LIKE', "%$search%")
                    ->orWhere("open_date", 'LIKE', "%$search%")
                    ->orWhere("close_date", 'LIKE', "%$search%")
                    ->orWhere("status", 'LIKE', "%$search%")
                    ->count();

                $data = Contribution::where("title", 'LIKE', "%$search%")
                    ->orWhere("open_date", 'LIKE', "%$search%")
                    ->orWhere("close_date", 'LIKE', "%$search%")
                    ->orWhere("status", 'LIKE', "%$search%")
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
        }
        return $this->view([
            'bank' => Bank::all(),
        ]);
    }

    public function danaContributionAdd(Request $request)
    {
        $validator = $request->validate([
            // 'nominal'           => 'required|numeric',
            'transfer_date'     => 'required|date',
            'proof'             => 'required|mimes:jpeg,jpg,png|max:5000',
            'bank_id'           => 'required',
            'contribution_id'   => 'required',
            'descripiton'       => 'nullable|string',
        ]);

        $checkContribution = DanaContribution::where('user_id', '=', Auth::user()->id)->where('contribution_id', '=', $request->contribution_id)->first();
        if($checkContribution != null){
            return response()->json([
                'success'   => false,
                'message'   => 'Anda sudah melakukan pembayaran untuk iuran ini.'
            ]);
        }

        $danaContribution                  = new DanaContribution();
        $danaContribution->code            = "TRX/CONTRIBUTION/" . date("YmdHms");
        $danaContribution->contribution_id = $request->contribution_id;
        $danaContribution->bank_id         = $request->bank_id;
        $danaContribution->user_id         = Auth::user()->id;
        // $danaContribution->nominal         = $request->nominal;
        $danaContribution->nominal         = env('AMOUNT_CONTRIBUTION');
        $danaContribution->transfer_date   = $request->transfer_date;
        $danaContribution->description     = $request->description;
        $danaContribution->proof           = $request->file('proof')->store('dana_contribution/' . Auth::user()->id);

        if ($danaContribution->save()) {
            if (Auth::user()->email != null) {
                $data = array(
                    'title' => $danaContribution->contribution->title,
                    'nominal' => $danaContribution->nominal
                );

                \Mail::send('emails.contributionpending', $data, function ($message) use ($danaContribution) {
                    $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
                    $message->to(Auth::user()->email)->subject('Iuran ' . $danaContribution->contribution->title);
                });
            }

            return response()->json([
                'success'   => true,
                'message'   => 'Iuran Dana Berhasil'
            ]);
        } else {
            if ($request->hasFile('proof')) {
                $fileDelete = DanaContribution::where('proof', '=', $danaContribution->proof)->first();
                Storage::delete($fileDelete->proof);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Iuran Dana Gagal'
            ]);
        }
    }
}
