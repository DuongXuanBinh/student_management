<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unblock Confirmation | Helvetic Airline</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/style.css">
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
</head>
<body>
<div style="width: 600px;">
    <div class="row col-md-12">
        <table style="width: 80%;
    margin: 30px 0;">
            <tr style="text-align: center;">
                <th>Student ID</th>
                <th>Name</th>
                <th>Department</th>
            </tr>
            <tr>
                <td>{{$student->id}}</td>
                <td>{{ucfirst($student->name)}}</td>
                <td>{{$department->name}}</td>
            </tr>
        </table>
    </div>
    <div class="row col-md-12">
        <p style="text-align: center;">You have been dismissed because the GPA is under 5.0</p>
    </div>
    <div class="row col-md-12">
        <table class="dismiss-result">
            <tr>
                <th colspan="2">Result</th>
            </tr>
            <tr>
                <td style="font-weight: bold; text-align: center">Subject</td>
                <td style="font-weight: bold; text-align: center">Mark</td>
            </tr>
            @foreach($results as $result)
                <tr>
                    <td>{{$result->name}}</td>
                    <td>{{$result->mark}}</td>
                </tr>
            @endforeach
            <tr>
                <td style="font-weight: bold">GPA</td>
                <td style="font-weight: bold">{{$gpa->average_mark}}</td>
            </tr>
        </table>
    </div>
    <div class="row col-md-12">
        <p>Any question, contact Student Issue Support Department at: 1900-1111</p>
    </div>
</div>
</body>
</html>
