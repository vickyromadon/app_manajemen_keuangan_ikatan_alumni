<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
}
