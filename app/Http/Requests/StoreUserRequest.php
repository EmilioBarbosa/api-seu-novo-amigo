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
            'email' => 'required|unique:App\Models\User',
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
            'name.required' => 'o campo nome é obrigatório',
            'email.required' => 'o campo email é obrigatório',
            'email.unique' => 'o endereço de email já existe',
            'description.max' => 'a descrição precisa ser menor ou igual que 64 caracteres',
            'password.required' => 'o campo senha é obrigatório',
            'password.min' => 'a senha precisa ser de no mínimo 8 caracteres',
            'phone_number.required' => 'o número de telefone é obrigatório para cadastrar o usuário',
            'phone_number.max' => 'o número do telefone deve ter no máximo 16 caracteres',
            'phone_number.min' => 'o número de telefone deve ter no mínimo 13 caracteres',
            'phone_number_whatsapp.required' => 'o campo para informar se o telefone é whatsapp é obrigatório',
            'phone_number_whatsapp.boolean' => 'valor inválido',
            'street.required' => 'o campo rua é obrigatório',
            'neighborhood' => 'o campo bairro é obrigatório',
            'city_id.required' => 'o id da cidade é obrigatório',
            'city_id.max' => 'o id da cidade pode ter no máximo 2 caracteres'
        ];
    }
}
