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
@if(request()->segment(2)== 'create')
    {{Form::open(['method'=>'post','route'=>'results.store','class'=>'form-layout'])}}
    <div class="row">
        {{Form::hidden('id')}}
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('student_id',__('Student ID'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('student_id','',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('student_id'))
                    @foreach($errors->get('student_id') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('subject_id',__('Subject'))}}
            </div>
            <div class="col-md-4">
                {{Form::select('subject_id',$subjects->pluck('name','id'),'',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('subject_id'))
                    @foreach($errors->get('subject_id') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('mark',__('Mark'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('mark','',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('mark'))
                    @foreach($errors->get('mark') as $error)
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
    @foreach($result->subjects as $subject)
    {{Form::model($subject,array('route'=>array('results.update',$subject->id),'class'=>'form-layout','method'=>'put'))}}
    <div class="row">
        {{Form::hidden('id')}}
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('student_id',__('Student ID'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('student_id','',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('student_id'))
                    @foreach($errors->get('student_id') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('subject_id',__('Subject'))}}
            </div>
            <div class="col-md-4">
                {{Form::select('subject_id',$subjects->pluck('name','id'),'',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('subject_id'))
                    @foreach($errors->get('subject_id') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('mark',__('Mark'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('mark','',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('mark'))
                    @foreach($errors->get('mark') as $error)
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
    @endforeach
@endif
