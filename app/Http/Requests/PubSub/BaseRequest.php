<?php

namespace App\Http\Requests\PubSub;

use App\Exceptions\TopicException;
use App\Interfaces\PubSub\TopicInterface;
use App\Topics\Topic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

abstract class BaseRequest extends FormRequest
{
    /**
     * Authorizes the current request
     *
     * @return bool
     * @throws TopicException
     */
    protected function authorize()
    {
        if ($this->bearerToken() === null) {
            return false;
        }

        return Topic::bySlug($this->route('topic'))
            ->hasTokenAbility($this->bearerToken(), 'publish');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws \App\Exceptions\TopicException
     */
    public function rules(): array
    {
        return Topic::bySlug($this->route('topic'))
            ->getRules();
    }

    /**
     * Returns the request data for validation
     *
     * @return array
     * @throws TopicException
     */
    public function validationData(): array
    {
        if ($this->has('payload')) {
            return $this->get('payload');
        }

        throw new TopicException("No payload was found on request!");
    }

    public function wantsJson(): bool
    {
        return true;
    }

    public function expectsJson(): bool
    {
        return true;
    }
}
