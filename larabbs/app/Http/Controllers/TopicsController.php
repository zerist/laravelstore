<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function index(Request $request, Topic $topic)
    {
        $topics = \App\Models\Topic::with('user', 'category')
            ->withOrder($request->order)
            ->paginate(15);
        return view('topics.index', compact('topics'));
    }
}
