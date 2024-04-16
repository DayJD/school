@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/select2/css/select2.min.css') }}">
    <style>
        .select2-container .select2-selection--single {
            height: 40px;
            /* ปรับความสูงตามที่ต้องการ */
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Send Email</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        
        @include('_message')
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add Send Email</h3>
                    </div>
                    <form method="POST" action="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="col-md-12 form-group">
                                <label>Subject To : </label>
                                <input type="text" name="send_subject" required class="form-control"
                                    placeholder="Enter Send Subject">
                            </div>

                            <div class="col-md-12 form-group">
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
                            <div class="form-group col-md-12">
                                <label>User (Student / Parent / Teacher)</label>
                                <select class="form-control select2" name="user_id">
                                    <option value="">-- User --</option>

                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Message</label>
                                <textarea id="compose-textarea" class="form-control" name="message" style="height: 300px;">{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="card-body"></div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Send Email</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    <script src="{{ url('public/plugins/select2/js/select2.full.min.js') }}"></script>
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
        $(document).ready(function() {
            $('.select2').select2({
                ajax: {
                    url: "{{ url('admin/communicate/search_user') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                }
            });
        });
    </script>
@endsection
