@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Collection Fees Repost</h1>
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
                                    <label>Student ID</label>
                                    <input type="text" name="student_id"
                                        class="form-control"value="{{ Request::get('student_id') }}"
                                        placeholder="Enter ID">
                                </div>
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
                                    <label>Selected Payment Type</label>
                                    <select class="form-control"id="payment_type" name="payment_type">
                                        <option value="">Selected Payment Type</option>
                                      
                                        <option {{ Request::get('payment_type') == 'Cash' ? 'selected' : '' }} value="Cash">Cash</option>
                                        <option {{ Request::get('payment_type') == 'Cheque' ? 'selected' : '' }} value="Cheque">Cheque</option>
                                        <option {{ Request::get('payment_type') == 'Stripe' ? 'selected' : '' }} value="Stripe">Stripe</option>
                                      
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
                        <h3 class="card-title">Collection Fees Repost</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Class Name</th>
                                    <th>Total Amount (฿)</th>
                                    <th>Paid Amount (฿)</th>
                                    <th>Remaning Amount (฿)</th>
                                    <th>Payment Type</th>
                                    <th>Remark</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($getRecord))
                                    @foreach ($getRecord as $value)
                                        <tr>
                                            <td>{{ $value->student_id }}</td> 
                                            <td>{{ $value->student_name . ' ' . $value->student_last_name }}</td>
                                            <td>{{ $value->class_name }}</td> 
                                            <td>{{ number_format($value->total_amount, 2) }}฿</td>
                                            <td>{{ number_format($value->paid_amount, 2) }}฿</td>
                                            <td>{{ number_format($value->remaning_amount, 2) }}฿</td>
                                            <td>{{ $value->payment_type }}</td> 
                                            <td>{{ $value->remark }}</td> 
                                            <td>{{ $value->created_by_name }}</td> 
                                            <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="100%" class="text-center">Record not found</td>
                                @endif
                            </tbody>
                        </table>
                        <div class="p-3 ">
                            @if (!empty($getRecord))
                                {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
