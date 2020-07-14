<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function index()
    {
        $topics = \App\Models\Topic::with('user', 'category')
            ->orderBy('reply_count', 'desc')
            ->paginate(15);
        return view('topics.index', compact('topics'));
    }
}
