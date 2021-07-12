@extends('layout.user_template')

@section('content')
    <div>
        <h3>{{__('My Profile')}}</h3>
    </div>
    <table class="table table-striped" style="margin-top: 50px; width: 80%">
        <thead>
        <tr>
            <th>id</th>
            <th>{{__('Name')}}</th>
            <th>{{__("Department")}}</th>
            <th>{{__('Email')}}</th>
            <th>{{__('Gender')}}</th>
            <th>{{__('Birthday')}}</th>
            <th>{{__('Address')}}</th>
            <th>{{__('Phone')}}</th>
            <th style="width: 45px"></th>
        </tr>
        </thead>
        <tbody>
        <tr class="student-details">
            <td class="student-id">{{$user->id}}</td>
            <td class="student-name">{{$user->name}}</td>
            <td class="student-department">{{$user->department->name}}</td>
            <td class="student-email">{{$user->email}}</td>
            <td class="student-gender">{{$user->gender === 0 ? __("Female") : __('Male')}}</td>
            <td class="student-birthday">{{$user->birthday}}</td>
            <td class="student-address">{{$user->address}}</td>
            <td class="student-phone">{{$user->phone}}</td>
            <td>
                <a href="/users/edit" class="update-student">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-pencil" viewBox="0 0 16 16">
                        <path
                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                    </svg>
                </a>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
