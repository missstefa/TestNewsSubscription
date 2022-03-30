<?php

namespace Tests\Feature;

use App\Http\Controllers\Subscribe\TopicSubscribersController;
use App\Models\Topic;
use App\Models\User;
use SimpleXMLElement;
use Tests\TestCase;

class SeeAllTopicSubscribers extends TestCase
{
    public function route(array $params = []): string
    {
        return action([TopicSubscribersController::class, 'index'], $params);
    }

    public function test_it_can_see_all_topic_subscribers_xml()
    {
        $topic = Topic::factory()->createOne();

        $users = User::factory()
            ->count($usersCount = $this->faker->randomDigitNotZero())
            ->hasAttached($topic)
            ->create();

        $response = $this->actingAs($users->first())
            ->withHeaders(['accept' => 'application/xml'])
            ->get($this->route(['topic' => $topic->id]),
                [
                    'limit' => $this->faker->numberBetween(1, $usersCount),
                    'offset' => $this->faker->numberBetween(1, $usersCount)
                ]);

        $xmlContent = new SimpleXMLElement($response->getContent());

        $users->each(function (User $user, $key) use ($xmlContent) {
            $this->assertEquals($user->id, (int)$xmlContent->data[$key]->id);
        });
    }

    public function test_it_can_see_all_topics_subscribers_json()
    {
        $topic = Topic::factory()->createOne();
        $users = User::factory()
            ->count($usersCount = $this->faker->randomDigitNotZero())
            ->hasAttached($topic)
            ->create();

        $response = $this->actingAs($users->first())
            ->withHeaders(['accept' => 'application/json'])
            ->get($this->route(['topic' => $topic->id]),
                [
                    'limit' => $this->faker->numberBetween(1, $usersCount),
                    'offset' => $this->faker->numberBetween(1, $usersCount)
                ]);

        $users->each(function (User $user) use ($response) {
            $response->assertJsonFragment(['id' => $user->id]);
        });
    }
}
