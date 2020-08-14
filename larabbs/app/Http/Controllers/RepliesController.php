<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Reply;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, Reply $reply)
    {
        $reply->fill($request->all());
        $reply->topic_id = $request->topic_id;
        $reply->user_id = Auth::id();
        $reply->save();

        return redirect()->back()->with('success', 'Reply topic success!');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);

        $reply->delete();
        return redirect()->back()->with('success', 'Delete reply success!');
    }

    public function index(){

    }
}
