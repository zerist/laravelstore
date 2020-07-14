<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function index()
    {
        $topics = \App\Models\Topic::orderBy('reply_count', 'desc')
            ->paginate(30);
        return view('topics.index', compact('topics'));
    }
}
