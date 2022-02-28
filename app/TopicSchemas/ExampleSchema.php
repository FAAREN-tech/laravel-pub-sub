<?php

namespace App\TopicSchemas;

use App\Interfaces\PubSub\TopicSchemaInterface;

class ExampleSchema extends BaseSchema implements TopicSchemaInterface
{
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
