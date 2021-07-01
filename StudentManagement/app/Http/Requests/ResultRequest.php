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
        $student_id = $this->student_id;
        $subject_id = $this->subject_id;
        return [
            'student_id' => 'required|exists:students,id',
            'subject_id' => ['required', 'exists:subjects,id', Rule::unique('results')->where(function ($query) use ($student_id, $subject_id) {
                return $query->where('student_id', '=', $student_id)
                    ->where('subject_id', '=', $subject_id);
            })->ignore($this->id)],
            'mark' => 'required|numeric|min:0|max:10',
        ];
    }
}
