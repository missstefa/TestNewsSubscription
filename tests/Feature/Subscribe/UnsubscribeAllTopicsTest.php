<?php

namespace Tests\Feature;

use App\Http\Controllers\Subscribe\SubscribeController;
use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;

class UnsubscribeAllTopicsTest extends TestCase
{
    public function route(array $params = []): string
    {
        return action([SubscribeController::class, 'unsubscribeAll'], $params);
    }

    public function test_user_can_unsubscribe_from_all_topics()
    {
        $user = User::factory()
            ->has(Topic::factory()->count($count = $this->faker->randomDigitNotZero()))
            ->createOne();

        $this->assertDatabaseCount(Topic::TOPIC_USER_TABLE, $count );

        $this->actingAs($user)->postJson($this->route());

        $this->assertDatabaseCount(Topic::TOPIC_USER_TABLE, 0);
    }
}
