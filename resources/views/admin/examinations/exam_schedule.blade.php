@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Exam Schedule</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right">
                        <a href="{{ 'add' }}" class="btn btn-primary">เพิ่ม</a>
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
                    <form method="get"active="">
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
                                    <a href="{{ url('admin/examinations/exam_schedule') }}"
                                        class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')

                @if (!empty($getRecord))
                    <form action="{{ url('admin/examinations/exam_schedule_insert') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="exam_id" id="" value="{{ Request::get('exam_id') }}">
                        <input type="hidden" name="class_id" id="" value="{{ Request::get('class_id') }}">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Exam Schedule</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Subject Name</th>
                                            <th>Exam Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Room Number</th>
                                            <th>Full Marks</th>
                                            <th>Passing Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $key = 1;
                                        @endphp
                                        @foreach ($getRecord as $key => $value)
                                            <tr>
                                                <td>
                                                    {{ $value['subject_name'] }}
                                                    <input type="hidden" value="{{ $value['subject_id'] }}"
                                                        name="schedle[{{ $key }}][subject_id]"
                                                        class="form-control">
                                                </td>
                                                <td><input type="date" name="schedle[{{ $key }}][exam_date]"
                                                        class="form-control" value="{{ $value['exam_date'] }}">
                                                </td>
                                                <td><input type="time" name="schedle[{{ $key }}][start_time]"
                                                        class="form-control" value="{{ $value['start_time'] }}">
                                                </td>
                                                <td><input type="time" name="schedle[{{ $key }}][end_time]"
                                                        class="form-control" value="{{ $value['end_time'] }}">
                                                </td>
                                                <td><input type="text" name="schedle[{{ $key }}][room_number]"
                                                        class="form-control" value="{{ $value['room_number'] }}">
                                                </td>
                                                <td><input type="text" name="schedle[{{ $key }}][full_makes]"
                                                        class="form-control" value="{{ $value['full_makes'] }}">
                                                </td>
                                                <td><input type="text"
                                                        name="schedle[{{ $key }}][passing_marks]"
                                                        class="form-control" value="{{ $value['passing_marks'] }}"></td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="mt-3 mr-3" style="text-align: center;">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </div>

                    </form>
                @endif
            </div>
        </section>
    </div>
@endsection
