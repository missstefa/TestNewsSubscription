<?php

namespace App\Http\Controllers\Subscribe;

use App\Http\Controllers\Controller;
use App\Http\Queries\TopicSubscribersQuery;
use App\Http\Requests\IndexTopicSubcribersRequest;
use App\Http\Responses\UserStrategyResource;
use App\Models\Topic;

class TopicSubscribersController extends Controller
{
    public function index(Topic $topic, IndexTopicSubcribersRequest $request, TopicSubscribersQuery $query)
    {
        return UserStrategyResource::response($query->getBuilder()->get(), $request->header('accept'));
    }
}
