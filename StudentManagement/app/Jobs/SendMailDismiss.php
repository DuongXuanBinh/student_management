<?php

namespace App\Jobs;

use App\Models\Result;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendMailDismiss implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $id)
    {
        $this->_id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $student_ids = $this->_id;
        foreach ($student_ids as $student_id){
            $student = Student::where('id','=',$student_id)->first();
            $department = Student::join('departments','students.department_id','departments.id')
                ->where('students.id','=',$student_id)->first();
            $results = Result::join('subjects','subjects.id','results.subject_id')->where('student_id','=',$student_id)->get();
            $gpa = Result::select(DB::raw('avg(mark) as average_mark'))->where('student_id','=',$student_id)->first();
            Mail::send('mail.mail_dismiss',['student'=>$student,'department'=>$department,'results'=>$results,'gpa'=>$gpa],function ($message) use ($student) {
                $message->from('xuanbinh1011@gmail.com','ABC University');
                $message->to($student->email);
                $message->subject('Mail of Dismissal');
            });
        }
    }
}
