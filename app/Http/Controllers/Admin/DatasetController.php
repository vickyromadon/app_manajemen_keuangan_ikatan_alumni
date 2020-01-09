<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dataset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DatasetController extends Controller
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
                "nis",
                "fullname",
                "parent_name",
                "birthdate",
                "birthplace",
                "entrydate",
                "outdate",
                "department",
                "status",
                "created_at"
            ];

            $total = Dataset::where("nis", 'LIKE', "%$search%")
                ->orWhere("fullname", 'LIKE', "%$search%")
                ->orWhere("parent_name", 'LIKE', "%$search%")
                ->orWhere("birthdate", 'LIKE', "%$search%")
                ->orWhere("birthplace", 'LIKE', "%$search%")
                ->orWhere("entrydate", 'LIKE', "%$search%")
                ->orWhere("outdate", 'LIKE', "%$search%")
                ->orWhere("department", 'LIKE', "%$search%")
                ->orWhere("status", 'LIKE', "%$search%")
                ->orWhere("created_at", 'LIKE', "%$search%")
                ->count();

            $data = Dataset::where("nis", 'LIKE', "%$search%")
                ->orWhere("fullname", 'LIKE', "%$search%")
                ->orWhere("parent_name", 'LIKE', "%$search%")
                ->orWhere("birthdate", 'LIKE', "%$search%")
                ->orWhere("birthplace", 'LIKE', "%$search%")
                ->orWhere("entrydate", 'LIKE', "%$search%")
                ->orWhere("outdate", 'LIKE', "%$search%")
                ->orWhere("department", 'LIKE', "%$search%")
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

        return $this->view();
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'nis'           => 'required|numeric|unique:datasets',
            'fullname'      => 'required|string|max:191',
            'parent_name'   => 'required|string|max:191',
            'birthdate'     => 'required|date',
            'birthplace'    => 'required|string|max:191',
            'entrydate'     => 'required|numeric|digits:4',
            'outdate'       => 'required|numeric|digits:4',
        ]);

        $dataset                = new Dataset();
        $dataset->nis           = $request->nis;
        $dataset->fullname      = $request->fullname;
        $dataset->parent_name   = $request->parent_name;
        $dataset->birthdate     = $request->birthdate;
        $dataset->birthplace    = $request->birthplace;
        $dataset->entrydate     = $request->entrydate;
        $dataset->outdate       = $request->outdate;

        if (!$dataset->save()) {
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
            'nis'           => 'required', 'numeric', Rule::unique('datasets')->ignore($id),
            'fullname'      => 'required|string|max:191',
            'parent_name'   => 'required|string|max:191',
            'birthdate'     => 'required|date',
            'birthplace'    => 'required|string|max:191',
            'entrydate'     => 'required|numeric|digits:4',
            'outdate'       => 'required|numeric|digits:4'
        ]);

        $dataset                = Dataset::find($request->id);
        $dataset->nis           = $request->nis;
        $dataset->fullname      = $request->fullname;
        $dataset->parent_name   = $request->parent_name;
        $dataset->birthdate     = $request->birthdate;
        $dataset->birthplace    = $request->birthplace;
        $dataset->entrydate     = $request->entrydate;
        $dataset->outdate       = $request->outdate;

        if (!$dataset->save()) {
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
        $dataset = Dataset::find($id);

        if ($dataset->delete()) {
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
