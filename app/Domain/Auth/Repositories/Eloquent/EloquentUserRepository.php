<?php

namespace App\Domain\Auth\Repositories\Eloquent;

use App\Domain\Auth\Repositories\UserRepository;
use App\Models\User;

class EloquentUserRepository implements UserRepository
{
    public function create(array $attributes): User
    {
        return User::query()->create($attributes);
    }

    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    public function existsByEmail(string $email): bool
    {
        return User::query()->where('email', $email)->exists();
    }
}