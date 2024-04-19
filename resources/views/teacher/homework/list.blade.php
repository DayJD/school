@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Home Work List</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right">
                        <a href="{{ url('teacher/homework/homework/add') }}" class="btn btn-primary">เพิ่ม</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search Home Work </h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Selected Class</label>
                                    <select class="form-control"id="getClass" name="class_id">
                                        <option value="">Selected Class</option>
                                        @foreach ($getClass as $class)
                                            <option {{ Request::get('class_id') == $class->class_id ? 'selected' : '' }}
                                                value="{{ $class->class_id }}">{{ $class->class_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Subject</label>
                                    <select class="form-control" id="getSubject" name="subject_id" required>
                                        <option value="">Select Subject</option>
                                        @if (!empty($getSubject))
                                            @foreach ($getSubject as $subject)
                                                <option
                                                    {{ Request::get('subject_id') == $subject->subject_id ? 'selected' : '' }}
                                                    value="{{ $subject->subject_id }}">{{ $subject->subject_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div
                                    class="form-group col-md-4 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('teacher/homework/homework/') }}" class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @include('_message')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Home Work List</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>HomeWork Date</th>
                                <th>Submission Date</th>
                                <th>Created at</th>
                                <th>Document</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($getRecord->isEmpty())
                                <tr>
                                    <td colspan="10" class="text-center">Record not found</td>
                                </tr>
                            @else
                                @foreach ($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->class_name }}</td>
                                        <td>{{ $value->subject_name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->home_work_date)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->submission_date)) }}</td>
                                        <td>{{ $value->created_by_name }}</td>
                                        <td>
                                            @if (!empty($value->getDocumentUrl()))
                                                <a href="{{ $value->getDocumentUrl() }}" class="btn btn-primary"
                                                    download="">Download</a>
                                            @endif
                                        </td>
                                        <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        <td>
                                            <a href="{{ url('teacher/homework/homework/edit/' . $value->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <a href="{{ url('teacher/homework/homework/delete/' . $value->id) }}"
                                                class="btn btn-danger">delete</a>
                                            <a href="{{ url('teacher/homework/homework/submitted/' . $value->id) }}"
                                                class="btn btn-info">Submitted Homework</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if (!empty($getRecord))
                        <div class="p-3 ">
                            {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $('#getClass').change(function() {
            var class_id = $(this).val();
            $.ajax({
                url: "{{ url('admin/ajax_get_subject') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "class_id": class_id,
                },
                dataType: "json",
                success: function(data) {
                    $('#getSubject').html(data.success);
                }
            });
            $(window).on('load', function() {
                $('#getClass').trigger('change');
            });

            // หลังจากเปลี่ยนแปลงใน dropdown ของ getSubject ให้ทำการเก็บค่าไว้ในตัวแปร subject
            $('#getSubject').change(function() {
                var subject_id = $(this).val();
                console.log(subject_id); // แสดงค่า subject_id ใน console เมื่อมีการเปลี่ยนแปลง
            });
        });
    </script>
@endsection
