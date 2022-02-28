<?php

namespace App\Interfaces\PubSub;

use Illuminate\Http\JsonResponse;

interface TopicSchemaInterface
{
    /**
     * Defines the rules for the given Topic
     * Usable are the Laravel default validation logic
     *
     * @return array
     */
    public function getRules(): array;

    /**
     * Takes the event from the database
     * Returns the correct response as JSON with default values
     *
     * @param \stdClass $event
     * @return array
     */
    public function getResponseData(\stdClass $event): array;
}
