@extends('layout.user_template')

@section('content')
    <div>
        <h3>{{__('My Result')}}</h3>
    </div>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{{__('Subject')}}</th>
                    <th>{{__('Mark')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($results as $result)
                    <tr class="student-details">
                        <td>{{$result->name}}</td>
                        <td>{{$result->mark}}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>{{__('GPA')}}</th>
                    <td>{{$gpa->GPA}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div class="row col-md-12">
                <label style="font-weight:bold" >{{__('Enroll')}}</label>
            </div>
            <div class="row col-md-12">
                <form action="">
                    <select name="name[]" id="">
                        @foreach($enrollable_subjects as $enrollable_subject)
                            <option value="{{$enrollable_subject}}">{{$enrollable_subject}}</option>
                            <input type="hidden" name="mark[]" value="0">
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

@endsection
