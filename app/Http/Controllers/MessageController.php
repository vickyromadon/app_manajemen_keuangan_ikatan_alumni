<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $request->validate([
                'title'       => 'required|string',
                'description'   => 'required|string',
            ]);

            $message                = new Message();
            $message->title         = $request->title;
            $message->description   = $request->description;
            $message->user_id       = Auth::user()->id;

            if ($message->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'Kirim Kritik dan Saran Berhasil'
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Kirim Kritik dan Saran Gagal'
                ]);
            }
        }
        return $this->view();
    }
}
