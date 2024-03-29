@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <p style="text-align: center; font-size: 50px">{{__('Welcome')}}</p>
                </div>

                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>{{ __('You are logged in') }}</p>
                        @if(Auth::user()->hasRole('non-registered'))
                            <p>{{__('Please contact Admin for permission assignment')}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
