@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Student Attendance</h1>
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
                                <div class="form-group col-md-3">
                                    <label for="">Class</label>
                                    <select class="form-control" name="class_id" id="getClass" required>
                                        <option value="">Select Class</option>
                                        @foreach ($getClass as $class)
                                            <option {{ Request::get('class_id') == $class->class_id ? 'selected' : '' }}
                                                value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Attendance Date</label>
                                    <input type="date" class="form-control" id="getAttendanceDate" name="attendance_date"
                                        required value="{{ Request::get('attendance_date') }}">
                                </div>

                                <div
                                    class="form-group col-md-3 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/attendance/student') }}" class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')
                @if (!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Exam Schedule</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Attendance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($getStudent) && !empty($getStudent->count()))
                                        @foreach ($getStudent as $value)
                                            @php
                                                $attendance_type = '';
                                                $getAttendance = $value->getAttendance(
                                                    $value->id,
                                                    Request::get('class_id'),
                                                    Request::get('attendance_date'),
                                                );

                                                if (!empty($getAttendance->attendance_type)) {
                                                    $attendance_type = $getAttendance->attendance_type;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->name . ' ' . $value->last_name }}</td>
                                                <td>
                                                    <label class="mr-2">
                                                        <input type="radio"{{ $attendance_type == '1' ? 'checked' : '' }}
                                                            value="1" class="SaveAttendance" id="{{ $value->id }}"
                                                            name="attendance{{ $value->id }}">
                                                        Present
                                                    </label>
                                                    <label class="mr-2">
                                                        <input type="radio"{{ $attendance_type == '2' ? 'checked' : '' }}
                                                            value="2" class="SaveAttendance" id="{{ $value->id }}"
                                                            name="attendance{{ $value->id }}">
                                                        Late
                                                    </label>
                                                    <label class="mr-2">
                                                        <input type="radio"{{ $attendance_type == '3' ? 'checked' : '' }}
                                                            value="3" class="SaveAttendance" id="{{ $value->id }}"
                                                            name="attendance{{ $value->id }}">
                                                        Absent</label>
                                                    <label class="mr-2">
                                                        <input type="radio"{{ $attendance_type == '4' ? 'checked' : '' }}
                                                            value="4" class="SaveAttendance" id="{{ $value->id }}"
                                                            name="attendance{{ $value->id }}">
                                                        Half Day</label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
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
                    url: "{{ url('teacher/attendance/student/save') }}",
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
