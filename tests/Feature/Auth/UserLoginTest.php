<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserLoginTest extends TestCase
{

    public function route(array $params = []): string
    {
        return action([AuthController::class, 'login'], $params);
    }

    public function test_user_can_login()
    {
        $user = User::factory(['password' => Hash::make($password = $this->faker->word)])
            ->createOne();

        $response = $this->postJson($this->route(), ['email' => $user->email, 'password' => $password])
            ->assertJsonFragment(['email' => $user->email])
            ->assertOk();

        $token = $response->json('data.token');
        $token = hash('sha256', ltrim(stristr($token, '|'), '|'));

        $this->assertDatabaseHas('personal_access_tokens', ['tokenable_id' => $user->id, 'token' => $token]);
    }
}
