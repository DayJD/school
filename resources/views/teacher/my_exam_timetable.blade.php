@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">My Exam Timetable</h1>
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
                    <h2 class="" style="font-weight: bolder">Class : ({{ $value['class_name'] }})</h2>
                    @foreach ($value['exam'] as $exam)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title" style="font-weight: bolder; font-size: 20px">Exam Name :
                                    {{ $exam['exam_name'] }}</h3>
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
                                        @foreach ($exam['subject'] as $itemf)
                                            <tr>
                                                <td>{{ $itemf['subject_name'] }}</td>
                                                <td>{{ !empty($itemf['exam_date']) ? date('l', strtotime($itemf['exam_date'])) : '' }}
                                                </td>
                                                <td>{{ !empty($itemf['start_time']) ? date('h:i:A', strtotime($itemf['start_time'])) : '' }}
                                                </td>
                                                <td>{{ !empty($itemf['end_time']) ? date('h:i:A', strtotime($itemf['end_time'])) : '' }}
                                                </td>
                                                <td>{{ $itemf['room_number'] }}</td>
                                                <td>{{ $itemf['full_makes'] }}</td>
                                                <td>{{ $itemf['passing_marks'] }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    @if (!$loop->last)
                        <br>
                        <br>
                    @endif
                @endforeach


            </div>
        </section>
    </div>
@endsection
