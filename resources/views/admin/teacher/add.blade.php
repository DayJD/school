@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Teacher</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Teacher</h3>
                    </div>


                    <form method="POST"active="" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>First Name <span style="color: red">*</span></label>
                                    <input type="text" name="name" required
                                        class="form-control"value="{{ old('name') }}" placeholder="Enter first name">
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Last Name <span style="color: red">*</span></label>
                                    <input type="text" name="last_name" required
                                        class="form-control"value="{{ old('last_name') }}" placeholder="Enter last name">
                                    <p class="text-danger">{{ $errors->first('last_name') }}</p>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Gender <span style="color: red">*</span></label>
                                    <select class="form-control" required name="gender">
                                        <option value="">Select Gender</option>
                                        <option {{ old('gender') == 'male' ? 'selected' : '' }} value="male">Male
                                        </option>
                                        <option {{ old('gender') == 'female' ? 'selected' : '' }} value="female">Female
                                        </option>
                                        <option {{ old('gender') == 'other' ? 'selected' : '' }} value="other">Other
                                        </option>
                                    </select>
                                    <p class="text-danger">{{ $errors->first('gender') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="date_of_birth"
                                        class="form-control"value="{{ old('date_of_birth') }}">
                                    <p class="text-danger">{{ $errors->first('date_of_birth') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Date of Joining</label>
                                    <input type="date" name="admission_date"
                                        class="form-control"value="{{ old('admission_date') }}">
                                    <p class="text-danger">{{ $errors->first('admission_date') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile Number <span style="color: red">*</span></label>
                                    <input type="text" name="mobile_number" required
                                        class="form-control"value="{{ old('mobile_number') }}"
                                        placeholder="Enter Mobile Number">
                                    <p class="text-danger">{{ $errors->first('mobile_number') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Marital Status <span style="color: red">*</span></label>
                                    <input type="text" name="marital_status" required
                                        class="form-control"value="{{ old('marital_status') }}"
                                        placeholder="Enter Marital Status">
                                    <p class="text-danger">{{ $errors->first('marital_status') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Profile Pic</label>
                                    <input type="file" accept="image/jpeg, image/png" name="profile_pic"
                                        class="form-control">
                                    <p class="text-danger">{{ $errors->first('profile_pic') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Current Address <span style="color: red"></span></label>
                                    <textarea type="" name="address" class="form-control">{{ old('address') }}</textarea>
                                    <p class="text-danger">{{ $errors->first('address') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Permanent Address <span style="color: red"></span></label>
                                    <textarea type="" name="permanent_address" class="form-control">{{ old('permanent_address') }}</textarea>
                                    <p class="text-danger">{{ $errors->first('permanent_address') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Qualification <span style="color: red"></span></label>
                                    <textarea type="" name="qualification" class="form-control">{{ old('qualification') }}</textarea>
                                    <p class="text-danger">{{ $errors->first('qualification') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Work Experience <span style="color: red"></span></label>
                                    <textarea type="" name="work_experience" class="form-control"value="{{ old('work_experience') }}"></textarea>
                                    <p class="text-danger">{{ $errors->first('work_experience') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Note <span style="color: red"></span></label>
                                    <textarea type="" name="note" class="form-control"value="{{ old('note') }}"></textarea>
                                    <p class="text-danger">{{ $errors->first('note') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Status <span style="color: red">*</span></label>
                                    <select class="form-control" required name="status">
                                        <option value="">Select Status</option>
                                        <option {{ old('status') == 0 ? 'selected' : '' }} value="0">Active</option>
                                        <option {{ old('status') == 1 ? 'selected' : '' }} value="1">Inactive
                                        </option>
                                    </select>
                                    <p class="text-danger">{{ $errors->first('status') }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>Email <span style="color: red">*</span></label></label>
                                <input type="email" name="email" class="form-control"value="{{ old('email') }}"
                                    placeholder="Enter email">
                                <p class="text-danger">{{ $errors->first('email') }}</p>
                            </div>
                            <div class="form-group">
                                <label>Password <span style="color: red">*</span></label></label>
                                <input type="password" name="password" required class="form-control"
                                    placeholder="Password">
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
