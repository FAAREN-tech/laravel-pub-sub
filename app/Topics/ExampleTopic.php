<?php

namespace App\Topics;

use App\Interfaces\PubSub\TopicInterface;

class ExampleTopic extends Topic implements TopicInterface
{
    protected array $tokens = [
        'UbCYnMAcNEe7XZ6NPbBw8sr9jt97DxwLcs42fzFXGjrYV4yzvMq9c8t4xvDeQCb8' => ['*']
    ];

    public function getRules(): array
    {
        return [
            'first_name' => ['string', 'required'],
            'last_name' => ['string', 'required'],
            'email' => ['string', 'email', 'required']
        ];
    }

    public function getResponseData(\stdClass $event): array
    {
        return [

        ];
    }

}
