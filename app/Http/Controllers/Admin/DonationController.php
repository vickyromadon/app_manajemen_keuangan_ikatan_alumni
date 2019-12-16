<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
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
                "title",
                "donation_limit",
                "created_at"
            ];

            $total = Donation::with(['user'])
                ->where("title", 'LIKE', "%$search%")
                ->orWhere("donation_limit", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = Donation::with(['user'])
                ->where("title", 'LIKE', "%$search%")
                ->orWhere("donation_limit", 'LIKE', "%$search%")
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

    public function store(Request $request)
    {
        $validator = $request->validate([
            'title'         => 'required|string',
            'donation_limit'=> 'required|date',
            'description'   => 'required|string',
            'link_video'    => 'nullable|string',
            'image'         => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $statusRes = false;

        DB::transaction(function () use ($request, &$statusRes) {
            $donation                   = new Donation();
            $donation->image            = $request->file('image')->store('donation/' . Auth::user()->id);
            $donation->title            = $request->title;
            $donation->description      = $request->description;
            $donation->donation_limit   = $request->donation_limit;
            $donation->link_video       = $request->link_video;
            $donation->user_id          = Auth::user()->id;

            if (!$donation->save()) {
                if ($request->hasFile('image')) {
                    $fileDelete = Donation::where('image', '=', $donation->image)->first();
                    Storage::delete($fileDelete->image);
                    $fileDelete->delete();
                }
                $statusRes = false;
            } else {
                $statusRes = true;
            }
        });

        if (!$statusRes) {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menambahkan'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Menambahkan'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'title'         => 'required|string',
            'donation_limit'=> 'required|date',
            'description'   => 'required|string',
            'link_video'    => 'nullable|string',
            'image'         => 'mimes:jpeg,jpg,png|max:5000',
        ]);

        $donation                   = Donation::find($request->id);
        $donation->title            = $request->title;
        $donation->description      = $request->description;
        $donation->donation_limit   = $request->donation_limit;
        $donation->link_video       = $request->link_video;

        if ($request->image != null) {
            if ($donation->image != null) {
                $picture = Donation::where('image', '=', $donation->image)->first();
                Storage::delete($picture->image);
            }

            $donation->image = $request->file('image')->store('donation/' . Auth::user()->id);
        }

        if (!$donation->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Donation::where('image', '=', $donation->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }

            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Merubah'
            ]);
        } else {
            return response()->json([
                'success'  => true,
                'message'  => 'Berhasil Merubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $statusRes = false;

        DB::transaction(function () use ($id, &$statusRes) {
            $donation = Donation::find($id);
            Storage::delete($donation->image);

            if ($donation->delete()) {
                $statusRes = true;
            }
        });

        if ($statusRes) {
            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil Menghapus'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Gagal Menghapus'
            ]);
        }
    }
}
