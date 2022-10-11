<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'email' => [
                'required',
                'email:rfc',
                Rule::unique('users')->ignore($user->id, 'id'),
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'O endereço de email já existe'
        ];
    }
}
