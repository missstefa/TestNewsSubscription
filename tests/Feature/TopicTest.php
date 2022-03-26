<?php

namespace Tests\Feature;

use App\Http\Controllers\TopicController;
use App\Models\Topic;
use Tests\TestCase;

class TopicTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function route(array $params = []): string
    {
        return action([TopicController::class, 'index'], $params);
    }

    public function test_it_can_1()
    {

    }
}
