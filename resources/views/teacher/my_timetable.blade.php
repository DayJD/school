@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Class Timetable ({{ $getClass['name'] . ' - ' . $getSubject['name']}})</h1>
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



                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $getClass['name'] . ' - ' . $getSubject['name']}}</h3>
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
                                    
                                    @foreach ($result as $itemW)
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
            </div>
        </section>
    </div>
@endsection
