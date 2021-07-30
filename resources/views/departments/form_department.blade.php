@if($errors->any())
    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <h4 style="font-weight: bold; text-align: center" class="errorTxt">{{__('FAILED')}}</h4>
        </div>
    </div>
@endif
@if(session('notification'))
    <div class="row">
        <div class="col-md-12">
            <h4 style="text-align: center; font-weight: bold" class="{{session('notification') === 'Failed' ? 'errorTxt' : 'successTxt'}}">{{strtoupper(session('notification'))}}</h4>
        </div>
    </div>
@endif
@if(request()->segment(2) == 'create')
    {{Form::open(['method'=>'post','url'=>'departments/','class'=>'form-layout'])}}
    <div class="row">
        {{Form::hidden('id')}}
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('name',__('Name'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('name')}}
            </div>
            <div class="col-md-6">
                @if($errors->has('name'))
                    @foreach($errors->get('name') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-5">
            {{Form::button(__('ADD'),['class'=>'btn btn-primary','type'=>'submit'])}}
        </div>
    </div>
    {{Form::close()}}
@else
    {{Form::model($department,array('route'=>array('departments.update',$department->slug),'method'=>'put','class'=>'form-layout'))}}
    <div class="row">
        {{Form::hidden('id')}}
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('name',__('Name'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('name')}}
            </div>
            <div class="col-md-6">
                @if($errors->has('name'))
                    @foreach($errors->get('name') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-5">
            {{Form::button(__('UPDATE'),['class'=>'btn btn-primary','type'=>'submit'])}}
        </div>
    </div>
    {{Form::close()}}
@endif

