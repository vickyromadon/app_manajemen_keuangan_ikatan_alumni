<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
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
                "username",
                "name",
                "email",
                "phone",
            ];

            $total = User::whereHas('roles', function ($query) {
                $query->where('name', '<>', 'superadmin');
            })
                ->where(function ($query) use ($search) {
                    $query->where("name", 'LIKE', "%$search%")
                        ->orWhere("phone", 'LIKE', "%$search%")
                        ->orWhere("username", 'LIKE', "%$search%")
                        ->orWhere("email", 'LIKE', "%$search%");
                })
                ->count();

            $data = User::with('roles')
                ->whereHas('roles', function ($query) {
                    $query->where('name', '<>', 'superadmin');
                })
                ->where(function ($query) use ($search) {
                    $query->where("name", 'LIKE', "%$search%")
                        ->orWhere("phone", 'LIKE', "%$search%")
                        ->orWhere("username", 'LIKE', "%$search%")
                        ->orWhere("email", 'LIKE', "%$search%");
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

        return view('admin.user.index')->with('roles', Role::where('name', '<>', 'superadmin')->get());
    }

    public function resetPassword(Request $request)
    {
        $id = intval($request->id);

        $validator = $request->validate([
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required_with:password'
        ]);

        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Ubah Kata Sandi Berhasil'
        ]);
    }

    public function changeRole(Request $request)
    {
        $id = intval($request->id);

        $validator = $request->validate([
            'role'              => 'required'
        ]);

        $user = User::find($id);
        $user->roles()->sync($request->role);

        return response()->json([
            'success' => true,
            'message' => 'Ubah Role Berhasil'
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }

        return view('admin.user.detail')->with('data', $user);
    }
}
