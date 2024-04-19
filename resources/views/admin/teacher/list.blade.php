@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Teacher List</h1>
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
                        <h3 class="card-title">Search Teacher</h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Name</label>
                                    <input type="text" name="name"
                                        class="form-control"value="{{ Request::get('name') . ' ' . Request::get('lastname') }}"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control"
                                        value="{{ Request::get('email') }}" placeholder="Enter email">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Marital Status</label>
                                    <input type="text" name="marital_status" class="form-control"
                                        value="{{ Request::get('marital_status') }}" placeholder="Enter Marital Status">
                                </div>

                                <div class="form-group col-md-2">
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

                                <div class="form-group col-md-2">
                                    <label>Mobile Number</label>
                                    <input type="text" name="mobile_number" class="form-control"
                                        value="{{ Request::get('mobile_number') }}" placeholder="Enter Mobile Number">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Select Status</option>
                                        <option {{ Request::get('status') == 100 ? 'selected' : '' }} value="100">
                                            Active</option>
                                        <option {{ Request::get('status') == 1 ? 'selected' : '' }} value="1">
                                            Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Date of Joining</label>
                                    <input type="date" name="admission_date" class="form-control"
                                        value="{{ Request::get('admission_date') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Created Date</label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ Request::get('date') }}">
                                </div>
                                <div
                                    class="form-group col-md-2 p-3 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/teacher/list') }}" class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">teacher List (จำนวน : {{ $getRecord->total() }})</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Profile</th>
                                    <th>Teacher Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Date of Birth</th>
                                    <th>Date of Joining</th>
                                    <th>Mobile Number</th>
                                    <th>Marital Status</th>
                                    <th>Current Address</th>
                                    <th>Permanent Address</th>
                                    <th>Qualification</th>
                                    <th>Work Experience</th>
                                    <th>Note</th>
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
                                            @if (!empty($value->getProfileDirect()))
                                                <img src="{{ $value->getProfileDirect() }}"
                                                    style="width: 50px; height: 50px ; border-radius: 50px" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $value->name . ' ' . $value->last_name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->gender }}</td>
                                        <td>
                                            @if (!empty($value->date_of_birth))
                                                {{ date('d-m-Y', strtotime($value->date_of_birth)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($value->admission_date))
                                                {{ date('d-m-Y', strtotime($value->admission_date)) }}
                                            @endif
                                        </td>
                                        <td>{{ $value->mobile_number }}</td>
                                        <td>{{ $value->marital_status }}</td>
                                        <td>{{ $value->address }}</td>
                                        <td>{{ $value->permanent_address }}</td>
                                        <td>{{ $value->qualification }}</td>
                                        <td>{{ $value->work_experience }}</td>
                                        <td>{{ $value->note }}</td>
                                        <td>{{ $value->status == 0 ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        <td style="min-width: 150px;">
                                            <a href="{{ url('admin/teacher/edit/' . $value->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ url('admin/teacher/delete/' . $value->id) }}"
                                                class="btn btn-danger btn-sm">delete</a>
                                            <a href="{{ url('chat?receiver_id=' . base64_encode($value->id)) }}"
                                                class="btn btn-success">Send Message</a>
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
