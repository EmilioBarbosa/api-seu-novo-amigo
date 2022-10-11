<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
            'name' => 'required',
            'email' => 'required|unique:App\Models\User|email:rfc',
            'description' => 'nullable|max:64',
            'password' => 'required|min:8',
            'phone_number' => 'required|max:16|min:13',
            'phone_number_whatsapp' => 'required|boolean',
            'street' => 'required',
            'neighborhood' => 'required',
            'city_id' => 'required|max:2'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo email é obrigatório',
            'email.unique' => 'O endereço de email já existe',
            'email.email' => 'Endereço de email inválido',
            'description.max' => 'A descrição precisa ser menor ou igual que 64 caracteres',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'A senha precisa ser de no mínimo 8 caracteres',
            'phone_number.required' => 'O número de telefone é obrigatório para cadastrar o usuário',
            'phone_number.max' => 'O número do telefone deve ter no máximo 16 caracteres',
            'phone_number.min' => 'O número de telefone deve ter no mínimo 13 caracteres',
            'phone_number_whatsapp.required' => 'O campo para informar se o telefone é whatsapp é obrigatório',
            'phone_number_whatsapp.boolean' => 'Valor inválido',
            'street.required' => 'O campo rua é obrigatório',
            'neighborhood' => 'O campo bairro é obrigatório',
            'city_id.required' => 'O id da cidade é obrigatório',
            'city_id.max' => 'O id da cidade pode ter no máximo 2 caracteres'
        ];
    }
}
