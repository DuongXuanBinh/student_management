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
use Illuminate\Support\Facades\Mail;

class SendMailDismiss implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_student;
    protected $_result;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Student $student, Result $result)
    {
        $this->_student = $student;
        $this->_result = $result;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('mail_dismiss',[],function ($message){
            $message->to();
            $message->subject('Mail of Dismissal');
        });
    }
}
