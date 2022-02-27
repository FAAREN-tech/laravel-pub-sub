<?php

namespace App\Http\Controllers\PubSub;

use App\Http\Controllers\Controller;
use App\Http\Requests\PubSub\PublishRequest;
use Illuminate\Http\Request;

class TopicPublishController extends BasePublishController
{
    /**
     * @param PublishRequest $request
     * @param string $topic
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function publish(PublishRequest $request, string $topic)
    {
        return response()->json([
            "topic" => $topic,
            "request" => $request->all()
        ]);
    }

}
