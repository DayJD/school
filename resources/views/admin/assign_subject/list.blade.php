@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Subject Assign List</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right">
                        <a href="{{ 'add' }}" class="btn btn-primary">เพิ่ม</a>
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
                        <h3 class="card-title">Search Assign Subject</h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Class Name</label>
                                    <input type="text" name="class_name"
                                        class="form-control"value="{{ Request::get('class_name') }}"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Subject Name</label>
                                    <input type="text" name="subject_name"
                                        class="form-control"value="{{ Request::get('subject_name') }}"
                                        placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ Request::get('date') }}">
                                </div>
                                <div
                                    class="form-group col-md-3 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/assign_subject/list') }}" class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Assign Subject List</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Class Name</th>
                                    <th>Subject Name</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->class_name }}</td>
                                        <td>{{ $value->subject_name }}</td>
                                        <td>

                                            @if ($value->status == 0)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </td>
                                        <td>{{ $value->created_by_name }}</td>
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        <td>
                                            <a href="{{ url('admin/assign_subject/edit/' . $value->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <a href="{{ url('admin/assign_subject/edit_single/' . $value->id) }}"
                                                class="btn btn-warning">Edit Single</a>
                                            <a href="{{ url('admin/assign_subject/delete/' . $value->id) }}"
                                                class="btn btn-danger">delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- @php($groupedRecords = $getRecord->groupBy('class_id'))
                            <pre>
                            {{ print_r($groupedRecords->toArray()) }}
                            </pre>
                            
                            @foreach ($groupedRecords as $classId => $records)
                                <tr>

                                    <td>{{ $classId }}</td>
                                    <td>{{ $records->first()->class_name }}</td>
                                    <td>
                                        @php($subjectNames = $records->pluck('subject_name')->toArray())

                                        @foreach ($subjectNames as $subjectName)
                                            {{ $subjectName }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($records->first()->status == 0)
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                    </td>
                                    <td>{{ $records->first()->created_by_name }}</td>
                                    <td>{{ date('d-m-Y H:i A', strtotime($records->first()->created_at)) }}</td>
                                    <td>
                                        <a href="{{ url('admin/assign_subject/edit/' . $classId) }}"
                                            class="btn btn-warning">Edit</a>
                                        <a href="{{ url('admin/assign_subject/delete/' . $classId) }}"
                                            class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach --}}
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
