<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $name = $this->name;
        $department_id = $this->department_id;
        return [
            'name' => 'required',
            'department_id' => ['required', Rule::unique('subjects')->where(function ($query) use ($name, $department_id) {
                return $query->where('name', '=', $name)->where('department_id', '=', $department_id);
            })->ignore($this->id)],
        ];
    }
}
