<?php

namespace App\Models\PubSub;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as MongoModel;

abstract class BaseTopic extends MongoModel
{
    use HasFactory;
}
