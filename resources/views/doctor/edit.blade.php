@extends('layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Edit Doctor</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $doctor->first_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $doctor->last_name }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" value="{{ $doctor->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control" value="{{ $doctor->phone }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="specialization" class="form-label">Specialization</label>
                                                <input type="text" name="specialization" id="specialization" class="form-control" value="{{ $doctor->specialization }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="license_number" class="form-label">License Number</label>
                                                <input type="text" name="license_number" id="license_number" class="form-control" value="{{ $doctor->license_number }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" name="address" id="address" class="form-control" value="{{ $doctor->address }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select name="gender" id="gender" class="form-control" required>
                                                    <option value="Male" {{ $doctor->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ $doctor->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                    <option value="Other" {{ $doctor->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label">Date of Birth</label>
                                                <input type="date" name="dob" id="dob" class="form-control" value="{{ $doctor->dob }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="consultation_fee" class="form-label">Consultation Fee</label>
                                                <input type="number" name="consultation_fee" id="consultation_fee" class="form-control" step="0.01" value="{{ $doctor->consultation_fee }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="experience" class="form-label">Experience</label>
                                        <textarea name="experience" id="experience" class="form-control" required>{{ $doctor->experience }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="availability_status" class="form-label">Availability Status</label>
                                        <select name="availability_status" id="availability_status" class="form-control">
                                            <option value="active" {{ $doctor->availability_status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $doctor->availability_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{route('doctors.index')}}"  class="btn btn-secondary">Cancel</a>
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
