<?php

namespace App\Http\Controllers\Admin;

use App\Models\Accountancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountancyController extends Controller
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
                "date",
                "income",
                "expense",
                "total",
                "created_at"
            ];

            $total = Accountancy::where("code", 'LIKE', "%$search%")
                ->orWhere("date", 'LIKE', "%$search%")
                ->orWhere("income", 'LIKE', "%$search%")
                ->orWhere("expense", 'LIKE', "%$search%")
                ->orWhere("total", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = Accountancy::where("code", 'LIKE', "%$search%")
                ->orWhere("date", 'LIKE', "%$search%")
                ->orWhere("income", 'LIKE', "%$search%")
                ->orWhere("expense", 'LIKE', "%$search%")
                ->orWhere("total", 'LIKE', "%$search%")
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
}
