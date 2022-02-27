<?php

namespace App\Models\PubSub;

use App\Interfaces\PubSub\TopicModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExampleTopic extends BaseTopic implements TopicModelInterface
{
    use HasFactory;
}
