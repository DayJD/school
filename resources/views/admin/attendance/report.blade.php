@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Attendance Report <span style="color: blue">(Total : {{ $getRecord->total() }})</span></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search</h3>
                    </div>
                    <form method="get">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Student ID</label>
                                    <input type="text" name="student_id"
                                        class="form-control"value="{{ Request::get('student_id') }}" placeholder="Enter ID">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Student Name</label>
                                    <input type="text" name="student_name"
                                        class="form-control"value="{{ Request::get('student_name') }}"
                                        placeholder="Enter student name">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Class</label>
                                    <select class="form-control" name="class_id" id="getClass">
                                        <option value="">Select Class</option>
                                        @foreach ($getClass as $class)
                                            <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                value="{{ $class->id }}">{{ $class->class_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Attendance Date</label>
                                    <input type="date" class="form-control" id="getAttendanceDate" name="attendance_date"
                                        value="{{ Request::get('attendance_date') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">Attendance Type</label>
                                    <select class="form-control" name="attendance_type" id="getAttendanceType">
                                        <option value="">Select Type</option>
                                        <option {{ Request::get('attendance_type') == 1 ? 'selected' : '' }} value="1">
                                            Present</option>
                                        <option {{ Request::get('attendance_type') == 2 ? 'selected' : '' }} value="2">
                                            Late</option>
                                        <option {{ Request::get('attendance_type') == 3 ? 'selected' : '' }} value="3">
                                            Absent</option>
                                        <option {{ Request::get('attendance_type') == 4 ? 'selected' : '' }} value="4">
                                            Half Day</option>
                                    </select>
                                </div>

                                <div
                                    class="form-group col-md-2 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/attendance/report') }}" class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Attendance List</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Attendance</th>
                                    <th>Class Name</th>
                                    <th>Created By</th>
                                    <th>Attendance Date</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($getRecord->isEmpty())
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="5">Record not found</td>
                                    </tr>
                                @else
                                    @foreach ($getRecord as $value)
                                        <tr>
                                            <td>{{ $value->student_id }}</td>
                                            <td>{{ $value->student_name . ' ' . $value->student_lastname }}</td>
                                            <td>{{ $value->class_name }}</td>
                                            <td>
                                                @if ($value->attendance_type == 1)
                                                    Present
                                                @elseif ($value->attendance_type == 2)
                                                    Late
                                                @elseif ($value->attendance_type == 3)
                                                    Absent
                                                @elseif ($value->attendance_type == 4)
                                                    Half Day
                                                @endif
                                            </td>
                                            <td>{{ $value->created_name }}</td>
                                            <td>{{ date('d-m-Y H:i A', strtotime($value->attendance_date)) }}</td>
                                            <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                        <div class="p-3 ">
                            {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.SaveAttendance').change(function(e) {
                e.preventDefault();
                var student_id = $(this).attr('id');
                var attendance_type = $(this).val()
                var class_id = $('#getClass').val()
                var attendance_date = $('#getAttendanceDate').val()


                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/attendance/student/save') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        student_id: student_id,
                        attendance_type: attendance_type,
                        class_id: class_id,
                        attendance_date: attendance_date,
                    },
                    dataType: "json",
                    success: function(data) {
                        // console.log(response);
                        alert(data.message)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", textStatus, errorThrown);
                        // แสดงข้อความแจ้งเตือนข้อผิดพลาดแก่ผู้ใช้
                    }
                });
            });
        });
    </script>
@endsection
