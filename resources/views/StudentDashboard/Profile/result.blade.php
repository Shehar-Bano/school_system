<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      body{
background:#eee;
margin-top:20px;
}
.text-danger strong {
        	color: #9f181c;
		}
		.receipt-main {
			background: #ffffff none repeat scroll 0 0;
			border-bottom: 12px solid #333333;
			border-top: 12px solid #9f181c;
			margin-top: 50px;
			margin-bottom: 50px;
			padding: 40px 30px !important;
			position: relative;
			box-shadow: 0 1px 21px #acacac;
			color: #333333;
			font-family: open sans;
		}
		.receipt-main p {
			color: #333333;
			font-family: open sans;
			line-height: 1.42857;
		}
		.receipt-footer h1 {
			font-size: 15px;
			font-weight: 400 !important;
			margin: 0 !important;
		}
		.receipt-main::after {
			background: #414143 none repeat scroll 0 0;
			content: "";
			height: 5px;
			left: 0;
			position: absolute;
			right: 0;
			top: -13px;
		}
		.receipt-main thead {
			background: #414143 none repeat scroll 0 0;
		}
		.receipt-main thead th {
			color:#fff;
		}
		.receipt-right h5 {
			font-size: 16px;
			font-weight: bold;
			margin: 0 0 7px 0;
		}
		.receipt-right p {
			font-size: 12px;
			margin: 0px;
		}
		.receipt-right p i {
			text-align: center;
			width: 18px;
		}
		.receipt-main td {
			padding: 9px 20px !important;
		}
		.receipt-main th {
			padding: 13px 20px !important;
		}
		.receipt-main td {
			font-size: 13px;
			font-weight: initial !important;
		}
		.receipt-main td p:last-child {
			margin: 0;
			padding: 0;
		}
		.receipt-main td h2 {
			font-size: 20px;
			font-weight: 900;
			margin: 0;
			text-transform: uppercase;
		}
		.receipt-header-mid .receipt-cnter h1 {
			font-weight: 100;
			margin: 34px 0 0;
			text-align: center;

		}


		#container {
			background-color: #dcdcdc;
		}
    </style>
</head>
<body>
    @include('StudentDashboard.ViewFile.head')
    <div class="container-scroller">
        @include('StudentDashboard.ViewFile.nav')
        <div class="container-fluid page-body-wrapper">
            @include('StudentDashboard.ViewFile.sidebar')

            <form class="mt-4" action="{{route('result.student')}}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="exam_id" class="form-label">Exam <span class="text-danger">*</span></label>
                    <select class="form-control" id="exam_id" name="exam_id" required>
                        <option value="">Select Exam</option>
                        <!-- Options populated dynamically -->
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                        @endforeach
                    </select>
                </div>







                <button type="submit" class="btn btn-primary">Add Exam Schedule</button>
            </form>
            <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">


                <div class="row">
                    <div class="receipt-header receipt-header-mid d-flex justify-content-center">
                        <div>
                          <h3>Result Card</h3>
                        </div>

                    </div>
                </div>

                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Obt Mark</th>
                                <th>Total Marks</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                          $totalMarks = 0;
                            @endphp

                            @foreach($result as $res)

                            <tr>
                                <td class="col-md-3">{{$res->subject->subject_name}}</td>
                                <td class="col-md-3">{{$res->obt_marks}}</td>
                                <td class="col-md-3">{{$res->total}}</td>
                                <td class="col-md-3"> {{$res->grade}}</td>
                            </tr>

                            @php
                                 $totalMarks += $res->obt_marks
                            @endphp
                            @endforeach

                            <tr>


                                <td class="text-right" colspan="3"><h2><strong>Total: </strong></h2></td>
                                <td class="text-left text-danger"><h2><strong><i class="fa fa-inr"></i>{{$totalMarks}}</strong></h2></td>
                            </tr>

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
        </div>
    </div>
    @include('StudentDashboard.ViewFile.script')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
