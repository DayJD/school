@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Home Work List</h1>
                    </div>

                </div>
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search My Submitting Homework </h3>
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
                                    <label>Selected Class</label>
                                    <select class="form-control"id="getClass" name="class_id">
                                        <option value="">Selected Class</option>
                                        @if (!empty($getClass))
                                            @foreach ($getClass as $class)
                                                <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                    value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Subject</label>
                                    <select class="form-control" id="getSubject" name="subject_id">
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
                                    <a href="{{ url('admin/homework/homework/homework_repost') }}" class="btn btn-success">Clear</a>
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
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>HomeWork Date</th>
                                <th>Submission Date</th>
                                <th>Document</th>
                                <th>Description</th>
                                <th>Created Date</th>
                                <th>Submitted Document</th>
                                <th>Submitted Description</th>
                                <th>Submitted Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($getRecordSubmit->isEmpty())
                                <tr>
                                    <td class="text-center" colspan="10">Record not found</td>
                                </tr>
                            @else
                                @foreach ($getRecordSubmit as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->users_name . ' ' . $value->last_name }}</td>
                                        <td>{{ $value->class_name }}</td>

                                        <td>{{ $value->subject_name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->getHomework->home_work_date)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->getHomework->submission_date)) }}</td>
                                        <td>
                                            @if (!empty($value->getHomework->getDocumentUrlSubmitted()))
                                                <a href="{{ $value->getHomework->getDocumentUrlSubmitted() }}" class="btn btn-primary"
                                                    download="">Download</a>
                                            @endif
                                        </td>

                                        <td>{!! $value->getHomework->description !!}</td>

                                        <td>{{ date('d-m-Y', strtotime($value->getHomework->created_at)) }}</td>

                                        <td>{!! $value->description !!}</td>
                                        <td>

                                            @if (!empty($value->getDocumentUrlSubmitted()))
                                                <a href="{{ $value->getDocumentUrlSubmitted() }}" class="btn btn-primary"
                                                    download="">Download</a>
                                            @endif
                                        </td>

                                        <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                    </tr>
                                @endforeach
                                <div class="modal fade" id="exampleModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>Description</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{!! $value->description !!}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </tbody>
                    </table>
                    @if (!empty($getRecordSubmit))
                        <div class="p-3 ">
                            {!! $getRecordSubmit->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
