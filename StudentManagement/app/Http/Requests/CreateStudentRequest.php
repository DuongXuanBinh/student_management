<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStudentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:30',
            'department_id' => ['required', Rule::in(Department::pluck('id')->toArray())],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'gender' => ['required', Rule::in(['0', '1'])],
            'birthday' => 'required|date',
            'address' => 'required',
            'phone' => ['required', 'regex:/^(09)[0-9]{8}$/', Rule::unique('students', 'phone')],
        ];
    }
}
