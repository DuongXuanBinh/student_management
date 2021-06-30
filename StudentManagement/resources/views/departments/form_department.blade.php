@section('form-department')
    {{Form::open(['method'=>'get','url'=>'department/update-department'])}}
    <div class="row">
        {{Form::hidden('id')}}
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('name','Name')}}
            </div>
            <div class="col-md-8">
                {{Form::text('name')}}
            </div>
        </div>
    </div>
    <div>
        {{Form::button('Cancel',['class'=>'btn btn-secondary','data-dismiss'=>'modal'])}}
        {{Form::button('Update',['class'=>'btn btn-primary','type'=>'submit'])}}
    </div>
    {{Form::close()}}
@endsection
