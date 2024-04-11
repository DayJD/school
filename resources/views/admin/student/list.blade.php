@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Student List</h1>
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
                        <h3 class="card-title">Search Student</h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
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
                                <div class="form-group col-md-3">
                                    <label>Admission Number</label>
                                    <input type="text" name="admission_number" class="form-control"
                                        value="{{ Request::get('admission_number') }}" placeholder="Enter Admission Number">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Roll Number</label>
                                    <input type="text" name="Roll Number" class="form-control"
                                        value="{{ Request::get('admission_number') }}" placeholder="Enter Roll Number">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Class</label>
                                    <input type="text" name="class" class="form-control"
                                        value="{{ Request::get('class') }}" placeholder="Enter email">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Gender</label>

                                    <select class="form-control" name="gender">
                                        <option value="">Select Gender</option>
                                        <option {{ Request::get('gender') == 'male' ? 'selected' : '' }} value="male">
                                            Male
                                        </option>
                                        <option {{ Request::get('gender') == 'female' ? 'selected' : '' }} value="female">
                                            Female
                                        </option>
                                        <option {{ Request::get('gender') == 'other' ? 'selected' : '' }} value="other">
                                            Other
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Date of Birth</label>
                                    <input type="date" name="date_fo_birth" class="form-control"
                                        value="{{ Request::get('Date of Birth') }}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Caste</label>
                                    <input type="text" name="caste" class="form-control"
                                        value="{{ Request::get('caste') }}" placeholder="Enter Caste">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Religion</label>
                                    <input type="text" name="religion" class="form-control"
                                        value="{{ Request::get('religion') }}" placeholder="Enter Religion">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Mobile Number</label>
                                    <input type="text" name="mobile_number" class="form-control"
                                        value="{{ Request::get('mobile_number') }}" placeholder="Enter Mobile Number">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Select Status</option>
                                        <option {{ Request::get('status') == 100 ? 'selected' : '' }} value="100">
                                            Active</option>
                                        <option {{ Request::get('status') == 1 ? 'selected' : '' }} value="1">
                                            Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ Request::get('date') }}">
                                </div>
                                <div
                                    class="form-group col-md-3 p-3 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/student/list') }}" class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Student List (จำนวน : {{ $getRecord->total() }})</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Profile</th>
                                    <th>Student Name</th>
                                    <th>Parent Name</th>
                                    <th>Email</th>
                                    <th>Admission Number</th>
                                    <th>Roll Number</th>
                                    <th>Class</th>
                                    <th>Gender</th>
                                    <th>Date of Birth</th>
                                    <th>Caste</th>
                                    <th>Religion</th>
                                    <th>Mobile Number</th>
                                    <th>Admission Date</th>
                                    <th>Blood Group</th>
                                    <th>Height</th>
                                    <th>Weight</th>
                                    <th>Status</th>
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
                                                    style="width: 50px; height: 50px ; border-radius: 50px"
                                                    alt="">
                                            @endif
                                        </td>
                                        <td>{{ $value->name . ' ' . $value->last_name }}</td>
                                        <td>{{ $value->parent_name . ' ' . $value->parent_last_name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->admission_number }}</td>
                                        <td>{{ $value->roll_number }}</td>
                                        <td>{{ $value->class_name }}</td>
                                        <td>{{ $value->gender }}</td>
                                        <td>
                                            @if (!empty($value->date_of_birth))
                                                {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                                            @endif
                                        </td>
                                        <td>{{ $value->caste }}</td>
                                        <td>{{ $value->religion }}</td>
                                        <td>{{ $value->mobile_number }}</td>
                                        <td>
                                            @if (!empty($value->date_of_birth))
                                                {{ date('d-m-Y', strtotime($value->admission_date)) }}
                                            @endif
                                        </td>
                                        <td>{{ $value->blood_group }}</td>
                                        <td>{{ $value->height }}</td>
                                        <td>{{ $value->weight }}</td>
                                        <td>{{ $value->status == 0 ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        <td style="min-width: 150px;">
                                            <a href="{{ url('admin/student/edit/' . $value->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ url('admin/student/delete/' . $value->id) }}"
                                                class="btn btn-danger btn-sm">delete</a>
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
