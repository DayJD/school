@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Class Timetable List</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search Class Timetable</h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Selected Class</label>
                                    {{-- <select class="form-control getClass" name="class_id" required>
                                        <option value="">Selected Class</option>
                                        @foreach ($getClass as $class)
                                            <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Subject Name</label>
                                    <select class="form-control getSubject" name="subject_id" required>
                                        <option value="">Selected Subject</option>
                                        {{-- @if (!empty($getSubject))
                                            @foreach ($getSubject as $subject)
                                                <option {{ Request::get('subject_id') == $subject->id ? 'selected' : '' }}
                                                    value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                            @endforeach
                                        @endif --}}
                                    </select>
                                </div>
                                <div
                                    class="form-group col-md-3 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/class_timetable/list') }}" class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')



                @foreach ($result as $value)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $value['name'] }}</h3>
                        </div>
                        <div class="card-body p-0">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Week</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Room Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($value['week'] as $itemW)
                                    <tr>
                                        <td>{{ $itemW['week_name'] }}</td>
                                        <td>{{ !empty($itemW['start_time']) ? date('h:i:A',strtotime($itemW['start_time'])) : '' }}</td>
                                        <td>{{ !empty($itemW['end_time']) ? date('h:i:A',strtotime($itemW['end_time'])) : '' }}</td>
                                        <td>{{ $itemW['room_number'] }}</td>
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
