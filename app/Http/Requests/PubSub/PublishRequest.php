<?php

namespace App\Http\Requests\PubSub;

use App\Exceptions\TopicException;
use Illuminate\Foundation\Http\FormRequest;

class PublishRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->authorizeRequestAction('publish');
        //$this->authorizeRequestAction('subscribe);
    }
}
