<?php

namespace App\Domain\Auth\Services;

use App\Domain\Auth\DTO\LoginData;
use App\Domain\Auth\DTO\RegisterData;
use App\Domain\Auth\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    public function __construct(
        private readonly UserRepository $users
    ) {}

    public function register(RegisterData $data): array
    {
        $user = $this->users->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function login(LoginData $data): array
    {
        $user = $this->users->findByEmail($data->email);

        if (!$user || !Hash::check($data->password, $user->password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $tokenName = $data->deviceName ?: 'api';
        $token = $user->createToken($tokenName)->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout(User $user, ?int $currentTokenId): void
    {
        if ($currentTokenId) {
            $user->tokens()->whereKey($currentTokenId)->delete();
            return;
        }

        $user->tokens()->delete();
    }
}
