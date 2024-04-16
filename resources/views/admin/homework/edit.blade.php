@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Notice Board</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Notice Board</h3>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="from-group">
                                <label>Class</label>
                                <select class="form-control" id="getClass" name="class_id" required>
                                    <option value="">Select class</option>
                                    @foreach ($getClass as $class)
                                        <option {{ $getRecord->class_id == $class->id ? 'selected' : '' }}
                                            value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="from-group">
                                <label>Subject</label>
                                <select class="form-control" id="getSubject" name="subject_id" required>
                                    <option value="">Select Subject</option>
                                    @foreach ($getSubject as $subject)
                                        <option {{ $getRecord->subject_id == $subject->subject_id ? 'selected' : '' }}
                                            value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Home Work Date</label>
                                <input type="date" name="home_work_date" required
                                    value="{{ $getRecord->home_work_date }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Submission Date</label>
                                <input type="date" name="submission_date" required
                                    value="{{ $getRecord->submission_date }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Document</label>
                                <div class="custom-file">
                                    <input type="file" id="document_file" name="document_file" class="custom-file-input"
                                        accept="*">
                                    <label class="custom-file-label"
                                        for="document_file">{{ $getRecord->document_file }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="compose-textarea" class="form-control" name="description" style="height: 300px;">{!! $getRecord->description !!}</textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {
            $('#compose-textarea').summernote({
                placeholder: 'Compose an e-mail',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
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
        });
        $('#document_file').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endsection
