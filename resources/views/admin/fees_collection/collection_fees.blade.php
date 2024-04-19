@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Collection Fees </h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search Collection Fees</h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Class</label>
                                    <select name="class_id" class="form-control" id="">
                                        <option value="">Selected Class</option>
                                        @foreach ($getClass as $class)
                                            <option {{ Request::get('class_id') == $class->id ? 'selected' : '' }}
                                                value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Student ID</label>
                                    <input type="text" name="student_id"
                                        class="form-control"value="{{ Request::get('student_id') }}" placeholder="Enter ID">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Student Name</label>
                                    <input type="text" name="name"
                                        class="form-control"value="{{ Request::get('name') }}" placeholder="Enter name">
                                </div>


                                <div
                                    class="form-group col-md-3 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('admin/fees_collection/collection_fees') }}"
                                        class="btn btn-success">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Collection Fees List</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Class Name</th>
                                    <th>Student Name</th>
                                    <th>Total Amount (฿)</th>
                                    <th>Paid Amount (฿)</th>
                                    <th>Remaning Amount (฿)</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($getRecord))
                                    @foreach ($getRecord as $value)
                                @php
                                // getPaidAmount อยู่หน้า User
                                    $paid_amount = $value->getPaidAmount($value->id ,$value->class_id);
                                    $RemaningAmount = $value->amount - $paid_amount;
                                @endphp
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->class_name }}</td>
                                            <td>{{ $value->name . ' ' . $value->last_name }}</td>
                                            <td>{{ number_format($value->amount, 2) }}฿</td>
                                            <td>{{ number_format($paid_amount, 2) }}฿</td>
                                            <td>{{ number_format($RemaningAmount, 2) }}฿</td>
                           
                                            <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                            <td>
                                                <a href="{{ url('admin/fees_collection/collection_fees/add_fees/' . $value->id) }}"
                                                    class="btn btn-success">Conllect Fees</a>
                                            </td>
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
