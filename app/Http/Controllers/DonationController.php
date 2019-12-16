<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{
    public function index()
    {
        return $this->view([
            'donation' => Donation::orderBy('created_at', 'desc')->paginate(5)
        ]);
    }

    public function show($id)
    {
        return $this->view([
            'data' => Donation::find($id),
        ]);
    }
}
