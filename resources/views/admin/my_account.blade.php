@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">MyAccount</h1>
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
                        <h3 class="card-title">MyAccount</h3>
                    </div>
                    <form method="POST"active="">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $getRecord->name) }}"
                                    placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"value="{{ old('email', $getRecord->email) }}"
                                    placeholder="Enter email">
                                <p class="text-danger">{{ $errors->first('email') }}</p>
                            </div>
                            <div class="form-group">
                                <label>Profile Pic</label>
                                <input type="file" name="profile_pic" class="form-control" accept="image/jpeg, image/png">
                                <p class="text-danger">{{ $errors->first('profile_pic') }}</p>
                                @if (!empty($getRecord->getProfile()))
                                    <img src="{{ $getRecord->getProfile() }}" style="width: 100px"
                                        alt="Profile Picture">
                                @endif
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
