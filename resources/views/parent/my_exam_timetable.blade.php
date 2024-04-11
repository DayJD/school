@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">My Exam Timetable <span style="color: blue">({{ $getStudent->name . ' ' . $getStudent->last_name }})</span></h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right">
                        {{-- <a href="{{ 'add' }}" class="btn btn-primary">เพิ่ม</a> --}}
                        {{-- <a href="{{ 'admin/assign_subject/add' }}" class="btn btn-primary">เพิ่ม</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                @include('_message')



                @foreach ($getRecord as $value)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $value['name'] }}</h3>
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
                                    @foreach ($value['exam'] as $itemE)
                                    <tr>
                                        <td>{{ $itemE['subject_name'] }}</td>
                                        <td>{{ !empty($itemE['exam_date']) ? date('l',strtotime($itemE['exam_date'])) : '' }}</td>
                                        <td>{{ !empty($itemE['start_time']) ? date('h:i:A',strtotime($itemE['start_time'])) : '' }}</td>
                                        <td>{{ !empty($itemE['end_time']) ? date('h:i:A',strtotime($itemE['end_time'])) : '' }}</td>
                                        <td>{{ $itemE['room_number'] }}</td>
                                        <td>{{ $itemE['full_makes'] }}</td>
                                        <td>{{ $itemE['passing_marks'] }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>
                @endforeach


            </div>
        </section>
    </div>
@endsection
