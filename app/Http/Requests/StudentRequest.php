<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        $id = $this->id;
        $department_ids = Department::all()->pluck('id')->toArray();
        return [
            'name' => 'required|alpha|max:30',
            'department_id' => ['required', Rule::in($department_ids)],
            'email' => ['required', 'email', 'max:50', Rule::unique('students', 'email')->ignore($id)],
            'gender' => ['required', Rule::in(['0', '1'])],
            'birthday' => 'required|date|date_format:Y-m-d|before:today|after:1980-01-01',
            'address' => 'required|string|max:50',
            'phone' => ['required', 'regex:/^(09)[0-9]{8}$/', Rule::unique('students', 'phone')->ignore($id)],
        ];
    }
}
