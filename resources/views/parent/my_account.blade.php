@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">My Account</h1>
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
                        <h3 class="card-title">My Account</h3>
                    </div>

                    <form method="POST"active="" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>First Name <span style="color: red">*</span></label>
                                    <input type="text" name="name" required
                                        class="form-control"value="{{ old('name', $getRecord->name) }}"
                                        placeholder="Enter first name">
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Last Name <span style="color: red">*</span></label>
                                    <input type="text" name="last_name" required
                                        class="form-control"value="{{ old('last_name', $getRecord->last_name) }}"
                                        placeholder="Enter last name">
                                    <p class="text-danger">{{ $errors->first('last_name') }}</p>
                                </div>
             
                                <div class="col-md-6 form-group">
                                    <label>Gender <span style="color: red">*</span></label>
                                    <select class="form-control" required name="gender">
                                        <option value="">Select Gender</option>
                                        <option {{ old('gender', $getRecord->gender) == 'male' ? 'selected' : '' }}
                                            value="male">Male
                                        </option>
                                        <option {{ old('gender', $getRecord->gender) == 'female' ? 'selected' : '' }}
                                            value="female">Female
                                        </option>
                                        <option {{ old('gender', $getRecord->gender) == 'other' ? 'selected' : '' }}
                                            value="other">Other
                                        </option>
                                    </select>
                                    <p class="text-danger">{{ $errors->first('gender') }}</p>
                                </div>
                               
                                <div class="col-md-6 form-group">
                                    <label>Occupation <span style="color: red">*</span></label>
                                    <input type="text" name="occupation" required
                                        class="form-control"value="{{ old('occupation', $getRecord->occupation) }}"
                                        placeholder="Enter Occupation">
                                    <p class="text-danger">{{ $errors->first('occupation') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile Number <span style="color: red">*</span></label>
                                    <input type="text" name="mobile_number" required
                                        class="form-control"value="{{ old('mobile_number', $getRecord->mobile_number) }}"
                                        placeholder="Enter Mobile Number">
                                    <p class="text-danger">{{ $errors->first('mobile_number') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Address <span style="color: red">*</span></label>
                                    <input type="text" name="address" required
                                        class="form-control"value="{{ old('address', $getRecord->address) }}"
                                        placeholder="Enter Address">
                                    <p class="text-danger">{{ $errors->first('address') }}</p>
                                </div>
                               
                                <div class="col-md-6 form-group">
                                    <label>Profile Pic</label>
                                    <input type="file" name="profile_pic" class="form-control" accept="image/jpeg, image/png">
                                    <p class="text-danger">{{ $errors->first('profile_pic') }}</p>
                                    @if (!empty($getRecord->getProfile()))
                                        <img src="{{ $getRecord->getProfile() }}" style="width: 100px"
                                            alt="Profile Picture">
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>Email <span style="color: red">*</span></label></label>
                                <input type="email" name="email"
                                    class="form-control"value="{{ old('email', $getRecord->email) }}"
                                    placeholder="Enter email">
                                <p class="text-danger">{{ $errors->first('email') }}</p>
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
