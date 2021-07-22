@extends('layout.admin_template')
<?php
$old = old();
if (!empty($old)) {
    $results = [];
    for ($i = 0; $i < (count($old['subject_id'])); $i++) {
        $results[$i]['id'] = $old['subject_id'][$i];
        $results[$i]['mark'] = $old['mark'][$i];
    }
}
?>
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
        @if(session('notification'))
            <div class="row">
                <div class="col-md-12">
                    <p style="color: #03803e; font-size: 1.2em; text-align: center">{{session('notification')}}</p>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <button class="add-button">+ {{__('Add Subject')}}</button>
            </div>
        </div>
        {{Form::open(['method'=>'put','route'=>'results.massive-update','id'=>'massive-form'])}}
        <div class="result-set">
            {{Form::hidden('student_id',$student->id)}}
            {{Form::hidden('department_id',$student->department_id)}}
            @if($results && $subjects)
                @for($i = 0; $i < count($results); $i++)
                    <div class="row result-subset">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                {{Form::label('subject_id',__('Subject'))}}
                            </div>
                            <div class="col-md-4">
                                {{showSubjects($name = 'subject_id[]',$subjects, $results[$i]['id'])}}
                                {{showError('subject_id',$i,$errors)}}
                            </div>
                            <div class="col-md-2">
                                {{Form::label('mark',__('Mark'))}}
                            </div>
                            <div class="col-md-4">
                                {{Form::text('mark', $results[$i]['mark'])}}
                                {{showError('mark',$i,$errors)}}
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
                @endfor
            @endif
        </div>

        <div class="row">
            {{Form::button(__('Submit'),['class'=>'btn btn-primary','type'=>'submit'])}}
            {{Form::button(__('Cancel'),['class'=>'btn btn-secondary'])}}
        </div>
        {{Form::close()}}

        {{--                form to append    --}}
        <div class="row result-subset subset-hidden">
            <div class="col-md-12">
                <div class="col-md-2">
                    {{Form::label('subject_id',__('Subject'))}}
                </div>
                <div class="col-md-4">
                    {{showSubject($name = 'subject_id[]', $subjects)}}
{{--                    {{showError('subject_id',$i,$errors)}}--}}
                </div>
                <div class="col-md-2">
                    {{Form::label('mark',__('Mark'))}}
                </div>
                <div class="col-md-4">
                    {{Form::text('mark[]')}}
{{--                    {{showError('mark',$i,$errors)}}--}}
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
