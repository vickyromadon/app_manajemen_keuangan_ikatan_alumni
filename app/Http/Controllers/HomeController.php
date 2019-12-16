<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\Galery;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view([
            'news' => News::orderBy('created_at', 'desc')->paginate(4),
            'event' => Event::orderBy('created_at', 'desc')->paginate(3),
            'galery' => Galery::orderBy('created_at', 'desc')->paginate(6),
        ]);
    }
}
