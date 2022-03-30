<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {

        $user = User::query()
            ->where('email', $request->get('email'))
            ->first();

        if(!$user || !Hash::check($request->get('password'), $user->password))
        {
            return response()->json(['message' => '422: Неправильный логин или пароль'], Response::HTTP_BAD_REQUEST);
        }

        $user->tokens()->delete();
        $token = $user->createToken('myapptocken')->plainTextToken;
        $user->token = $token;

        return new AuthResource($user);
    }

    public function logout(): Response
    {
        auth()->user()->tokens()->delete();

        return response()->noContent();
    }
}
