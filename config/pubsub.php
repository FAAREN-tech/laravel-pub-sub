<?php

return [

    'general' => [
        /**
         * Can topics created on the fly with default configuration?
         */
        'create_topics_on_the_fly' => false,

        /**
         * Used as default or fallback configuration
         */
        'default_topic_configuration' => [
            'max_retries' => 5, // Number of retries before a message is marked as undeliverable
            'time_between_retries' => 60, // Time in seconds between two sending attempts
        ]
    ],

    /**
     * List of available topics
     */
    'topics' => [
        'example' => [
            'title' => 'Example Topic', // Used as display name
            'slug' => 'example', // Used as endpoint you can communicate with
            'description' => 'An example topic', // Optional
            'max_tries' => 6, // Optional. Will override default configuration
            'time_between_retries' => 5, // Optional. Will override default configuration
            'schema' => \App\TopicSchemas\ExampleSchema::class,
            'tokens' => [ // A list of tokens allowed to communicate with this topic
                'UbCYnMAcNEe7XZ6NPbBw8sr9jt97DxwLcs42fzFXGjrYV4yzvMq9c8t4xvDeQCb8' => [
                    'permissions' => [
                        'subscribe',
                        'publish'
                    ]
                ]
            ]
        ]
    ]
];
