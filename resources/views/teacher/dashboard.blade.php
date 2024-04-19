@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $TotalStudent }}</h3>
                                <p>TotalStudent</p>
                            </div>
                            <div class="icon">
                              <i class="nav-icon fas fa-table"></i>
                            </div>
                            <a href="{{ url('admin/parent/list') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $TotalClass }}</h3>
                                <p>Total Class</p>
                            </div>
                            <div class="icon">
                              <i class="nav-icon fas fa-table"></i>
                            </div>
                            <a href="{{ url('admin/parent/list') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $TotalSubject }}</h3>
                                <p>Total Subject</p>
                            </div>
                            <div class="icon">
                              <i class="nav-icon fas fa-table"></i>
                            </div>
                            <a href="{{ url('admin/parent/list') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $TotalNoticeBoard   }}</h3>
                                <p>TotalNoticeBoard</p>
                            </div>
                            <div class="icon">
                              <i class="nav-icon fas fa-table"></i>
                            </div>
                            <a href="{{ url('admin/parent/list') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
