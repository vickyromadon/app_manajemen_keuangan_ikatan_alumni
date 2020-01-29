<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dataset;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showFormCheckNIS() {
        return view('auth.checknis');
    }

    public function checkNIS(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nis' => 'required',
            ]
        );

        $dataset = Dataset::where('nis', $request->nis)->first();

        if ($dataset === null) {
            $validator->after(function ($validator) {
                $validator->errors()->add('nis', 'NIS tidak terdaftar.');
            });
        } else {
            if ($dataset->status === '1'){
                $validator->after(function ($validator) {
                    $validator->errors()->add('nis', 'NIS tersebut sudah memiliki akun.');
                });
            }
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            return redirect()->route('check-data', [
                'nis' => $dataset->nis,
                'fullname' => $dataset->fullname,
                'entrydate' => $dataset->entrydate,
                'outdate' => $dataset->outdate,
            ]);
        }
    }

    public function showFormCheckData()
    {
        return view('auth.checkdata');
    }

    public function checkData(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nis'           => 'required',
                'fullname'      => 'required',
                'parent_name'   => 'required',
                'birthdate'     => 'required|date',
                'birthplace'    => 'required',
                'entrydate'     => 'required|numeric|digits:4',
                'outdate'       => 'required|numeric|digits:4',
                'password'      => 'required|string|min:6|confirmed',
            ]
        );

        $dataset = Dataset::where('nis', $request->nis)
                        ->where('fullname', $request->fullname)
                        ->where('parent_name', $request->parent_name)
                        ->where('birthdate', $request->birthdate)
                        ->where('birthplace', $request->birthplace)
                        ->where('entrydate', $request->entrydate)
                        ->where('outdate', $request->outdate)
                        ->first();

        if($dataset == null){
            $validator->after(function ($validator) {
                $validator->errors()->add('data-error', 'Biodata yang diisi tidak sesuai dengan data NIS.');
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $statusResponse = false;
        $passwordHash   = Hash::make($request->password);

        \DB::transaction(function() use ($dataset, &$passwordHash, &$statusResponse){
            $user = new User();
            $user->username     = $dataset->nis;
            $user->name         = $dataset->fullname;
            $user->password     = $passwordHash;
            $user->dataset_id   = $dataset->id;

            $updateDataSet          = Dataset::find($dataset->id);
            $updateDataSet->status  = '1';
            $updateDataSet->save();

            if ($user->save()) {
                $statusResponse = true;

                // role attach alias
                $role = Role::where('name', 'alumni')->first();
                $user->attachRole($role);
            } else {
                $statusResponse = false;
            }
        });

        if ( $statusResponse ){
            return redirect()->route('login')->with('status', 'Pendaftaran Berhasil.');
        } else {
            return redirect()->route('result-account',[
                'data-error' => "Terjadi Kesalahan.",
            ]);
        }
    }

    public function resultAccount()
    {
        return view('auth.resultaccount');
    }
}
