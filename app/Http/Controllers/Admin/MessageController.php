<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MessageController extends Controller
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

            $total = Message::with(['user'])
                ->where("title", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = Message::with(['user'])
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

    public function destroy($id)
    {
        $message = Message::find($id);

        if ($message->delete()) {
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
