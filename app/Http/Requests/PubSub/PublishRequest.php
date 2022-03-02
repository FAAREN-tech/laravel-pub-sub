<?php

namespace App\Http\Requests\PubSub;

use App\Exceptions\TopicException;
use App\Topics\Topic;
use Illuminate\Foundation\Http\FormRequest;

class PublishRequest extends BaseRequest
{
    /**
     * @return bool
     * @throws TopicException
     */
    public function authorize()
    {
        parent::authorize();
        return true;
    }
}
