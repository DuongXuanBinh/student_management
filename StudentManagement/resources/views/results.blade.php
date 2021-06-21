@extends('admin_template')

@section('content')

    @if(session('notification'))
        <div class="modal fade" id="notification" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">Notification</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p>{{session('notification')}}</p>
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <p>{{$error}}</p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="edit-result" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update result details</h4>
                </div>
                {{Form::open(['method'=>'get','url'=>'/result/update'])}}
                <div class="modal-body">
                    <div class="row">
                        {{Form::hidden('id')}}
                        <div class="col-md-12">
                            <div class="col-md-4">
                                {{Form::label('student_id','Student ID')}}
                            </div>
                            <div class="col-md-8">
                                {{Form::text('student_id')}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                {{Form::label('subject_id','Subject')}}
                            </div>
                            <div class="col-md-8">
                                {{Form::select('subject_id',$subjects->pluck('name','id'))}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                {{Form::label('mark','Mark')}}
                            </div>
                            <div class="col-md-8">
                                {{Form::text('mark')}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::button('Cancel',['class'=>'btn btn-secondary','data-dismiss'=>'modal'])}}
                    {{Form::button('Update',['class'=>'btn btn-primary','type'=>'submit'])}}
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-result" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Result</h4>
                </div>
                <form action="result/delete" method="get">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id">
                                <p>Are you sure to delete this result?</p>
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

    <div class="modal fade" id="add-result" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new student</h4>
                </div>
                {{Form::open(['method'=>'get','url'=>'result/add'])}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                {{Form::label('student_id','Student ID')}}
                            </div>
                            <div class="col-md-8">
                                {{Form::text('student_id')}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                {{Form::label('subject_id','Subject ID')}}
                            </div>
                            <div class="col-md-8">
                                {{Form::select('subject_id',$subjects->pluck('name','id'))}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                {{Form::label('mark','Mark')}}
                            </div>
                            <div class="col-md-8">
                                {{Form::text('mark')}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::button('Cancel',['class'=>'btn btn-secondary','data-dismiss'=>'modal'])}}
                    {{Form::button('Add',['class'=>'btn btn-primary','type'=>'submit'])}}
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <a data-toggle="modal" href="#add-result" class="add-result">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-plus-square" viewBox="0 0 16 16">
                    <path
                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </a>
        </div>
        <div class="col-md-12">
            <table class="table-display table-result">
                <tr>
                    <th>id</th>
                    <th>student id</th>
                    <th>subject id</th>
                    <th>mark</th>
                    <th></th>
                </tr>
                @foreach($results as $result)
                    <tr>
                        <td>{{$result->id}}</td>
                        <td>{{$result->student_id}}</td>
                        <td>{{$result->subject_id}}</td>
                        <td>{{$result->mark}}</td>
                        <td>
                            <a data-toggle="modal" href="#edit-result" class="update-result">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </a>
                            <a data-toggle="modal" href="#delete-result" class="delete-result">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd"
                                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div style="text-align:  center">
                {{$results->links()}}
            </div>
        </div>
    </div>
@endsection
