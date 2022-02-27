<?php

namespace App\Http\Controllers\PubSub;

use App\Http\Controllers\Controller;
use App\Http\Requests\PubSub\PublishRequest;
use Illuminate\Http\Request;

abstract class BasePublishController extends Controller
{
    /**
     * @param PublishRequest $request
     * @param string $topic
     * @return mixed
     */
    abstract public function publish(PublishRequest $request, string $topic);
}
