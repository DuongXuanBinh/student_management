@extends('layout.admin_template')

@section('content')
    <div class="massive-update">
        <div class="row">
            <div class="col-md-12">
                <table>
                    <tr>
                        <th>{{__('Student ID')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__("Department")}}</th>
                    </tr>
                    <tr>
                        <td>{{$student->id}}</td>
                        <td>{{$student->name}}</td>
                        <td>{{$department_name}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button class="add-button">+ {{__('Add Subject')}}</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="errorTxt"></p>
            </div>
        </div>
        {{Form::open(['method'=>'put','route'=>'results.massive-update','id'=>'massive-form'])}}
        <div class="result-set">
            @foreach($results as $result)
                <div class="row result-subset">
                    <div class="col-md-12">
                        {{Form::hidden('id',$result->id)}}
                        {{Form::hidden('student_id',$student->id)}}
                        <div class="col-md-2">
                            {{Form::label('subject_id',__('Subject'))}}
                        </div>
                        <div class="col-md-4">
                            {{Form::select('subject_id', $subjects->pluck('name','id'), $result->subject_id)}}
                        </div>
                        <div class="col-md-2">
                            {{Form::label('mark',__('Mark'))}}
                        </div>
                        <div class="col-md-4">
                            {{Form::text('mark',$result->mark)}}
                        </div>
                        <a class="delete-option">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path
                                    d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            {{Form::button(__('Submit'),['class'=>'btn btn-primary','type'=>'submit'])}}
            {{Form::button(__('Cancel'),['class'=>'btn btn-secondary'])}}
        </div>
        {{Form::close()}}
        {{--        form to append    --}}
        <div class="row result-subset subset-hidden">
            <div class="col-md-12">
                {{Form::hidden('student_id[]',$student->id)}}
                <div class="col-md-2">
                    {{Form::label('subject_id',__('Subject'))}}
                </div>
                <div class="col-md-4">
                    {{Form::select('subject_id[]',$subjects->pluck('name','id'))}}
                </div>
                <div class="col-md-2">
                    {{Form::label('mark',__('Mark'))}}
                </div>
                <div class="col-md-4">
                    {{Form::text('mark[]')}}
                </div>
                <a class="delete-option">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path
                            d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endsection
