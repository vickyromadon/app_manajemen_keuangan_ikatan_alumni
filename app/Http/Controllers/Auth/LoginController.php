<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Dataset;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required|min:6'
            ]
        );

        $credential = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::guard('web')->attempt($credential, $request->member)) {
            return redirect()->intended(route('index'));
        } else {
            $validator->after(function ($validator) {
                $validator->errors()->add('username', 'Gagal Login, NIS dan Kata Sandi Salah.');
            });
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            return redirect()->back()->withInput($request->only('username', 'remember'));
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function showFormForgotNIS()
    {
        return view('auth.forgotnis');
    }

    public function forgotNIS(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname'      => 'required',
                'parent_name'   => 'required',
                'birthdate'     => 'required|date',
                'birthplace'    => 'required',
                'email'         => 'required|email',
            ]
        );

        $dataset = Dataset::where('fullname', $request->fullname)
            ->where('parent_name', $request->parent_name)
            ->where('birthdate', $request->birthdate)
            ->where('birthplace', $request->birthplace)
            ->first();

        if ($dataset == null) {
            $validator->after(function ($validator) {
                $validator->errors()->add('data-error', 'Data tidak ditemukan.');
            });

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if ($dataset->status == 0) {
            $validator->after(function ($validator) {
                $validator->errors()->add('data-error', 'Belum Memiliki Akun.');
            });

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }


        $data = array(
            'nis' => $dataset->nis
        );

        \Mail::send('emails.forgotnis', $data, function ($message) use ($request) {
            $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
            $message->to($request->email)->subject('Lupa NIS');
        });

        return redirect()->route('forgot-nis', [
            'data-success' => "NIS sudah dikirim ke email.",
        ]);
    }

    public function showFormForgotPassword()
    {
        return view('auth.forgotpassword');
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nis'           => 'required|numeric',
                'fullname'      => 'required',
                'parent_name'   => 'required',
                'birthdate'     => 'required|date',
                'birthplace'    => 'required',
                'email'         => 'required|email',
            ]
        );

        $dataset = Dataset::where('nis', $request->nis)
            ->where('fullname', $request->fullname)
            ->where('parent_name', $request->parent_name)
            ->where('birthdate', $request->birthdate)
            ->where('birthplace', $request->birthplace)
            ->first();

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($dataset == null) {
            $validator->after(function ($validator) {
                $validator->errors()->add('data-error', 'Data tidak ditemukan.');
            });

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if ($dataset->status == 0) {
            $validator->after(function ($validator) {
                $validator->errors()->add('data-error', 'Belum Memiliki Akun.');
            });

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $password       = str_random(8);
        $passwordHash   = Hash::make($password);

        $user           = User::where('dataset_id', $dataset->id)->first();
        $user->password = $passwordHash;
        $user->save();

        $data = array(
            'password' => $password
        );

        \Mail::send('emails.forgotpassword', $data, function ($message) use ($request) {
            $message->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
            $message->to($request->email)->subject('Lupa Kata Sandi');
        });

        return redirect()->route('forgot-password', [
            'data-success' => "Kata Sandi sudah dikirim ke email.",
        ]);
    }
}
