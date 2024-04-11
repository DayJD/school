@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Exam List</h1>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Search</h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Exam Name</label>
                                    <input type="text" name="exam_name"
                                        class="form-control"value="{{ Request::get('exam_name') }}" placeholder="Enter Exam">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>note</label>
                                    <input type="text" name="note"
                                        class="form-control"value="{{ Request::get('note') }}" placeholder="Enter note">
                                </div>
                               
                               
                                <div
                                    class="form-group col-md-3 p-3 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{url('admin/examinations/exam/list')}}" class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Exam List (จำนวน : {{ $getRecord->total() }})</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Exam Name</th>
                                    <th>Note</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->note }}</td>
                                        <td>{{ $value->created_name }}</td>
                                     
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        <td>
                                            <a href="{{ url('admin/examinations/exam/edit/' . $value->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <a href="{{ url('admin/examinations/exam/delete/' . $value->id) }}"
                                                class="btn btn-danger">delete</a>
                                        </td>
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
