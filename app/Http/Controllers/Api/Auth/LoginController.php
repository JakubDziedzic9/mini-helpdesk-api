<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Domain\Auth\DTO\LoginData;
use App\Domain\Auth\Services\AuthService;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function store(LoginRequest $request): AuthResource
    {
        return new AuthResource($this->authService->login(LoginData::fromArray($request->validated())));
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        $this->authService->logout($user, $user->currentAccessToken()?->id);

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
