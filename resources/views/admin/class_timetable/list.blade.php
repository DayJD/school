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
                                    <select class="form-control getClass" name="class_id" required>
                                        <option value="">Selected Class</option>
                                        @foreach ($getClass as $class)
                                            <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Subject Name</label>
                                    <select class="form-control getSubject" name="subject_id" required>
                                        <option value="">Selected Subject</option>
                                        @if (!empty($getSubject))
                                            @foreach ($getSubject as $subject)
                                                <option {{ Request::get('subject_id') == $subject->subject_id ? 'selected' : '' }}
                                                    value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                                            @endforeach
                                        @endif
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

                @if (!empty(Request::get('class_id')) && !empty(Request::get('subject_id')))
                    <form action="{{ url('admin/class_timetable/add') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="subject_id" id="" value="{{ Request::get('subject_id') }}">
                        <input type="hidden" name="class_id" id="" value="{{ Request::get('class_id') }}">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Class Timetable List (Class: {{$class->name . '|| Subject :' . $subject->subject_name }})</h3>
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
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($week as $value)
                                            <tr>
                                                <th>
                                                    {{ $value['week_name'] }}
                                                    <input type="hidden" name="timetable[{{ $i }}][week_id]"
                                                        value="{{ $value['week_id'] }}">
                                                </th>
                                                <th><input type="time" name="timetable[{{ $i }}][start_time]"
                                                        class="form-control" value="{{ $value['start_time'] }}"></th>
                                                <th><input type="time" name="timetable[{{ $i }}][end_time]"
                                                        class="form-control" value="{{ $value['end_time'] }}"></th>
                                                <th><input type="text"
                                                        name="timetable[{{ $i }}][room_number]"
                                                        class="form-control" value="{{ $value['room_number'] }}"></th>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
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


@section('script')
    <script>
        $('.getClass').change(function() {
            var class_id = $(this).val();
            $.ajax({
                url: "{{ url('admin/class_timetable/get_subject') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "class_id": class_id,
                },
                dataType: "json",
                success: function(response) {
                    $('.getSubject').html(response.html);
                },
            });
        });
    </script>
@endsection
