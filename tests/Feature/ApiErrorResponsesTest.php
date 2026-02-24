<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiErrorResponsesTest extends TestCase
{
    public function test_api_returns_json_404_instead_of_html(): void
    {
        $response = $this->getJson('/api/this-route-does-not-exist');

        $response->assertNotFound()
            ->assertJson([
                'message' => 'Not Found.',
            ]);
    }

    public function test_validation_errors_are_returned_as_json_422(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name',
                    'email',
                    'password',
                ],
            ]);
    }
}