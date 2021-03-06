<?php

namespace App\Http\Controllers;

use App\Models\DanaEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                "nominal",
                "transfer_date",
                "",
                "",
                "status",
                "created_at",

            ];

            $total = DanaEvent::with(['user', 'bank', 'event'])
                ->where("user_id", '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("nominal", 'LIKE', "%$search%")
                    ->orWhere("code", 'LIKE', "%$search%")
                    ->orWhere("transfer_date", 'LIKE', "%$search%")
                    ->orWhere("status", 'LIKE', "%$search%")
                    ->orWhere("created_at", 'LIKE', "%$search%");
                })
                ->count();

            $data = DanaEvent::with(['user', 'bank', 'event'])
                ->where("user_id", '=', Auth::user()->id)
                ->where(function ($q) use ($search) {
                    $q->where("nominal", 'LIKE', "%$search%")
                        ->orWhere("code", 'LIKE', "%$search%")
                        ->orWhere("transfer_date", 'LIKE', "%$search%")
                        ->orWhere("status", 'LIKE', "%$search%")
                        ->orWhere("created_at", 'LIKE', "%$search%");
                })
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
}
