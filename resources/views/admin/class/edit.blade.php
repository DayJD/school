@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Class</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Class</h3>
                    </div>
                    <form method="POST"active="">
                        {{ csrf_field() }}
                        <div class="card-body">
                           
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $getRecord->name }}" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label>Amount (฿)</label>
                                <input type="number" name="amount" class="form-control" required
                                value="{{ $getRecord->amount }}" placeholder="Enter Amount">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option {{ ($getRecord->status == 0) ? 'selected' : '' }} value="0">Active</option>
                                    <option {{ ($getRecord->status == 1) ? 'selected' : '' }} value="1">Inactive</option>
                                </select>
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
