<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user_id = isset($this->user) ? $this->user : null;
        
        return [
            'email' => 'required|string|email|unique:users,email,'.$user_id.',id',
            'name' => 'required|string|alpha_spaces',
            'roles' => 'required|array',
            'roles.*' => 'integer',
            'password' => [
                (!$user_id ? 'required' : ''),
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ]
        ];
    }
}
