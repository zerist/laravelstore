<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * get
     * @param Blog $blog
     * @return string
     */
    public function getBlogById(Blog $blog)
    {
        return $blog->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * post
     * @param Blog $blog
     * @return string
     */
    public function postOne(Request $request)
    {
        $blog = new Blog();
        $blog->author = $request->author;
        $blog->subject = $request->subject;
        $blog->context = $request->context;
        $blog->save();
    }

    /**
     * delete
     * @param Blog $blog
     * @return string
     * @throws \Exception
     */
    public function deleteBlogById(Blog $blog)
    {
        return $blog->delete();
    }

    /**
     * put
     * @param Blog $blog
     * @return string
     */
    public function putOne(Request $request)
    {
        $blog = new Blog();
        $blog->author = $request->author;
        $blog->subject = $request->subject;
        $blog->context = $request->context;
        $blog->update();
        return $blog->toJson(JSON_PRETTY_PRINT);
    }
}
