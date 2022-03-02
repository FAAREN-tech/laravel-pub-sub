<?php

namespace App\Topics;

use App\Exceptions\TopicException;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

abstract class Topic
{
    /**
     * Title for this topic
     * @var string|null
     */
    protected ?string $title = null;

    /**
     * Slug for this topic
     * @var string|null
     */
    protected ?string $slug = null;

    /**
     * Description for this topic
     * @var string|null
     */
    protected ?string $description = null;

    /**
     * Number of attempts to send an event to each subscriber
     * @var int
     */
    protected int $max_tries = 6;

    /**
     * Seconds between two sending attempts
     * @var int
     */
    protected int $time_between_retries = 5;

    /**
     * List of tokens allowed to access this topic
     *
     * @var array
     */
    protected array $tokens = [];

    /**
     * Returns the relevant rules for this topic
     *
     * @return array
     */
    abstract public function getRules(): array;

    /**
     * Returns the relevant response data
     *
     * @param \stdClass $event
     * @return array
     */
    abstract public function getResponseData(\stdClass $event): array;

    /**
     * Returns the title for this topic
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title
            ??
            Str::ucfirst(
                class_basename(self::class)
            );
    }

    /**
     * Returns the slug for this topic
     *
     * @return string
     */
    public function getSlug(): string
    {
        return Str::lower($this->getTitle());
    }

    /**
     * Returns the topic's description
     *
     * @return string|null
     */
    public function getDescription(): string|null
    {
        return $this->description;
    }

    /**
     * Returns the maximum number of retries
     *
     * @return int
     */
    public function getMaxTries(): int
    {
        return $this->max_tries;
    }

    /**
     * Returns the time in seconds between two attempts
     *
     * @return int
     */
    public function getTimeBetweenRetries(): int
    {
        return $this->time_between_retries;
    }

    /**
     * Checks if a given token has the given permission
     *
     * @param string $token
     * @param string $ability
     * @return bool
     * @throws TopicException
     */
    public function hasTokenAbility(string $token, string $ability): bool
    {
        if (!self::tokenExists($token)) {
            throw new TopicException("Given token does not exist on current topic");
        }
        return in_array('*', self::getTokens()[$token]) || in_array($ability, self::getTokens()[$token]);
    }

    /**
     * Checks if a given token exists on this topic
     *
     * @param string $token
     * @return bool
     */
    #[Pure] public function tokenExists(string $token): bool
    {
        return array_key_exists($token, $this->getTokens());
    }

    /**
     * Returns a list of allowed tokens
     *
     * @return array
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * Returns an instance of App\Topics\Topic for a given topic-slug
     *
     * @param string $topicSlug
     * @return Topic
     * @throws TopicException
     * @throws \ReflectionException
     */
    public static function getTopicBySlug(string $topicSlug): Topic
    {
        $topicClassReflection = new \ReflectionClass(
            config('pubsub.topics.' . $topicSlug)
        );

        $topic = $topicClassReflection->newInstance();
        if (!$topic instanceof Topic) {
            throw new TopicException("Provided class for topic {$topicSlug} is not an instance of App\\Topics\\Topic");
        }
        return $topic;
    }

    /**
     * Checks if a topic exists by a given topic-slug
     * @param string $topicSlug
     * @return bool
     */
    public static function topicExists(string $topicSlug): bool
    {
        return array_key_exists($topicSlug, config('pubsub.topics'));
    }

    public static function bySlug(string $slug)
    {
        $topic = self::getTopicBySlug($slug);
        return new $topic();
    }
}
