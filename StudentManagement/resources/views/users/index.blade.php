@extends('layout.user_template')

@section('content')
    <div class="row">
        <h3>Profile</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table>
                <tr>
                    <th>Student ID:</th>
                    <td>{{$student_id}}</td>
                </tr>
                <tr>
                    <th>Name:</th>
                    <td>{{$student_name}}</td>
                </tr>
                <tr>
                    <th>Department:</th>
                    <td>{{$student->department->name}}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{$student->email}}</td>
                </tr>
                <tr>
                    <th>Gender:</th>
                    <td>{{$student->gender}}</td>
                </tr>
                <tr>
                    <th>Birthday:</th>
                    <td>{{$student->birthday}}</td>
                </tr>
                <tr>
                    <th>Address:</th>
                    <td>{{$student->address}}</td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td>{{$student->phone}}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
