<?php

namespace App\Http\Controllers;

use App\Models\DanaDonation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DanaDonationController extends Controller
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
                    "nominal",
                    "transfer_date",
                    "",
                    "",
                    "status",
                    "created_at",

                ];

                $total = DanaDonation::with(['user', 'bank', 'donation'])
                    ->where("user_id", '=', Auth::user()->id)
                    ->where(function ($q) use ($search) {
                        $q->where("nominal", 'LIKE', "%$search%")
                            ->orWhere("transfer_date", 'LIKE', "%$search%")
                            ->orWhere("status", 'LIKE', "%$search%")
                            ->orWhere("created_at", 'LIKE', "%$search%");
                    })
                    ->count();

                $data = DanaDonation::with(['user', 'bank', 'donation'])
                    ->where("user_id", '=', Auth::user()->id)
                    ->where(function ($q) use ($search) {
                        $q->where("nominal", 'LIKE', "%$search%")
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
        }
        return $this->view();
    }
}
