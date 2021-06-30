@extends('layout.admin_template')

@section('content')
    {{--Delete pop-up--}}
    <div class="modal fade" id="delete-student" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Student</h4>
                </div>
                <form method="get" action="student/delete">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id">
                                <p>Are you sure to delete this student?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="row col-md-6">
                <a data-toggle="modal" href="" class="add-student">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-plus-square" viewBox="0 0 16 16">
                        <path
                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </a>
            </div>
            <div class="row col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <a class="filter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-funnel"
                                 viewBox="0 0 16 16">
                                <path
                                    d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                            </svg>
                            Filter</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 filter-student">
                        <form method="get" action="/student/filter">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="age-range">Age Range: </label>
                                </div>
                                <div class="col-md-8">
                                    <label for="age-from">From: </label>
                                    <input type="text" name="age_from">
                                    <label for="age-to">To: </label>
                                    <input type="text" name="age_to">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="mark-range">Mark Range: </label>
                                </div>
                                <div class="col-md-8">
                                    <label for="mark-from">From: </label>
                                    <input type="text" name="mark_from">
                                    <label for="mark-to">To: </label>
                                    <input type="text" name="mark_to">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="mark-range">Mobile Number: </label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-check-input" type="checkbox" name="mobile_network[]" id="viettel"
                                           value="viettel">
                                    <label class="form-check-label" for="inlineCheckbox1">Viettel</label>
                                    <input class="form-check-input" type="checkbox" name="mobile_network[]"
                                           id="vinaphone" value="vinaphone">
                                    <label class="form-check-label" for="inlineCheckbox2">Vinaphone</label>
                                    <input class="form-check-input" type="checkbox" name="mobile_network[]"
                                           id="mobiphone" value="mobiphone">
                                    <label class="form-check-label" for="inlineCheckbox3">Mobiphone</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Status: </label>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-check-input" type="checkbox" name="status[]" id="complete"
                                           value="complete">
                                    <label class="form-check-label" for="complete">Complete</label>
                                    <input class="form-check-input" type="checkbox" name="status[]" id="in-progress"
                                           value="in-progress">
                                    <label class="form-check-label" for="in-progress">In-progress</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-student">
                <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>department</th>
                    <th>email</th>
                    <th>gender</th>
                    <th>birthday</th>
                    <th>address</th>
                    <th>phone</th>
                    <th style="width: 45px"></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr class="student-details">
                        <td class="student-id">{{$student->id}}</td>
                        <td class="student-name">{{$student->name}}</td>
                        <td class="student-department">{{$student->department->name}}</td>
                        <td class="student-email">{{$student->email}}</td>
                        <td class="student-gender">{{$student->gender === 0 ? 'Female' : 'Male'}}</td>
                        <td class="student-birthday">{{$student->birthday}}</td>
                        <td class="student-address">{{$student->address}}</td>
                        <td class="student-phone">{{$student->phone}}</td>
                        <td>
                            <a data-toggle="modal" href="" class="update-student">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </a>
                            <a data-toggle="modal" href="" class="delete-student">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd"
                                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </a>
                        </td>
                        <td>
                            <form action="student/view-massive-update" method="get">
                                <input type="hidden" name="id" value="{{$student->id}}">
                                <input type="hidden" name="name" value="{{$student->name}}">
                                <input type="hidden" name="department_id" value="{{$student->department_id}}">
                                <button type="submit">Update Result</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="text-align: center">
                {{$students->links()}}
            </div>

        </div>
    </div>
    </div>

@endsection