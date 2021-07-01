@if(request()->segment(2)== 'create')
    {{Form::open(['method'=>'post','url'=>'/results','class'=>'form-layout'])}}
    <div class="row">
        {{Form::hidden('id')}}
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('student_id','Student ID')}}
            </div>
            <div class="col-md-8">
                {{Form::text('student_id')}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('subject_id','Subject')}}
            </div>
            <div class="col-md-8">
                {{Form::select('subject_id',$subjects->pluck('name','id'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('mark','Mark')}}
            </div>
            <div class="col-md-8">
                {{Form::text('mark')}}
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
    {{Form::model($result,array('route'=>array('results.update',$result->id),'class'=>'form-layout','method'=>'put'))}}
    <div class="row">
        {{Form::hidden('id')}}
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('student_id','Student ID')}}
            </div>
            <div class="col-md-8">
                {{Form::text('student_id')}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('subject_id','Subject')}}
            </div>
            <div class="col-md-8">
                {{Form::select('subject_id',$subjects->pluck('name','id'))}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('mark','Mark')}}
            </div>
            <div class="col-md-8">
                {{Form::text('mark')}}
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
