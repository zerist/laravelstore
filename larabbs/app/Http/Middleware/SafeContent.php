<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SafeContent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //安全过滤content内容
        if ($request->has('content')) {
            $request->merge(['content' => clean($request->input('content', 'user_topic_body'))]);
        }
        return $next($request);
    }
}
