<?php

namespace App\Domain\Auth\Repositories;

use App\Models\User;

interface UserRepository
{
    public function create(array $attributes): User;

    public function findByEmail(string $email): ?User;

    public function existsByEmail(string $email): bool;
}