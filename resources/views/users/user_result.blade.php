@extends('layout.user_template')

@section('content')
    <div>
        <h3>{{__('My Result')}}</h3>
    </div>
    @if(session('notification'))
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center; font-weight: bold"
                    class="{{session('notification') === 'Failed' ? 'errorTxt' : 'successTxt'}}">{{strtoupper(session('notification'))}}</h4>
            </div>
        </div>
    @endif
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
                    <td>{{$gpa}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div class="row col-md-12">
                <label style="font-weight:bold">{{__('Enroll')}}</label>
            </div>
            <form action="{{route('user.enroll')}}" method="post" id="enroll-subject">
                <div class="row">
                    <div class="col-md-5">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="{{$user->id}}">
                        <select name="subject_id" class="form-control">
                            @foreach($enrollable_subjects as $enrollable_subject)
                                <option value="{{$enrollable_subject->id}}">{{$enrollable_subject->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
