<?php

namespace App\Http\Requests\PubSub;

use App\Exceptions\TopicException;
use App\Interfaces\PubSub\TopicSchemaInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

abstract class BaseRequest extends FormRequest
{
    protected ?TopicSchemaInterface $topicSchema = NULL;
    protected ?array $topicConfiguration = NULL;

    public function wantsJson(): bool
    {
        return true;
    }

    public function expectsJson(): bool
    {
        return true;
    }

    /**
     * Checks if the requested topic exists
     *
     * @return void
     */
    protected function topicExists()
    {
        $availableTopics = config('pubsub.topics');
        $currentTopic = $this->route('topic');

        if(!array_key_exists($currentTopic, $availableTopics)) {
            abort(Response::HTTP_NOT_FOUND, "Topic {$currentTopic} not found!");
        }
    }

    /**
     * @return TopicSchemaInterface
     * @throws TopicException
     * @throws \ReflectionException
     */
    public function getTopicSchema(): TopicSchemaInterface
    {
        if($this->topicSchema instanceof TopicSchemaInterface) {
            return $this->topicSchema;
        }
        $reflection = new \ReflectionClass($this->getTopicConfiguration()['schema']);
        $this->topicSchema = $reflection->newInstance();
        return $this->topicSchema;
    }

    /**
     * Loads the configuration for the current topic
     *
     * @return array
     * @throws TopicException
     */
    public function getTopicConfiguration(): array
    {
        if($this->topicConfiguration !== NULL) {
            return $this->topicConfiguration;
        }

        $topic = $this->route('topic');
        $availableTopics = config('pubsub.topics');

        if(array_key_exists($topic, $availableTopics)) {
            $this->topicConfiguration = $availableTopics[$topic];

            return $this->topicConfiguration;
        }

        throw new TopicException("Topic {$topic} not found in configuration!");
    }

    /**
     * Returns the request data for validation
     *
     * @return array|mixed
     * @throws TopicException
     */
    public function validationData()
    {
        if($this->has('payload')) {
            return $this->get('payload');
        }

        throw new TopicException("No payload was found on request!");
    }

    /**
     * Validates the given action against the allowed permissions
     *
     * @param string $action
     * @return bool
     * @throws TopicException
     */
    protected function authorizeRequestAction(string $action): bool
    {
        $token = $this->bearerToken();

        if($token === null) {
            return false;
        }

        $config = $this->getTopicConfiguration();

        if(!array_key_exists($token, $config['tokens'])) {
            return false;
        }

        return in_array($action, $config['tokens'][$token]['permissions']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \App\Exceptions\TopicException
     */
    public function rules(): array
    {
        return $this->getTopicSchema()->getRules();
    }
}
