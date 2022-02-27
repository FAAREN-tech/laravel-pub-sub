# Laravel PubSub

## Open Tasks

- Topic Validator
- TopicInterface
- Token generator
- Token Handling (from config to database or something else?)
- Mongo Driver
- Implement `make:topic` command
  - creates Model 
  - creates Schema

## Handling

### Topic Schemas

Each topic must implement the [TopicModelInterface](app/Interfaces/PubSub/TopicModelInterface.php).

Each topic needs a topic schema which implements the [TopicSchemaInterface](app/Interfaces/PubSub/TopicSchemaInterface.php). They should be placed within `app/TopicSchemas/`

This interface requires 2 methods. 

First one is `getRules()` which must return an array of rules any new event is validated against. Here you can use the standard Laravel validation rules. Of course, you can create your own custom rules.

Second one is `getResponseData()`. This function must return an array. It will receive the event from the database and build the response. Here you can set default values. This response is validated against the rules defined in `geRules()` to make sure, the responses match the incoming requests.
