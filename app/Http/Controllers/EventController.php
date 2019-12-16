<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return $this->view([
            'event' => Event::orderBy('created_at', 'desc')->paginate(5)
        ]);
    }

    public function show($id)
    {
        return $this->view([
            'data' => Event::find($id),
        ]);
    }
}
