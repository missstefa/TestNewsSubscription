<?php

namespace App\Http\Controllers\Subscribe;

use App\Http\Controllers\Controller;
use App\Http\Queries\UserTopicsQuery;
use App\Http\Requests\IndexUserTopicsRequest;
use App\Http\Responses\TopicStrategyResource;

class SubscriberTopicsController extends Controller
{
    public function index(IndexUserTopicsRequest $request, UserTopicsQuery $query)
    {
        return TopicStrategyResource::response($query->getBuilder()->get(), $request->header('accept'));
    }
}
