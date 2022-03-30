<?php

namespace Tests\Feature;

use App\Http\Controllers\Subscribe\SubscriberTopicsController;
use App\Models\Topic;
use App\Models\User;
use SimpleXMLElement;
use Tests\TestCase;

class SeeAllSubscriptionTopicsTest extends TestCase
{
    public function route(array $params = []): string
    {
        return action([SubscriberTopicsController::class, 'index'], $params);
    }

    public function test_user_can_see_all_subscription_topics_xml()
    {
        $user = User::factory()->createOne();
        $topics = Topic::factory()
            ->count($topicsCount = $this->faker->randomDigitNotZero())
            ->hasAttached($user)
            ->create();

        $response = $this->actingAs($user)
            ->withHeaders(['accept' => 'application/xml'])
            ->get($this->route(),
                [
                    'limit' => $this->faker->numberBetween(1, $topicsCount),
                    'offset' => $this->faker->numberBetween(1, $topicsCount)
                ]);

        $xmlContent = new SimpleXMLElement($response->getContent());

        $topics->each(function (Topic $topic, $key) use ($xmlContent) {
            $this->assertEquals($topic->id, (int)$xmlContent->data[$key]->id);
        });
    }

    public function test_user_can_see_all_subscription_topics_json()
    {
        $user = User::factory()->createOne();
        $topics = Topic::factory()
            ->count($topicsCount = $this->faker->randomDigitNotZero())
            ->hasAttached($user)
            ->create();

        $response = $this->actingAs($user)
            ->withHeaders(['accept' => 'application/json'])
            ->get($this->route(),
                [
                    'limit' => $this->faker->numberBetween(1, $topicsCount),
                    'offset' => $this->faker->numberBetween(1, $topicsCount)
                ]);

        $topics->each(function (Topic $topic) use ($response) {
            $response->assertJsonFragment(['id' => $topic->id]);
        });
    }
}
