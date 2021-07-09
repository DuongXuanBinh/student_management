@if(request()->segment(2) == 'create')
    {{Form::open(['method'=>'post','url'=>'departments/','class'=>'form-layout'])}}
    <div class="row">
        {{Form::hidden('id')}}
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('name',__('Department Name'))}}
            </div>
            <div class="col-md-8">
                {{Form::text('name')}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-7">
            {{Form::button(__('ADD'),['class'=>'btn btn-primary','type'=>'submit'])}}
        </div>
    </div>
    {{Form::close()}}
@else
    {{Form::model($department,array('route'=>array('departments.update',$department->id),'method'=>'put','class'=>'form-layout'))}}
    <div class="row">
        {{Form::hidden('id')}}
        <div class="col-md-12">
            <div class="col-md-4">
                {{Form::label('name',__('Name'))}}
            </div>
            <div class="col-md-8">
                {{Form::text('name')}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-7">
            {{Form::button(__('UPDATE'),['class'=>'btn btn-primary','type'=>'submit'])}}
        </div>
    </div>
    {{Form::close()}}
@endif

