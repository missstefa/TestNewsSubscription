<?php
namespace App\Http\Responses;

use App\Http\Resources\UserResource;
use Illuminate\Support\Collection;

class UserStrategyResource
{
    public static function response(Collection $data, string $type = null)
    {
        switch ($type)
        {
            case 'application/json':
                return UserResource::collection($data);
            case 'application/xml':
                return response()->xml(['data' => UserResource::collection($data)->jsonSerialize()]);
            default:
                return UserResource::collection($data);
        }
    }
}
