<?php

namespace Tests\Feature;

use App\Http\Controllers\Subscribe\SubscribeController;
use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;

class SubscribeTopicTest extends TestCase
{
    public function route(array $params = []): string
    {
        return action([SubscribeController::class, 'subscribe'], $params);
    }

    public function test_user_can_subscribe_to_topic()
    {
        $user = User::factory()->createOne();
        $topic = Topic::factory()->createOne();

        $this->actingAs($user)->postJson($this->route(['topic' => $topic]));

        $this->assertDatabaseHas(Topic::TOPIC_USER_TABLE, ['topic_id' => $topic->id, 'user_email' => $user->email] );
    }
}
