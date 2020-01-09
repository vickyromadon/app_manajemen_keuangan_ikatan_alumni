<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanaContribution;
use App\Models\DanaEvent;
use App\Models\DanaDonation;
use App\Models\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view([
            'danaContribution'  => DanaContribution::where('status', '=', 'pending')->count(),
            'danaEvent'         => DanaEvent::where('status', '=', 'pending')->count(),
            'danaDonation'      => DanaDonation::where('status', '=', 'pending')->count(),
        ]);
    }
}
