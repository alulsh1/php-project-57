<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLabelRequest extends FormRequest
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
            "name" => [
                "required",
                Rule::unique("labels")->ignore($this->label->id),
            ],
            "description" => "nullable|string",
        ];
    }
    public function messages()
    {
        //метод настройки сообщений об ошибках
        return [
            "name.unique" => "Метка с таким именем уже существует",
        ];
    }
}
