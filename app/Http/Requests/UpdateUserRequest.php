<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\UserCanOnlyUpdateHimself;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;


    public function authorize()
    {
        return true;
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['id'] = $this->route('user')->id;

        return $data;
    }

    public function rules()
    {
        $user_token = str_replace('Bearer ', '', $this->header('authorization'));
        return [
            'id' => [new UserCanOnlyUpdateHimself($this->user, $user_token)],
            'name' => 'required',
            'email' => [
                'required',
                'email:rfc',
                Rule::unique('users')->ignore($this->user->id, 'id'),
            ],
            'description' => 'nullable|max:64',
            'phone_number' => 'required|max:11|min:10',
            'phone_number_whatsapp' => 'required|boolean',
            'street' => 'required',
            'neighborhood' => 'required',
            'city_id' => 'required',
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
            'phone_number.required' => 'O número de telefone é obrigatório para cadastrar o usuário',
            'phone_number.max' => 'O número do telefone deve ter no máximo 11 caracteres',
            'phone_number.min' => 'O número de telefone deve ter no mínimo 10 caracteres',
            'phone_number_whatsapp.required' => 'O campo para informar se o telefone é whatsapp é obrigatório',
            'phone_number_whatsapp.boolean' => 'Valor inválido',
            'street.required' => 'O campo rua é obrigatório',
            'neighborhood' => 'O campo bairro é obrigatório',
            'city_id.required' => 'O id da cidade é obrigatório',
        ];
    }
}
