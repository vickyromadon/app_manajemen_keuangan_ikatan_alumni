<?php

namespace App\Http\Controllers\Admin;

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
            $type   = $request->type;

            if (!empty($request->search))
                $search = $request->search['value'];
            else
                $search = null;

            $column = [
                "code",
                "entry_date",
                "type",
                "nominal",
                "descripition"

            ];

            $total = IncomeReport::with(['user', 'bank'])
                ->where("type", 'LIKE', "%$type%")
                ->where(function ($q) use ($search) {
                    $q->where("entry_date", 'LIKE', "%$search%")
                    ->orWhere("code", 'LIKE', "%$search%")
                    ->orWhere("type", 'LIKE', "%$search%")
                    ->orWhere("nominal", 'LIKE', "%$search%")
                    ->orWhere("description", 'LIKE', "%$search%");
                })
                ->count();

            $data = IncomeReport::with(['user', 'bank'])
                ->where("type", 'LIKE', "%$type%")
                ->where(function ($q) use ($search) {
                    $q->where("entry_date", 'LIKE', "%$search%")
                        ->orWhere("code", 'LIKE', "%$search%")
                        ->orWhere("type", 'LIKE', "%$search%")
                        ->orWhere("nominal", 'LIKE', "%$search%")
                        ->orWhere("description", 'LIKE', "%$search%");
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
