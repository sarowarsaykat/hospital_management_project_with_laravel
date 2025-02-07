@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Edit Nurse</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('nurses.update', $nurse->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control"
                                                    value="{{ $nurse->first_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" name="last_name" id="last_name" class="form-control"
                                                    value="{{ $nurse->last_name }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    value="{{ $nurse->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control"
                                                    value="{{ $nurse->phone }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            value="{{ $nurse->address }}" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select name="gender" id="gender" class="form-control" required>
                                                    <option value="Male" {{ $nurse->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ $nurse->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                    <option value="Other" {{ $nurse->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                <input type="date" name="dob" id="dob" class="form-control"
                                                    value="{{ $nurse->dob }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="qualification" class="form-label">Qualification</label>
                                                <input type="text" name="qualification" id="qualification"
                                                    class="form-control" value="{{ $nurse->qualification }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nursing_license_number" class="form-label">Nursing License Number</label>
                                                <input type="text" name="nursing_license_number"
                                                    id="nursing_license_number" class="form-control"
                                                    value="{{ $nurse->nursing_license_number }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="department" class="form-label">Department</label>
                                                <input type="text" name="department" id="department" class="form-control"
                                                    value="{{ $nurse->department }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="salary" class="form-label">Salary</label>
                                                <input type="number" name="salary" id="salary" class="form-control"
                                                    step="0.01" value="{{ $nurse->salary }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="experience" class="form-label">Experience</label>
                                        <textarea name="experience" id="experience" class="form-control" required>{{ $nurse->experience }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="availability_status" class="form-label">Availability Status</label>
                                        <select name="availability_status" id="availability_status" class="form-control">
                                            <option value="active" {{ $nurse->availability_status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $nurse->availability_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ route('nurses.index') }}" class="btn btn-secondary">Cancel</a>
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
