@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Notice Board List</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search Notice Board </h3>
                    </div>
                    <form method="get"active="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Title</label>
                                    <input type="text" name="title"
                                        class="form-control"value="{{ Request::get('title') }}" placeholder="Enter title">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Notice Date Start</label>
                                    <input type="date" name="start_notice_date" class="form-control"
                                        value="{{ Request::get('start_notice_date') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Notice Date End</label>
                                    <input type="date" name="end_notice_date" class="form-control"
                                        value="{{ Request::get('end_notice_date') }}">
                                </div>


                                <div
                                    class="form-group col-md-2 d-flex align-items-md-end justify-content-md-start justify-content-sm-center">
                                    <button type="submit" class="btn btn-primary mr-1">Search</button>
                                    <a href="{{ url('student/my_notice_board') }}" class="btn btn-success">Clear</a>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @foreach ($getRecord as $value)
                    <div class="">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3>{{ $value->title }}</h3>
                                <h6><span class="mailbox-read-time float-right"
                                        style="font-weight: bold;color: #000;font-size: 16px">{{ date('d-m-Y', strtotime($value->notice_date)) }}</span>
                                </h6>
                            
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <p>{!! $value->message !!}</p>
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            @if ($getRecord)
                {!! $getRecord->appends(\Illuminate\Support\Facades\Request::except('page'))->links() !!}
            @endif
        </section>
    </div>
@endsection
