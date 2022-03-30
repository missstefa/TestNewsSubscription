<?php
namespace App\Http\Queries;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserTopicsQuery
{
    protected ?Builder $builder = null;

    public function __construct(Request $request)
    {
        $this->builder = Topic::query()
            ->whereRelation('users', 'users.id', $request->user()->id)
            ->when($request->limit, fn ($query, $limit) => $query->limit($limit))
            ->when($request->offset, fn ($query, $offset) => $query->offset($offset));
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
    }
}
