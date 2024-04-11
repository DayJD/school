@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">My Class & Subject - ({{ $getRecord[0]['teacher_name'] }})</h1>
                    </div>
                    {{-- <div class="col-sm-6" style="text-align: right">
                        <a href="{{ 'add' }}" class="btn btn-primary">เพิ่ม</a>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">


                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">My Class & Subject</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Class Name</th>
                                    <th>Subject Name</th>
                                    <th>Subject Type</th>
                                    <th>My Class Timetable</th>

                                    <th>Created Date</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $value->class_name }}</td>
                                        <td>{{ $value->subject_name }}</td>
                                        <td>{{ $value->type }}</td>
                                        <td>
                                            @php
                                                $ClassSubject = $value->getTimetable(
                                                    $value->class_id,
                                                    $value->subject_id,
                                                );
                                            @endphp
                                            @if (!empty($ClassSubject))
                                                {{ date('h:i A', strtotime($ClassSubject->start_time)) }} to
                                                {{ date('h:i A', strtotime($ClassSubject->end_time)) }}
                                                <br>
                                                Room Number : {{$ClassSubject->room_number}}
                                            @endif
                                            {{-- {{ $value->getTimetable($value->class_id, $value->subject_id) }} --}}
                                        </td>
                                        <td>{{ $value->created_at }}</td>
                                        <td><a href="{{ url('teacher/my_class_subject/class_timetable/' . $value->class_id . '/' . $value->subject_id) }}"
                                                class="btn btn-primary">My Class Timetable</a></td>
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
