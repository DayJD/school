@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            My Student List Teacher:
                            @if (isset($getRecord[0]['teacher_name']))
                                {{ $getRecord[0]['teacher_name'] }}
                            @endif
                        </h1>
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
                        <h3 class="card-title">Student List</h3>
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
                                    <th>Created Date</th>
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
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->parent_name }}</td>
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
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
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
