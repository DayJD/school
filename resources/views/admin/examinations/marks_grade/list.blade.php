@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Marks Grade</h1>
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

                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Marks Grade List</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Grade Name</th>
                                    <th>Percent From</th>
                                    <th>Percent To</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1
                                @endphp
                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->percent_from }}</td>
                                        <td>{{ $value->percent_to }}</td>
                                        <td>{{ $value->created_by_name }}</td>
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        <td>
                                            <a href="{{ url('admin/examinations/marks_grade/edit/' . $value->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <a href="{{ url('admin/examinations/marks_grade/delete/  ' . $value->id) }}"
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
