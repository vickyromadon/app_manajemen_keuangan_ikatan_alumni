<?php

namespace App\Http\Controllers\Admin;

use App\Models\Accountancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountancyController extends Controller
{
    public function index()
    {
        return $this->view([
            'data' => Accountancy::all()
        ]);
    }
}
