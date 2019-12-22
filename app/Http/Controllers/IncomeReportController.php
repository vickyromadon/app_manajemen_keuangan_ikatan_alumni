<?php

namespace App\Http\Controllers;

use App\Models\IncomeReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncomeReportController extends Controller
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
                "entry_date",
                "type",
                "nominal",
                "descripition"
            ];

            $total = IncomeReport::with(['user'])
                ->where("entry_date", 'LIKE', "%$search%")
                ->orWhere("type", 'LIKE', "%$search%")
                ->orWhere("nominal", 'LIKE', "%$search%")
                ->orWhere("description", 'LIKE', "%$search%")
                ->count();

            $data = IncomeReport::with(['user'])
                ->where("entry_date", 'LIKE', "%$search%")
                ->orWhere("type", 'LIKE', "%$search%")
                ->orWhere("nominal", 'LIKE', "%$search%")
                ->orWhere("description", 'LIKE', "%$search%")
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
