@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Assign Class Teacher</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Assign Class Teacher</h3>
                    </div>
                    <form method="POST"active="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Class Name</label>
                                <select class="form-control" name="class_id" required>
                                    <option value="">Select class</option>
                                    @foreach ($getClass as $class)
                                        <option {{ $getRecord->class_id == $class->id ? 'selected' : '' }}
                                            value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Teacher Name</label>

                                @foreach ($getTeacher as $teacher)
                                    <div class="">
                                        <label for="">
                                            @php
                                                $checked = '';
                                            @endphp
                          
                                            @foreach ($getAssignTeacherID as $teacherID)
                                                @if ($teacherID->teacher_id == $teacher->id)
                                                    @php
                                                        $checked = 'checked';
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <input {{ $checked }} type="checkbox"
                                                name="teacher_id[]"value="{{ $teacher->id }}">
                                            {{ $teacher->name . ' ' . $teacher->last_name }}

                                        </label>
                                    </div>
                                @endforeach

                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option {{ $getRecord->status == 0 ? 'selected' : '' }} value="0">Active</option>
                                    <option {{ $getRecord->status == 1 ? 'selected' : '' }} value="1">Inactive
                                    </option>
                                </select>
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
