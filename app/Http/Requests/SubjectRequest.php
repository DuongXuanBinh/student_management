<?php

namespace App\Http\Requests;

use App\Models\Department;
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
        return true;
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
        $department_ids = Department::all()->pluck('id')->toArray();
        return [
            'name' => 'required|string|min:5|max:30',
            'department_id' => ['required', Rule::in($department_ids),Rule::unique('subjects')->where(function ($query) use ($name, $department_id) {
                return $query->where('name', '=', $name)->where('department_id', '=', $department_id);
            })->ignore($this->id)],
        ];
    }
}
