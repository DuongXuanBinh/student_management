<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultRequest;
use App\Http\Requests\ResultRequest2;
use App\Repositories\RepositoryInterface\DepartmentRepositoryInterface;
use App\Repositories\RepositoryInterface\StudentRepositoryInterface;
use App\Repositories\RepositoryInterface\SubjectRepositoryInterface;

class ResultController extends Controller
{
    protected $_subjectRepository;
    protected $_studentRepository;
    protected $_departmentRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository,
                                StudentRepositoryInterface $studentRepository,
                                DepartmentRepositoryInterface $departmentRepository)
    {
        $this->_departmentRepository = $departmentRepository;
        $this->_subjectRepository = $subjectRepository;
        $this->_studentRepository = $studentRepository;
    }

    /**
     * Show result list
     *
     */
    public function index()
    {
        $results = $this->_studentRepository->getResult();

        return response()->view('results.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $subjects = $this->_subjectRepository->getAll();

        return response()->view('results.create', compact('subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResultRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ResultRequest2 $request)
    {
        $this->_studentRepository->createResult($request->all());

        return redirect('/results')->with('notification', 'Added Successfully');
    }


    public function show($id)
    {
        $result = $this->_studentRepository->showResult($id);

        return response()->view('results.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = $this->_studentRepository->showResult($id);
        $subjects = $this->_subjectRepository->getAll();
        return response()->view('results.edit', compact('result', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResultRequest2 $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ResultRequest2 $request)
    {
        $this->_studentRepository->updateResult($request->all());

        return redirect('/results')->with('notification', 'Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->_studentRepository->deleteResult($id);

        return redirect('/results')->with('notification', 'Delete Successfully');
    }

}
