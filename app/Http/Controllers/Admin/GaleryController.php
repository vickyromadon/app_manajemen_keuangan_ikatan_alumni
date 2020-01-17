<?php

namespace App\Http\Controllers\Admin;

use App\Models\Galery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleryController extends Controller
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
                "created_at"
            ];

            $total = Galery::with(['user'])
                ->where("title", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = Galery::with(['user'])
                ->where("title", 'LIKE', "%$search%")
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
            'title'         => 'required|string|max:20',
            'image'         => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $statusRes = false;

        if ($request->description == null) {
            return response()->json([
                'success'   => false,
                'message'   => 'Harap Isi, Deskripsi Terlebih Dahulu.'
            ]);
        }

        DB::transaction(function () use ($request, &$statusRes) {

            $galery                 = new Galery();
            $galery->image          = $request->file('image')->store('galery/' . Auth::user()->id);
            $galery->title          = $request->title;
            $galery->description    = $request->description;
            $galery->user_id        = Auth::user()->id;

            if (!$galery->save()) {
                if ($request->hasFile('image')) {
                    $fileDelete = Galery::where('image', '=', $galery->image)->first();
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
            'title'         => 'required|string|max:20',
            'image'         => 'mimes:jpeg,jpg,png|max:5000',
        ]);

        if ($request->description == "") {
            return response()->json([
                'success'   => false,
                'message'   => 'Harap Isi, Deskripsi Terlebih Dahulu.'
            ]);
        }

        $galery                 = Galery::find($request->id);
        $galery->title          = $request->title;
        $galery->description    = $request->description;

        if ($request->image != null) {
            if ($galery->image != null) {
                $picture = Galery::where('image', '=', $galery->image)->first();
                Storage::delete($picture->image);
            }

            $galery->image = $request->file('image')->store('galery/' . Auth::user()->id);
        }

        if (!$galery->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = Galery::where('image', '=', $galery->image)->first();
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
            $galery = Galery::find($id);
            Storage::delete($galery->image);

            if ($galery->delete()) {
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
