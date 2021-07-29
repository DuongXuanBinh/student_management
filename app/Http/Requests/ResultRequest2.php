<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResultRequest2 extends FormRequest
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
        $student = Student::find($student_id)->with(['department.subjects' => function ($q) {
            $q->select('*');
        }])->first()->toArray();
        $subjects = $student['department']['subjects'];
        $subject_ids = [];
        foreach ($subjects as $subject){
            array_push($subject_ids,$subject['id']);
        }
        $subject_id = $this->subject_id;
        $id = $this->id;
        return [
            'student_id' => 'required|exists:students,id',
            'subject_id' => ['required', Rule::in($subject_ids), Rule::unique('results')->where(function ($query) use ($student_id, $subject_id) {
                 $query->where('student_id', $student_id)
                    ->where('subject_id', $subject_id);
            })->ignore($id)],
            'mark' => ['required', 'numeric', 'min:0', 'max:10']
        ];
    }
}
