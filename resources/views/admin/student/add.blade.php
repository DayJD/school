@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Student</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Student</h3>
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
                                    <label>Admission Number <span style="color: red">*</span></label>
                                    <input type="text" name="admission_number" required
                                        class="form-control"value="{{ old('admission_number') }}"
                                        placeholder="Enter Admission Number">
                                    <p class="text-danger">{{ $errors->first('admission_number') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Roll Number <span style="color: red">*</span></label>
                                    <input type="text" name="roll_number" required
                                        class="form-control"value="{{ old('roll_number') }}"
                                        placeholder="Enter Roll Number">
                                    <p class="text-danger">{{ $errors->first('roll_number') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Class <span style="color: red">*</span></label>
                                    <select class="form-control" required name="class_id">
                                        <option value="">Select Class</option>
                                        @foreach ($getClass as $class)
                                            <option {{ old('class_id') == $class->id ? 'selected' : '' }}
                                                value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{{ $errors->first('class_id') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Gender <span style="color: red">*</span></label>
                                    <select class="form-control" required name="gender">
                                        <option value="">Select Gender</option>
                                        <option {{ (old('gender') == 'male') ? 'selected' : '' }} value="male">Male
                                        </option>
                                        <option {{ (old('gender') == 'female') ? 'selected' : '' }} value="female">Female
                                        </option>
                                        <option {{ (old('gender') == 'other') ? 'selected' : '' }} value="other">Other
                                        </option>
                                    </select>
                                    <p class="text-danger">{{ $errors->first('gender') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Date of Birth<span style="color: red">*</span></label>
                                    <input type="date" name="date_of_birth" required
                                        class="form-control"value="{{ old('date_of_birth') }}"
                                        placeholder="Enter Date of Birth">
                                    <p class="text-danger">{{ $errors->first('date_of_birth') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Caste</label>
                                    <input type="text" name="caste" class="form-control"value="{{ old('caste') }}"
                                        placeholder="Enter Caste">
                                    <p class="text-danger">{{ $errors->first('caste') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Religion</label>
                                    <input type="text" name="religion" class="form-control"value="{{ old('religion') }}"
                                        placeholder="Enter Religion">
                                    <p class="text-danger">{{ $errors->first('religion') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile Number</label>
                                    <input type="text" name="mobile_number"
                                        class="form-control"value="{{ old('mobile_number') }}"
                                        placeholder="Enter Mobile Number">
                                    <p class="text-danger">{{ $errors->first('mobile_number') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Admission Date</label>
                                    <input type="date" name="admission_date"
                                        class="form-control"value="{{ old('admission_date') }}"
                                        placeholder="Enter Admission Date">
                                    <p class="text-danger">{{ $errors->first('admission_date') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Profile Pic</label>
                                    <input type="file"  name="profile_pic" class="form-control" accept="image/jpeg, image/png">
                                    <p class="text-danger">{{ $errors->first('profile_pic') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Blood Group</label>
                                    <input type="text" name="blood_group"
                                        class="form-control"value="{{ old('blood_group') }}"
                                        placeholder="Enter Blood Group">
                                    <p class="text-danger">{{ $errors->first('blood_group') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Height</label>
                                    <input type="text" name="height" class="form-control"value="{{ old('height') }}"
                                        placeholder="Enter Height">
                                    <p class="text-danger">{{ $errors->first('height') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Weight</label>
                                    <input type="text" name="weight" class="form-control"value="{{ old('weight') }}"
                                        placeholder="Enter Weight">
                                    <p class="text-danger">{{ $errors->first('weight') }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Status <span style="color: red">*</span></label>
                                    <select class="form-control" required name="status">
                                        <option value="">Select Status</option>
                                        <option  {{ (old('status') == 0) ? 'selected' : '' }}  value="0">Active</option>
                                        <option  {{ (old('status') == 1) ? 'selected' : '' }}  value="1">Inactive</option>
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
