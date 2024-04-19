@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Collection Fees <span style="color: blue">({{ $getStudent->name . ' ' . $getStudent->last_name }})</span> </h1>
                    </div>
                    
                    <div class="col-sm-6" style="text-align: right">
                        <button type="button" id="AddFees" data-bs-toggle="modal" data-bs-target="#exampleModal"
                            class="btn btn-primary">เพิ่ม</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">

                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Collection Fees List</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
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
                                @if (!empty($getFees))
                                    @foreach ($getFees as $value)
                                        <tr>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Collection Fees </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Class Name : {{ $getStudent->class_name }} </label>
                        </div>
                        <div class="form-group">
                            <label>Total Amount : {{ number_format($getStudent->amount,2) }}฿ </label>
                        </div>
                        <div class="form-group">
                            <label>Paid Amount : {{ number_format($paid_amount,2) }}฿ </label>
                        </div>
                        <div class="form-group">
                            <label>Remaning Amount : 
                                @php
                                    $RemaningAmount = $getStudent->amount - $paid_amount;
                                @endphp
                                {{ number_format($RemaningAmount,2) }}฿
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" name="amount">
                        </div>
                        <div class="form-group">
                            <label>Payment Type <span style="color: red">*</span></label>
                            <select class="form-control" name="payment_type" required id="">
                                <option value="">Select</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Message:</label>
                            <textarea class="form-control" name="remark"></textarea>
                          </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
