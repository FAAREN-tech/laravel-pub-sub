<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PubSub\TopicPublishController;

Route::middleware(['publishes_topics'])
    ->group(function() {
       Route::post('/{topic}', [TopicPublishController::class, 'publish']);
    });
