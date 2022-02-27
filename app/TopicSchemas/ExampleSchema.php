<?php

namespace App\TopicSchemas;

use App\Interfaces\PubSub\TopicSchemaInterface;

class ExampleSchema extends BaseSchema implements TopicSchemaInterface
{
    public static function getRules(): array
    {
        return [

        ];
    }

    public static function getResponseData(\stdClass $event): array
    {
        return [];
    }

}
