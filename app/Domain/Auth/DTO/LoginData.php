<?php

namespace App\Domain\Auth\DTO;

final class LoginData
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $deviceName,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            deviceName: $data['device_name'] ?? null,
        );
    }
}
