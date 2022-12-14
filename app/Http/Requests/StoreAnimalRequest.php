<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimalRequest extends FormRequest
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
            'breed' => 'required',
            'sex' => 'required|max:1',
            'weight' => 'required|max:7',
            'age' => 'required',
            'description' => 'nullable|max:128',
            'adopted' => 'required|boolean',
            'animal_size_id' => 'required',
            'species_id' => 'required',
            'user_id' => 'required',
            'images' => 'required|array',
            'images.*' => 'image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'breed.required' => 'O campo raça é obrigatório',
            'sex.required' => 'O campo sexo é obrigatório',
            'weight.required' => 'O campo peso é obrigatório',
            'age.required' => 'O campo idade é obrigatório',
            'picture_1.required' => 'Foto 1 é obrigatório',
            'picture_2.required' => 'Foto 2 é obrigatório',
            'description.max' => 'O campo descrição pode ter até 128 caracteres.',
            'adopted.required' => 'O campo adotado é obrigatório',
            'animal_size_id.required' => 'O campo porte do animal é obrigatório',
            'species_id.required' => 'O campo espécie é obrigatório',
            'user_id.required' => 'O id do usuário é obrigatório',
            'images.required' => 'É obrigatório utilizar ao menos uma foto para cadastrar o animal',
            'images.*.image' => 'Arquivo inválido'
        ];
    }
}
