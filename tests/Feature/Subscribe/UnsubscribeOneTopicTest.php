<?php

namespace Tests\Feature;

use App\Http\Controllers\Subscribe\SubscribeController;
use App\Models\Topic;
use App\Models\User;
use Tests\TestCase;

class UnsubscribeOneTopicTest extends TestCase
{

    public function route(array $params = []): string
    {
        return action([SubscribeController::class, 'unsubscribe'], $params);
    }

    public function test_user_can_unsubscribe_from_one_topic()
    {
        $user = User::factory()
            ->hasAttached($topicOne = Topic::factory()->createOne())
            ->hasAttached($topicTwo = Topic::factory()->createOne())
            ->createOne();

        $this->actingAs($user)->postJson($this->route(['topic' => $topicOne]));

        $this->assertDatabaseMissing(Topic::TOPIC_USER_TABLE, ['topic_id' => $topicOne->id] );
        $this->assertDatabaseHas(Topic::TOPIC_USER_TABLE, ['topic_id' => $topicTwo->id] );
    }
}
