@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Nurse Create</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('nurses.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control"
                                                    placeholder="Enter First Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" name="last_name" id="last_name" class="form-control"
                                                    placeholder="Enter Last Name" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    placeholder="Enter Email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control"
                                                    placeholder="Enter Phone Number" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            placeholder="Enter Address" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select name="gender" id="gender" class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                <input type="date" name="dob" id="dob" class="form-control"
                                                    placeholder="Select Date of Birth" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="qualification" class="form-label">Qualification</label>
                                                <input type="text" name="qualification" id="qualification"
                                                    class="form-control" placeholder="Enter Qualification" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nursing_license_number" class="form-label">Nursing License
                                                    Number</label>
                                                <input type="text" name="nursing_license_number"
                                                    id="nursing_license_number" class="form-control"
                                                    placeholder="Enter License Number" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="department" class="form-label">Department</label>
                                                <input type="text" name="department" id="department" class="form-control"
                                                    placeholder="Enter Department" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="salary" class="form-label">Salary</label>
                                                <input type="number" name="salary" id="salary" class="form-control"
                                                    step="0.01" placeholder="Enter Salary" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="experience" class="form-label">Experience</label>
                                        <textarea name="experience" id="experience" class="form-control" placeholder="Enter Experience" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="availability_status" class="form-label">Availability Status</label>
                                        <select name="availability_status" id="availability_status" class="form-control">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success">Submit</button>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
