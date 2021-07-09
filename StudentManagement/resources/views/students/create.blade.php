@extends('layout.admin_template')

@section('content')
    <div>
        <h3>{{__('Add Student')}}</h3>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include('students.form_student')
        </div>
    </div>
@endsection
