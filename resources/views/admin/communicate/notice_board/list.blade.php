@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Notice Board List</h1>
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
                        <h3 class="card-title">Search Notice Board </h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Title</label>
                                    <input type="text" name="title"
                                        class="form-control"value="{{ Request::get('title')}}"
                                        placeholder="Enter title">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Notice Date Start</label>
                                    <input type="date" name="start_notice_date" class="form-control"
                                        value="{{ Request::get('start_notice_date') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Notice Date End</label>
                                    <input type="date" name="end_notice_date" class="form-control"
                                        value="{{ Request::get('end_notice_date') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Publish Date Start</label>
                                    <input type="date" name="start_publish_date" class="form-control"
                                        value="{{ Request::get('start_publish_date') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Publish Date End</label>
                                    <input type="date" name="end_publish_date" class="form-control"
                                        value="{{ Request::get('end_publish_date') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Message To</label>
                                    <select class="form-control" name="message_to">
                                        <option value="">Select</option>
                                        <option {{ Request::get('message_to') == 3 ? 'selected' : '' }} value="3">
                                            Student
                                        </option>
                                        <option {{ Request::get('message_to') == 4 ? 'selected' : '' }} value="4">
                                            Teacher
                                        </option>
                                        <option {{ Request::get('message_to') == 2 ? 'selected' : '' }} value="2">
                                            Parent
                                        </option>
                                    </select>
                                </div>
                                <div
                                    class="form-group col-md-2 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/communicate/notice_board/list') }}" class="btn btn-success">Clear</a>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Notice Board List</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Notice Date</th>
                                    <th>Publish Date</th>
                                    <th>Message to</th>
                                    <th>Created at</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->title }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->notice_date)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->publish_date)) }}</td>
                                        <td>
                                            @foreach ($value->getMessage as $message)
                                                @if ($message->message_to == 1)
                                                    Admin
                                                @elseif ($message->message_to == 2)
                                                    Teacher
                                                @elseif ($message->message_to == 3)
                                                    Student
                                                @elseif ($message->message_to == 4)
                                                    Parent
                                                @endif
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $value->created_by_name }}</td>
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        <td>
                                            <a href="{{ url('admin/communicate/notice_board/edit/' . $value->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <a href="{{ url('admin/communicate/notice_board/delete/' . $value->id) }}"
                                                class="btn btn-danger">delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        @if (!empty($getRecord))
                            <div class="p-3 ">
                                {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


