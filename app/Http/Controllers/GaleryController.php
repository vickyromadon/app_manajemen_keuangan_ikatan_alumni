<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galery;

class GaleryController extends Controller
{
    public function index()
    {
        return $this->view([
            'galery' => Galery::orderBy('created_at', 'desc')->paginate(20)
        ]);
    }

    public function show($id)
    {
        return $this->view([
            'data' => Galery::find($id),
        ]);
    }
}
