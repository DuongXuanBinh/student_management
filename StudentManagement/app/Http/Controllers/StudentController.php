<?php

namespace App\Http\Controllers;

use App\Repositories\Repository_Interface\StudentRepositoryInterface;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $_studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->_studentRepository = $studentRepository;
    }

    public function index(){
        $indices = $this->_studentRepository->getAll();

        return view('student',compact($indices));
    }

    public function findByAgeRange(Request $request)
    {
        $from = $request -> from;
        $to = $request ->to;
        $students = $this->_studentRepository->findStudentByAgeRange($from, $to);

        return back()->with($students);
    }

    public function findByMobileOperator($operator){
//        $operator = $request -> operator;
        $students = $this->_studentRepository->findStudentByPhone($operator);

        dd($students);
        return back()->with($students);
    }

}
