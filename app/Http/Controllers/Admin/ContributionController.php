<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contribution;
use App\Models\TotalContribution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
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
                "open_date",
                "close_date",
                "status",
                "created_at"
            ];

            $total = Contribution::with(['user'])
                ->where("title", 'LIKE', "%$search%")
                ->orWhere("open_date", 'LIKE', "%$search%")
                ->orWhere("close_date", 'LIKE', "%$search%")
                ->orWhere("status", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = Contribution::with(['user'])
                ->where("title", 'LIKE', "%$search%")
                ->orWhere("open_date", 'LIKE', "%$search%")
                ->orWhere("close_date", 'LIKE', "%$search%")
                ->orWhere("status", 'LIKE', "%$search%")
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

        return $this->view([
            'total_contribution' => TotalContribution::where('id', 1)->first()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'title'         => 'required|string',
            'open_date'     => 'required|date',
            'close_date'    => 'required|date',
            'description'   => 'required|string',
            'status'        => 'required|in:open,close',
        ]);

            $contribution                   = new Contribution();
            $contribution->title            = $request->title;
            $contribution->description      = $request->description;
            $contribution->open_date        = $request->open_date;
            $contribution->close_date       = $request->close_date;
            $contribution->status           = $request->status;
            $contribution->user_id          = Auth::user()->id;

        if (!$contribution->save()) {
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
            'open_date'     => 'required|date',
            'close_date'    => 'required|date',
            'description'   => 'required|string',
            'status'        => 'required|in:open,close',
        ]);

        $contribution                   = Contribution::find($request->id);
        $contribution->title            = $request->title;
        $contribution->description      = $request->description;
        $contribution->status           = $request->status;
        $contribution->open_date        = $request->open_date;
        $contribution->close_date       = $request->close_date;

        if (!$contribution->save()) {
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
        $contribution = Contribution::find($id);

        if ($contribution->delete()) {
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

    public function show($id)
    {
        return $this->view([
            'data' => Contribution::find($id)
        ]);
    }
}
