@extends('layout.user_template')

@section('content')
    <div>
        <h3>{{__('Update Profile')}}</h3>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include('users.form_student')
        </div>
    </div>
@endsection
