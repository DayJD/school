@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Notice Board</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add Notice Board</h3>
                    </div>
                    <form method="POST" action="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="col-md-6 form-group">
                                <label>Title</label>
                                <input type="text" name="title" required class="form-control"
                                    value="{{ old('title') }}" placeholder="Enter title">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Notice Date</label>
                                <input type="date" name="notice_date" required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Publish Date</label>
                                <input type="date" name="publish_date" required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label style="display: block">Message To</label>
                                <label class="mr-3">
                                    <input type="checkbox" value="3" name="message_to[]">
                                    Student
                                </label>
                                <label class="mr-3">
                                    <input type="checkbox" value="4" name="message_to[]">
                                    Parent
                                </label>
                                <label class="mr-3">
                                    <input type="checkbox" value="2" name="message_to[]">
                                    Teacher
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea id="compose-textarea" class="form-control" name="message" style="height: 300px;">{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="card-body"></div>
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
                placeholder: 'Compose an Notice board',
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
    </script>
@endsection