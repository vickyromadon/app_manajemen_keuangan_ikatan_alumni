<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /** For Datatables **/
        if ($request->isMethod('post')) {
            $search;
            $start = $request->start;
            $length = $request->length;

            if (!empty($request->search))
                $search = $request->search['value'];
            else
                $search = null;

            $column = [
                "name",
                "display_name",
                "description",
            ];

            $total = Role::where("name", '<>', 'alumni')
                ->where(function ($query) use ($search) {
                    $query->where("name", 'LIKE', "%$search%")
                        ->orWhere("display_name", 'LIKE', "%$search%")
                        ->orWhere("description", 'LIKE', "%$search%");
            })
                ->count();

            $data = Role::where("name", '<>', 'alumni')
                ->where(function ($query) use ($search) {
                    $query->where("name", 'LIKE', "%$search%")
                        ->orWhere("display_name", 'LIKE', "%$search%")
                        ->orWhere("description", 'LIKE', "%$search%");
            })
                ->orderBy($column[$request->order[0]['column'] - 1], $request->order[0]['dir'])
                ->skip($start)
                ->take($length)
                ->get();

            $response = [
                'data'  =>  $data,
                'draw' => intval($request->draw),
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ];

            return response()->json($response);
        }

        return $this->view();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create', ['permissions' => Permission::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'name'          => 'required|unique:roles',
            'display_name'  => 'required',
            'description'   => 'required'
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        if ($request->permission) {
            $role->attachPermissions(array_values($request->permission));
        }

        return redirect()->route('admin.role.index')->with('success', 'Role added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('admin.role.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if ($role->name == 'admin') {
            $this->validate($request, [
                'display_name'  => 'required',
                'description'   => 'required'
            ]);
        } else {
            $this->validate($request, [
                'name'          => ['required', Rule::unique('roles')->ignore($id)],
                'display_name'  => 'required',
                'description'   => 'required'
            ]);

            $role->name = $request->name;
        }

        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        if ($request->permission) {
            $role->perms()->sync(array_values($request->permission));
        }

        return redirect()->route('admin.role.index')->with('success', 'Role updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return redirect()->route('admin.role.index')->with('success', 'Role deleted!');
    }
}
