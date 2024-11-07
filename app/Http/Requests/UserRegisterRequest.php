<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'max:20'],
            'email' => ['nullable', 'max:200', 'email'],
            'password' => ['required', 'max:20'],
            'auth_token' => ['required', 'max:20'],
            'device_token' => ['nullable', 'max:20']
        ];
    }
}
