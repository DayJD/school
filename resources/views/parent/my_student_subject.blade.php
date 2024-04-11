@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">My Subject <span
                                style="color: blue">({{ $getUser->name . ' ' . $getUser->last_name }})</span></h1>
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
                        <h3 class="card-title">My Subject ({{ $getRecord[0]['class_name'] }})</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Subject Name</th>
                                    <th>Subject Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->subject_name }}</td>
                                        <td>{{ $value->subject_type }}</td>
                                        <td><a href="{{ url('parent/my_student/subject/class_timetable/' . $value->class_id . '/' . $value->subject_id .'/' . $getUser->id) }} "
                                                class="btn btn-sm btn-primary">My Class Timetable</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-3 ">
                            {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
