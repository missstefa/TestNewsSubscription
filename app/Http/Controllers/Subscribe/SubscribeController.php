<?php

namespace App\Http\Controllers\Subscribe;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Topic;

class SubscribeController extends Controller
{
    public function subscribe(Topic $topic): UserResource
    {
        $user = auth()->user();
        $user->topics()->attach($topic);

        return new UserResource($user);
    }

    public function unsubscribe(Topic $topic): UserResource
    {
        $user = auth()->user();
        $user->topics()->detach($topic);

        return new UserResource($user);
    }

    public function unsubscribeAll(): UserResource
    {
        $user = auth()->user();
        $user->topics()->detach();

        return new UserResource($user);
    }
}
