<?php
namespace App\Http\Queries;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TopicSubscribersQuery
{
    protected ?Builder $builder = null;

    public function __construct(Request $request)
    {
        $route = $request->route();
        $topicId = $route->originalParameter('topic');

        $this->builder = User::query()
            ->whereRelation('topics', 'topics.id', $topicId)
            ->when($request->limit, fn ($query, $limit) => $query->limit($limit))
            ->when($request->offset, fn ($query, $offset) => $query->offset($offset));
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
    }
}
