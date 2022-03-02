<?php

namespace App\Http\Middleware\PubSub;

use App\Topics\Topic;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TopicExistsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->route()->hasParameter('topic')) {
            abort(Response::HTTP_BAD_REQUEST, "No topic provided");
        }
        if(!Topic::topicExists($request->route('topic'))) {
            abort(Response::HTTP_NOT_FOUND, "Given topic not found");
        }
        return $next($request);
    }
}
