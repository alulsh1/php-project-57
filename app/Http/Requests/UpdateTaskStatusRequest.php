<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusRequest extends FormRequest
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
            "name" => "required | unique:task_statuses",
        ];
    }
    public function messages()
    {
        //метод настройки сообщений об ошибках
        return [
            "name.unique" => "Статус с таким именем уже существует",
        ];
    }
}
