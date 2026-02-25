<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Domain\Auth\DTO\RegisterData;
use App\Domain\Auth\Services\AuthService;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthResource;

class RegisterController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function store(RegisterRequest $request)
    {
        return 
        (
            new AuthResource($this->authService->register(RegisterData::fromArray($request->validated())))
        )
            ->response()
            ->setStatusCode(201);
    }
}
