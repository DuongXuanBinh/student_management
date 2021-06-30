<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Repositories\RepositoryInterface\ResultRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $_subjectRepository;
    protected $_resultRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository, ResultRepositoryInterface $resultRepository)
    {
        $this->_resultRepository = $resultRepository;
        $this->_subjectRepository = $subjectRepository;
    }

    public function index()
    {
        $subjects = $this->_subjectRepository->index();

        return view('department', compact('subjects'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validated();
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $this->_subjectRepository->createSubject($request->all());

            return back()->with('notification', 'Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $request->validated();
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('notification', 'Failed');
        } else {
            $id = $request->id;
            $result = $this->_subjectRepository->updateSubject($id, $request->all());
            if ($result === false) {
                return back()->with('notification', 'Update Failed');
            } else {
                return back()->with('notification', 'Update Successfully');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_result = $this->_resultRepository->deleteSubjectResult($id);
        $delete_subject = $this->_subjectRepository->deleteSubject($id);
        if ($delete_subject === true && $delete_result === true) {
            return back()->with('notification', 'Delete Successfully');
        } else {
            return back()->with('notification', 'Delete Failed');
        }
    }
}
