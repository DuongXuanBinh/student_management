@section('form-subject')
    {{Form::open(['method'=>'get','url'=>'department/update-subject'])}}
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
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('department_id','Department')}}
            </div>
            <div class="col-md-8">
                {{Form::select('department_id',$departments->pluck('name','id'))}}
            </div>
        </div>
    </div>
    <div>
        {{Form::button('Cancel',['class'=>'btn btn-secondary','data-dismiss'=>'modal'])}}
        {{Form::button('Update',['class'=>'btn btn-primary','type'=>'submit'])}}
    </div>
    {{Form::close()}}
@endsection
