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
            'name' => 'required|string|min:5|max:30',
            'department_id' => ['required', Rule::in(Department::pluck('id')->toArray())],
            'email' => ['required', 'email', 'max: 50', Rule::unique('users', 'email')],
            'gender' => ['required', Rule::in(['0', '1'])],
            'birthday' => 'required|date|date_format:Y-m-d|before:today|after:1980-01-01',
            'address' => 'required|string|max:50',
            'phone' => ['required', 'regex:/^(09)[0-9]{8}$/', Rule::unique('students', 'phone')],
        ];
    }
}
