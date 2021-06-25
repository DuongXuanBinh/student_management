@extends('user_template')

@section('content')
        <div class="row">
            <div class="col-md-12">
                <table>
                    <tr>
                        <th>Student ID</th>
                        <th>Student name</th>
                        <th>Department</th>
                    </tr>
                    <tr>
                        <td>{{$student_id}}</td>
                        <td>{{$student_name}}</td>
                        <td>{{$department_name}}</td>
                    </tr>
                </table>
            </div>
        </div>
@endsection
