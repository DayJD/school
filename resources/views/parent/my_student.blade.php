@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                        <h1 class="m-0">My Student List</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right">

                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">My Student</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Profile</th>
                                    <th>Student Name</th>

                                    <th>Email</th>
                                    <th>Admission Number</th>
                                    <th>Roll Number</th>
                                    <th>Class</th>
                                    <th>Gender</th>
                                    <th>Date of Birth</th>
                                    <th>Caste</th>
                                    <th>Religion</th>
                                    <th>Mobile Number</th>
                                    <th>Admission Date</th>
                                    <th>Blood Group</th>
                                    <th>Height</th>
                                    <th>Weight</th>

                                    <th>Created Date</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>
                                            @if (!empty($value->getProfile()))
                                                <img src="{{ $value->getProfile() }}"
                                                    style="width: 50px; height: 50px ; border-radius: 50px">
                                            @endif
                                        </td>
                                        <td>{{ $value->name . ' ' . $value->last_name }}</td>

                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->admission_number }}</td>
                                        <td>{{ $value->roll_number }}</td>
                                        <td>{{ $value->class_name }}</td>
                                        <td>{{ $value->gender }}</td>
                                        <td>
                                            @if (!empty($value->date_of_birth))
                                                {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                                            @endif
                                        </td>
                                        <td>{{ $value->caste }}</td>
                                        <td>{{ $value->religion }}</td>
                                        <td>{{ $value->mobile_number }}</td>
                                        <td>
                                            @if (!empty($value->date_of_birth))
                                                {{ date('d-m-Y', strtotime($value->admission_date)) }}
                                            @endif
                                        </td>
                                        <td>{{ $value->blood_group }}</td>
                                        <td>{{ $value->height }}</td>
                                        <td>{{ $value->weight }}</td>
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        <td style="width: 350px">
                                            <a href="{{ url('parent/my_student_subject/' . $value->id) }} "
                                                class="btn btn-sm btn-success">My Subject</a>
                                            <a href="{{ url('parent/exam_timetable/' . $value->id) }} "
                                                class="btn btn-sm btn-primary">Exam Timetable</a>

                                            <a href="{{url('parent/my_student/calendar/' . $value->id )}}" class="btn btn-sm btn-warning">Calendar</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="p-3 ">
                            {{-- {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
