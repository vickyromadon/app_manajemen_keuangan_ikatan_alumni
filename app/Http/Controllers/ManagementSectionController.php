<?php

namespace App\Http\Controllers;

use App\Models\User;

class ManagementSectionController extends Controller
{
    public function index()
    {
        return $this->view([
            'user' => User::all()
        ]);
    }
}
