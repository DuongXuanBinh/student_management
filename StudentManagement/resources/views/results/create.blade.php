@extends('layout.admin_template')

@section('content')
    <div>
        <h3>Add Result</h3>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include('results.form_result')
        </div>
    </div>
@endsection
