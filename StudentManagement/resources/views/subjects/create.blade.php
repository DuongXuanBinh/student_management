@extends('layout.admin_template')

@section('content')
    <div class="row">
        <h3>{{__('Add Subject')}}</h3>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-4">
            @include('subjects.form_subject')
        </div>
    </div>
@endsection
