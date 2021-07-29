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
<div class="modal fade" id="update-notification" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">{{__('Notification')}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
            </div>
        </div>
    </div>
</div>
@if(request()->segment(2) == 'create')
    {{Form::open(['method'=>'post','route'=>'students.store','class'=>'form-layout'])}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('name',__('Name'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('name',old('name'),array('class'=>'form-control'))}}
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
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('department_id',__('Department'))}}
            </div>
            <div class="col-md-4">
                {{Form::select('department_id',$departments->pluck('name','id'),'',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('department_id'))
                    @foreach($errors->get('department_id') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('email',__('Email'))}}
            </div>
            <div class="col-md-4">
                {{Form::email('email',old('email'),array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('email'))
                    @foreach($errors->get('email') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('gender',__('Gender'))}}
            </div>
            <div class="col-md-4">
                {{Form::select('gender',['0'=> __('Female'),'1' => __('Male')],'',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('gender'))
                    @foreach($errors->get('gender') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('birthday',__('Birthday'))}}
            </div>
            <div class="col-md-4">
                {{Form::date('birthday',old('birthday'),array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('birthday'))
                    @foreach($errors->get('birthday') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('address',__('Address'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('address',old('address'),array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('address'))
                    @foreach($errors->get('address') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('phone',__('Phone Number'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('phone',old('phone'),array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('phone'))
                    @foreach($errors->get('phone') as $error)
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
    {{Form::model($student,array('route'=>array('students.update',$student->slug),'class'=>'form-layout update-student-form','method'=>'put'))}}
    <div class="row">
        <div class="col-md-12">
            {{Form::hidden('id')}}
            {{Form::hidden('slug')}}
            {{Form::hidden('user_id')}}
            <div class="col-md-2">
                {{Form::label('name',__('Name'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('name',old('name'),array('class'=>'form-control'))}}
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
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('department_id',__('Department'))}}
            </div>
            <div class="col-md-4">
                {{Form::select('department_id',$departments->pluck('name','id'),'',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('department_id'))
                    @foreach($errors->get('department_id') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('email',__('Email'))}}
            </div>
            <div class="col-md-4">
                {{Form::email('email',old('email'),array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('email'))
                    @foreach($errors->get('email') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('gender',__('Gender'))}}
            </div>
            <div class="col-md-4">
                {{Form::select('gender',['0'=> __('Female'),'1' => __('Male')],'',array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('gender'))
                    @foreach($errors->get('gender') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('birthday',__('Birthday'))}}
            </div>
            <div class="col-md-4">
                {{Form::date('birthday',old('birthday'),array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('birthday'))
                    @foreach($errors->get('birthday') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('address',__('Address'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('address',old('address'),array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('address'))
                    @foreach($errors->get('address') as $error)
                        <p class="errorTxt">{{$error}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                {{Form::label('phone',__('Phone Number'))}}
            </div>
            <div class="col-md-4">
                {{Form::text('phone',old('phone'),array('class'=>'form-control'))}}
            </div>
            <div class="col-md-6">
                @if($errors->has('phone'))
                    @foreach($errors->get('phone') as $error)
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
@endif
