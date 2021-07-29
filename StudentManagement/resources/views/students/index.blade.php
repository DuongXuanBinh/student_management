@extends(Auth::user()->hasRole('admin') ? 'layout.admin_template' : 'layout.user_template')
@section('content')
    <div class="row">
        <h3>{{__('Student List')}}</h3>
    </div>

    @if(session('notification'))
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center; font-weight: bold"
                    class="{{session('notification') === 'Failed' ? 'errorTxt' : 'successTxt'}}">{{strtoupper(session('notification'))}}</h4>
            </div>
        </div>
    @endif

    <div class="modal fade" id="dismiss-student" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('Dismiss Student')}}t</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id">
                            <p>{{__("Are you sure to send mail of dismiss all the student with GPA under 5?")}}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a>
                        <button class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                    </a>
                    <a href="{{ route('students.dismiss') }}">
                        <button class="btn btn-primary">{{__('Submit')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-student" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('Delete Student')}}</h4>
                </div>
                <form method="post" action="/">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="slug">
                                <p>{{__('Are you sure to delete this student?')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Delete')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-12">
                    <a class="filter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-funnel"
                             viewBox="0 0 16 16">
                            <path
                                d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                        </svg>
                        {{__('Filter')}}</a>
                </div>
            </div>
            <div class="row filter-student" style="margin-top: 15px">
                <form method="get" action="{{ route('students.index') }}">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="age-range">{{__('Age Range')}}:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <label for="age-from">{{__('From')}}: </label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="age-from" name="age_from" class="form-control"
                                       value="{{old('age_from')}}">
                            </div>
                            <div class="col-md-2">
                                <label for="age-to">{{__('To')}}: </label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="age-to" name="age_to" class="form-control"
                                       value="{{old('age_to')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="mark-range">{{__('Mark Range')}}: </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <label for="mark-from">{{__('From')}}: </label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="mark-from" name="mark_from" class="form-control"
                                       value="{{old('mark_from')}}">
                            </div>
                            <div class="col-md-2">
                                <label for="mark-to">{{__('To')}}: </label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="mark-to" name="mark_to" class="form-control"
                                       value="{{old('mark_to')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="mobile-number">{{__('Mobile Number')}}: </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-2">
                                <input class="form-check-input" type="checkbox" name="mobile_network[]"
                                       id="viettel"
                                       value="viettel" @if(old('mobile_network') != null) {{in_array('viettel',old('mobile_network')) === true ? 'checked' :''}} @endif>
                                <label class="form-check-label" for="viettel">Viettel</label>
                            </div>
                            <div class="col-md-10 col-md-offset-2">
                                <input class="form-check-input" type="checkbox" name="mobile_network[]"
                                       id="vinaphone"
                                       value="vinaphone" @if(old('mobile_network') != null) {{in_array('vinaphone',old('mobile_network')) === true ? 'checked' :''}} @endif>
                                <label class="form-check-label" for="vinaphone">Vinaphone</label>
                            </div>
                            <div class="col-md-10 col-md-offset-2">
                                <input class="form-check-input" type="checkbox" name="mobile_network[]"
                                       id="mobiphone"
                                       value="mobiphone" @if(old('mobile_network') != null) {{in_array('mobiphone',old('mobile_network')) === true ? 'checked' :''}} @endif>
                                <label class="form-check-label" for="mobiphone">Mobiphone</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>{{__('Status')}}: </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-2">
                                <input class="form-check-input" type="checkbox" name="status[]" id="complete"
                                       value="complete" @if(old('status') != null) {{in_array('complete', old('status')) === true ? 'checked' :''}} @endif>
                                <label class="form-check-label" for="complete">{{__('Complete')}}</label>
                            </div>
                            <div class="col-md-10 col-md-offset-2">
                                <input class="form-check-input" type="checkbox" name="status[]" id="in-progress"
                                       value="in-progress" @if(old('status') != null) {{in_array('in-progress', old('status')) === true ? 'checked' :''}} @endif>
                                <label class="form-check-label" for="in-progress">{{__('In-progress')}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-7">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-10">
            <div class="row">
                @role('admin')
                <div class="col-md-6">
                    <a href="{{ route('students.create') }}" class="add-student">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-plus-square" viewBox="0 0 16 16">
                            <path
                                d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                    </a>
                </div>
                <div class="col-md-6">
                    <button style="float: right" data-toggle="modal"
                            href="#dismiss-student">{{__('Dismiss Student')}}</button>
                </div>
                @endrole
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-student">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__("Department")}}</th>
                            <th>{{__('Email')}}</th>
                            <th>{{__('Gender')}}</th>
                            <th>{{__('Birthday')}}</th>
                            <th>{{__('Address')}}</th>
                            <th>{{__('Phone')}}</th>
                            @role('admin')
                            <th style="width: 45px"></th>
                            <th></th>
                            @endrole
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($students) == 0)
                            <tr>
                                <td></td>
                                <td colspan="100%"
                                    style="text-align: center !important; font-size: 1.2em">{{strtoupper(__('No record found'))}}</td>
                            </tr>
                        @else
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
                                    <input type="hidden" name="slug" value={{$student->slug}}>
                                    @role('admin')
                                    <td>
                                        <a href="{{ route('students.edit',[$student->slug]) }}" class="update-student">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor"
                                                 class="bi bi-pencil" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                            </svg>
                                        </a>
                                        <a data-toggle="modal" href="#delete-student" class="delete-student">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor"
                                                 class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd"
                                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('students.massive-update',[$student->slug])}}">
                                            <button type="submit">{{__('Update Result')}}</button>
                                        </a>
                                    </td>
                                    @endrole
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    <div style="text-align: center; position: relative">
                        <span style="position: absolute; top: 26px; left: 500px">{{$students->firstItem()}}-{{$students->lastItem()}} of {{$students->total()}}</span>
                        {{$students->links()}}
                        <span style="font-style: italic; position: absolute; top: 26px; left: 800px">{{$students->count()}} record(s) per page</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
