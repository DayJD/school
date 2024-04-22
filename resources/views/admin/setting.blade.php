@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Setting</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('_message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Setting</h3>
                    </div>
                    <form method="POST"active="" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                           
                            <div class="form-group">
                                <label>Paypal Email</label>
                                <input type="email" name="paypal_email" class="form-control"
                                    value="{{ $getRecord->paypal_email }}" placeholder="Enter email">

                            </div>
                            <div class="form-group">
                                <label>Stripe key</label>
                                <input type="text" name="stripe_key" class="form-control"
                                    value="{{ $getRecord->stripe_key }}">

                            </div>
                            <div class="form-group">
                                <label>Stripe Secret</label>
                                <input type="text" name="stripe_secret" class="form-control"
                                    value="{{ $getRecord->stripe_secret }}">
                            </div>
                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" name="logo" class="form-control" accept="image/jpeg, image/png">
                                @if (!empty($getRecord->getLogo()))
                                    <img src="{{ $getRecord->getLogo() }}"
                                        style="width: 50px; height: 50px ; border-radius: 50px" alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Fevicon Icon</label>
                                <input type="file" name="fevicon_icon" class="form-control"
                                    accept="image/jpeg, image/png">
                                @if (!empty($getRecord->getFevicon()))
                                    <img src="{{ $getRecord->getFevicon() }}"
                                        style="width: 50px; height: 50px ; border-radius: 50px" alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>School name</label>
                                <input type="text" name="school_name" class="form-control"
                                    value="{{ $getRecord->school_name }}">

                            </div>
                            <div class="form-group">
                                <label>Exam Description</label>
                                <textarea name="exam_description" class="form-control">{{ $getRecord->exam_description }}</textarea>
                                

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
