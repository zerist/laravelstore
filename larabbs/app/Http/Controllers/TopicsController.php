<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']] );
    }

    public function index(Request $request, Topic $topic)
    {
        $topics = \App\Models\Topic::with('user', 'category')
            ->withOrder($request->order)
            ->paginate(15);
        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }


    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        return redirect()->route('topics.show', $topic->id)->with('success', 'Topic create success!');
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->update();

        return redirect()->route('topics.show', $topic->id)->with('success', 'Topic update success!');
    }

    public function uploadImage(Request $request)
    {
        $data = [
            'success' => false,
            'msg' => 'upload failed!',
            'file_path' => ''
        ];
        if ($file = $request->upload_file) {
            // 保存文件
            $path = $request->file('upload_file')->store('public/topic_images');

            $data['file_path'] = $path;
            $data['msg'] = 'upload success!';
            $data['success'] = true;
        }
        return $data;
    }
}
