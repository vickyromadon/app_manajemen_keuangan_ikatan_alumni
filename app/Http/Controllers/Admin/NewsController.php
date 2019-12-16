<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
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

            $total = News::with(['user'])
                ->where("title", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = News::with(['user'])
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
            'title'         => 'required|string',
            'description'   => 'required|string',
        ]);

        $news               = new News();
        $news->title        = $request->title;
        $news->description  = $request->description;
        $news->user_id      = Auth::user()->id;

        if (!$news->save()) {
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
            'description'   => 'required|string',
        ]);

        $news               = News::find($request->id);
        $news->title        = $request->title;
        $news->description  = $request->description;

        if (!$news->save()) {
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
        $news = News::find($id);

        if ($news->delete()) {
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
