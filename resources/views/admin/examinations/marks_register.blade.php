@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Exam Schedule</h1>
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
                                    <select class="form-control" name="exam_id" required>
                                        <option value="">Select</option>
                                        @foreach ($getExam as $exam)
                                            <option {{ Request::get('exam_id') == $exam->id ? 'selected' : '' }}
                                                value="{{ $exam->id }}">{{ $exam->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select class="form-control" name="class_id" required>
                                        <option value="">Select</option>
                                        @foreach ($getClass as $class)
                                            <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div
                                    class="form-group col-md-3 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/examinations/marks_register') }}"
                                        class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')

                @if (!empty($getSubject) && !empty($getSubject->count()))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Exam Schedule</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        @foreach ($getSubject as $itemS)
                                            <th style="text-align: center">{{ $itemS->subject_name }}
                                                <br>
                                                ({{ $itemS->subject_type . ' : ' . $itemS->passing_marks . ' / ' . $itemS->full_makes }})
                                            </th>
                                        @endforeach
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (!empty($getStudent) && !empty($getStudent->count()))
                                        @foreach ($getStudent as $student)
                                            <form class="SubmidForm">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                                                <input type="hidden" name="class_id"
                                                    value="{{ Request::get('class_id') }}">
                                                <tr>
                                                    <td>{{ $student->name . ' ' . $student->last_name }}</td>
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($getSubject as $subject)
                                                    @php
                                                    // NOTE getMark มาจากการ save submit_makes_register และเพื่อแสดงข้อมูลเก่า เลยไปดึงข้อมูลจาก ExamScheduleModel ให้ส่งกลับมา
                                                        $getMark = $subject->getMark($student->id,Request::get('exam_id'), Request::get('class_id'), $subject->subject_id)
                                                    @endphp
                                                        <td>
                                                            <div class="mb-2">
                                                                Class Work
                                                                <input type="hidden"
                                                                    name="mark[{{ $i }}][subject_id]"
                                                                    value="{{ $subject->subject_id }}">
                                                                <input type="text"
                                                                    name="mark[{{ $i }}][class_work]"
                                                                    class="form-control" placeholder="Enter Class Work" value="{{ !empty($getMark->class_work) ? $getMark->class_work : '' }}">
                                                            </div>
                                                            <div class="mb-2">
                                                                Home Work
                                                                <input type="text"
                                                                    name="mark[{{ $i }}][home_work]"
                                                                    class="form-control" placeholder="Enter Home Work" value="{{ !empty($getMark->home_work) ? $getMark->home_work  : '' }}">
                                                            </div>
                                                            <div class="mb-2">
                                                                Test Work
                                                                <input type="text"
                                                                    name="mark[{{ $i }}][test_work]"
                                                                    class="form-control" placeholder="Enter Test Work" value="{{ !empty($getMark->test_work) ? $getMark->test_work  : '' }}">
                                                            </div>
                                                            <div class="mb-2">
                                                                Exam
                                                                <input type="text"
                                                                    name="mark[{{ $i }}][exam]"
                                                                    class="form-control" placeholder="Enter Exam" value="{{ !empty($getMark->exam) ? $getMark->exam  : '' }}">
                                                            </div>
                                                        </td>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @endforeach
                                                    <td>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-success">Save</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
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
            $('.SubmidForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/examinations/submit_makes_register') }}",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
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
