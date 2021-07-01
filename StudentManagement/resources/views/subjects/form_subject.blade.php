@if(request()->segment(2) == 'create')
    {{Form::open(['method'=>'post','url'=>'subjects/','class'=>'form-layout'])}}
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
    <div class="row">
        <div class="col-md-offset-7">
            {{Form::button('ADD',['class'=>'btn btn-primary','type'=>'submit'])}}
        </div>
    </div>
    {{Form::close()}}
@else
    {{Form::model($subject,array('route'=>array('subjects.update',$subject->id),'class'=>'form-layout','method'=>'put'))}}
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
    <div class="row">
        <div class="col-md-offset-7">
            {{Form::button('UPDATE',['class'=>'btn btn-primary','type'=>'submit'])}}
        </div>
    </div>
    {{Form::close()}}
@endif

