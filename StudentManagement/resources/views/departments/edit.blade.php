@extends('layout.admin_template')

@section('content')
    <div>
        <h3>Update Result</h3>
    </div>

    <div class="row">
        <div class="col-md-6">
            @include('departments.form_department')
        </div>
    </div>
@endsection
