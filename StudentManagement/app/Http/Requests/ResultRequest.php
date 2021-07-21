<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ResultRequest extends FormRequest
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
            'student_id' => 'exists:students,id',
            'subject_id.*' => ['exists:subjects,id'],
            'mark.*' => ['numeric', 'min:0', 'max:10'],
        ];
    }

//    public function messages()
//    {
//        return [
//            'mark.*.numeric' => ':attribute at must be number',
//            'mark.*.min' => ':attribute must be greater or equal to 0',
//            'mark.*.max' => ':attribute must be less than or equal to 10',
//        ];
//    }
}
