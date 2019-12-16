<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return $this->view([
            'data' => User::find(Auth::user()->id),
        ]);
    }

    public function changeSetting(Request $request, $id)
    {
        $validator = $request->validate([
            'name'          => 'nullable|string|max:191',
            'email'         => 'nullable|email',
            'phone'         => ['nullable', 'string', Rule::unique('users')->ignore($id)],
            'address'       => 'nullable|string'
        ]);

        $user = User::find($id);
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->phone        = $request->phone;
        $user->address      = $request->address;

        if ($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Merubah',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Merubah',
            ]);
        }
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);

        if (!(Hash::check($request->current_password, $user->password))) {
            return response()->json([
                'success' => false,
                'message' => 'Kata Sandi Lama Salah, Silahkan Coba Lagi.',
            ]);
        }

        $validator = $request->validate([
            'new_password'         => 'required|min:6',
            'new_password_confirm' => 'required_with:new_password|same:new_password|min:6',
        ]);

        $user->password = Hash::make($request->new_password);

        if ($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Kata Sandi Berhasil diubah',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Kata Sandi Gagal diubah',
            ]);
        }
    }

    public function changeAvatar(Request $request, $id)
    {
        $validator = $request->validate([
            'image'   => 'required|mimes:jpeg,jpg,png|max:5000',
        ]);

        $user = User::find($id);

        if ($request->image != null) {
            if ($request->hasFile('image') != null) {
                if ($user->image != null) {
                    $picture = User::where('image', '=', $user->image)->first();
                    Storage::delete($picture->image);
                }

                $user->image = $request->file('image')->store('user');
            }
        }

        if (!$user->save()) {
            if ($request->hasFile('image')) {
                $fileDelete = User::where('image', '=', $user->image)->first();
                Storage::delete($fileDelete->image);
                $fileDelete->delete();
            }

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
}
