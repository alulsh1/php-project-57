<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
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
            //   'name' => 'required | unique:tasks,name,'.$this->task->id,

            "name" => [
                "required",
                Rule::unique("tasks")->ignore($this->task->id),
            ],
            "description" => "nullable|string",
            "status_id" => "required",
            "assigned_to_id" => "nullable|integer",
        ];
    }
    public function messages()
    {
        return [
            "name.unique" => "Задача с таким именем уже существует",
        ];
    }
}
