@extends('employeeDashboard.employeeView.masterpage')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin-top: 20px;
        }
        .bg-light-gray {
            background-color: #f7f7f7;
        }
        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .bg-yellow.box-shadow {
            box-shadow: 0px 5px 0px 0px #dcbf02;
        }
        .padding-15px-lr {
            padding-left: 15px;
            padding-right: 15px;
        }
        .padding-5px-tb {
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .margin-10px-bottom {
            margin-bottom: 10px;
        }
        .border-radius-5 {
            border-radius: 5px;
        }
        .margin-10px-top {
            margin-top: 10px;
        }
        .font-size14 {
            font-size: 14px;
        }
        .text-light-gray {
            color: #d6d5d5;
        }
        .font-size13 {
            font-size: 13px;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
    </style>

      <div class="container">
               <div class="timetable-img text-center mt-3">
                    <h3>TIME TABLE</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-light-gray">
                                <th class="text-uppercase">Time</th>
                                <th class="text-uppercase">Monday</th>
                                <th class="text-uppercase">Tuesday</th>
                                <th class="text-uppercase">Wednesday</th>
                                <th class="text-uppercase">Thursday</th>
                                <th class="text-uppercase">Friday</th>
                                <th class="text-uppercase">Saturday</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Get the unique time slots from the timetable
                                $timeslots = $timetable->pluck('start_time')->unique();
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                            @endphp

                            @foreach ($timeslots as $time)
                            <tr>
                                <td class="align-middle">{{ $time}}</td>
                                @foreach ($days as $day)
                                    @php
                                        // Find the class for this time and day
                                        $class = $timetable->where('start_time', $time)->where('day', $day)->first();
                                    @endphp
                                    <td>
                                        @if ($class)
                                        <span class="bg-warning padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom  font-size16 xs-font-size13">{{ $class->subject->subject_name }}</span>
                                        <div class="margin-10px-top font-size14">{{ $class->start_time }} - {{ $class->end_time }}</div>
                                            <div class="font-size13 text-gray">{{ $class->class->name}}  {{ $class->section->name }}</div>
                                        @else
                                            <span class="bg-light-gray"></span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
           
        </div>

   
 
@endsection