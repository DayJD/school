@extends('layouts.app')
@section('content')


    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Parent Student List ({{ $getParent->name . '  ' . $getParent->last_name }})</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right">
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Search Parent</h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Student ID</label>
                                    <input type="text" name="id"
                                        class="form-control"value="{{ Request::get('id') }}" placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Name</label>
                                    <input type="text" name="name"
                                        class="form-control"value="{{ Request::get('name') . ' ' . Request::get('lastname') }}"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control"
                                        value="{{ Request::get('email') }}" placeholder="Enter email">
                                </div>
                                <div
                                    class="form-group col-md-3 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/parent/my-student/' . $parent_id) }}"
                                        class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')
                @if (!empty($getSearchStudent))
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Student List</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($getSearchStudent as $value)
                                        <tr>
                                            {{-- <pre>
                                                {{ print_r($getSearchStudent->toArray())}}
                                            </pre> --}}
                                            <td>{{ $value->id }}</td>
                                            <td>
                                                @if (!empty($value->getProfile()))
                                                    <img src="{{ $value->getProfile() }}"
                                                        style="width: 50px; height: 50px ; border-radius: 50px"
                                                        alt="">
                                                @endif
                                            </td>
                                            <td>{{ $value->name . ' ' . $value->last_name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                            <td style="min-width: 150px;">
                                                <a href="{{ url('admin/parent/assign_student_parent/' . $value->id . '/' . $parent_id) }}"
                                                    class="btn btn-primary btn-sm">Add Student to Parent</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="p-3 ">
                                {{-- {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!} --}}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Parent List</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Profile</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>
                                            @if (!empty($value->getProfile()))
                                                <img src="{{ $value->getProfile() }}"
                                                    style="width: 50px; height: 50px ; border-radius: 50px" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $value->name . ' ' . $value->last_name }}</td>
                                        <td>{{ $value->email }}</td>
                                        {{-- <td>{{ $value->parent_name }}</td> --}}
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        <td style="min-width: 150px;">
                                            <a href="{{ url('admin/parent/assign_student_parent_delete/' . $value->id) }}"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </td>
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
