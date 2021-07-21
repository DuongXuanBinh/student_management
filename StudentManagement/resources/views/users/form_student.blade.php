@if($errors->any())
    <div class="modal fade" id="notification" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">{{__('Notification')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>{{__('FAILED')}}</p>
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                </div>
            </div>
        </div>
    </div>
@endif
{{Form::model($user,array('route'=>array('user.update',$user->slug),'class'=>'form-layout','method'=>'put'))}}
<div class="row">
    {{Form::hidden('id')}}
    <div class="col-md-12">
        <div class="col-md-4">
            {{Form::label('name',__('Name'))}}
        </div>
        <div class="col-md-8">
            {{Form::text('name',old('name'))}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            {{Form::label('department_id',__('Department'))}}
        </div>
        <div class="col-md-8">
            {{Form::select('department_id',$departments->pluck('name','id'))}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            {{Form::label('email',__('Email'))}}
        </div>
        <div class="col-md-8">
            {{Form::email('email',old('email'))}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            {{Form::label('gender',__('Gender'))}}
        </div>
        <div class="col-md-8">
            {{Form::select('gender',['0'=> __('Female'),'1' => __('Male')])}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            {{Form::label('birthday',__('Birthday'))}}
        </div>
        <div class="col-md-8">
            {{Form::date('birthday',old('birthday'))}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            {{Form::label('address',__('Address'))}}
        </div>
        <div class="col-md-8">
            {{Form::text('address',old('address'))}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            {{Form::label('phone',__('Phone Number'))}}
        </div>
        <div class="col-md-8">
            {{Form::text('phone',old('phone'))}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-7">
        {{Form::button(__('UPDATE'),['class'=>'btn btn-primary','type'=>'submit'])}}
    </div>
</div>
{{Form::close()}}
