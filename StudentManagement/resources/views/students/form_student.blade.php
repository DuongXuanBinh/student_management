@section('form-student')
    {{Form::open(['method'=>'GET','url'=>'student/add'])}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('name','Name')}}
            </div>
            <div class="col-md-8">
                {{Form::text('name',old('name'))}}
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
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('email','Email')}}
            </div>
            <div class="col-md-8">
                {{Form::email('email',old('email'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('gender','Gender')}}
            </div>
            <div class="col-md-8">
                {{Form::select('gender',['0'=> 'Female','1' => 'Male'])}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('birthday','Birthday')}}
            </div>
            <div class="col-md-8">
                {{Form::date('birthday',old('birthday'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('address','Address')}}
            </div>
            <div class="col-md-8">
                {{Form::text('address',old('address'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('phone','Phone Number')}}
            </div>
            <div class="col-md-8">
                {{Form::text('phone',old('phone'))}}
            </div>
        </div>
    </div>
    <div>
        {{Form::button('Cancel',['class'=>'btn btn-secondary','data-dismiss'=>'modal'])}}
        {{Form::button('Add',['class'=>'btn btn-primary','type'=>'submit'])}}
    </div>
    {{Form::close()}}
@endsection
