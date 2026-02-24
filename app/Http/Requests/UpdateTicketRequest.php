<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'status' => ['sometimes', 'in:open,in_progress,resolved,closed'],
            'priority' => ['sometimes', 'in:low,normal,high'],
            'assignee_id' => ['sometimes', 'nullable', 'exists:users,id'],
        ];
    }
}