<?php

namespace App\Http\Controllers\Api;

use App\Domain\Auth\DTO\LoginData;
use App\Domain\Auth\DTO\RegisterData;
use App\Domain\Auth\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register(RegisterData::fromArray($request->validated()));

        return (new AuthResource($result))
            ->response()
            ->setStatusCode(201);
    }

    public function login(LoginRequest $request): AuthResource
    {
        $result = $this->authService->login(LoginData::fromArray($request->validated()));

        return new AuthResource($result);
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $this->authService->logout($user, $user->currentAccessToken()?->id);

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
