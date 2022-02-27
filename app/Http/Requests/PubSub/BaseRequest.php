<?php

namespace App\Http\Requests\PubSub;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

abstract class BaseRequest extends FormRequest
{
    public function wantsJson(): bool
    {
        return true;
    }

    public function expectsJson(): bool
    {
        return true;
    }

    protected function topicExists()
    {
        $availableTopics = config('pubsub.topics');
        $currentTopic = $this->route('topic');

        if(!array_key_exists($currentTopic, $availableTopics)) {
            abort(Response::HTTP_NOT_FOUND, "Topic {$currentTopic} not found!");
        }
    }
}
