@extends('layout.admin_template')

@section('content')
    <div class="row">
        <h3>{{__('Add Department')}}</h3>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-4">
            @include('departments.form_department')
        </div>
    </div>
@endsection
