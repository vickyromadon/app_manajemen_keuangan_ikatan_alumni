<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        return $this->view([
            'news' => News::orderBy('created_at', 'desc')->paginate(5)
        ]);
    }

    public function show($id)
    {
        return $this->view([
            'data' => News::find($id),
        ]);
    }
}
