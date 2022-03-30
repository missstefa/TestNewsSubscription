<?php
namespace App\Http\Responses;

use App\Http\Resources\TopicResource;
use Illuminate\Support\Collection;

class TopicStrategyResource
{
    public static function response(Collection $data, string $type = null)
    {
        switch ($type)
        {
            case 'application/json':
                return TopicResource::collection($data);
            case 'application/xml':
                return response()->xml(['data' => TopicResource::collection($data)->jsonSerialize()]);
            default:
                return TopicResource::collection($data);
        }
    }
}
