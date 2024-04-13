@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Grade</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Grade</h3>
                    </div>
                    <form method="POST"active="">
                        {{ csrf_field() }}
                        <div class="card-body">
                
                            <div class="form-group">
                                <label>Grade Name</label>
                                <input type="text" name="name" class="form-control"value="{{ old('name', $getRecord->name) }}"
                                    placeholder="Enter Exam Name">
                            </div>
                            <div class="form-group">
                                <label>Percent From</label>
                                <input type="number" name="percent_from"
                                    class="form-control"value="{{ old('percent_from',  $getRecord->percent_from) }}" placeholder="Enter Percent From">
                            </div>
                            <div class="form-group">
                                <label>Percent To</label>
                                <input type="number" name="percent_to" class="form-control"value="{{ old('percent_to' , $getRecord->percent_to) }}"
                                    placeholder="Enter Percent To">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
