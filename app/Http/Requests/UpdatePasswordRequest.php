<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    protected $errorBag = 'password';

    public function authorize(): bool
    {
        return auth()->user()->is($this->user);
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', Password::defaults()],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
