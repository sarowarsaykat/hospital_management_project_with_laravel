@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Doctor Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>First Name:</strong> {{ $doctor->first_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Last Name:</strong> {{ $doctor->last_name }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Email:</strong> {{ $doctor->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Phone:</strong> {{ $doctor->phone }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>License Number:</strong> {{ $doctor->license_number }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Address:</strong> {{ $doctor->address ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Gender:</strong> {{ $doctor->gender }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Date of Birth:</strong> {{ $doctor->dob ? \Carbon\Carbon::parse($doctor->dob)->format('d M, Y') : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Consultation Fee:</strong> ${{ number_format($doctor->consultation_fee, 2) }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Experience:</strong></p>
                                    <p>{{ $doctor->experience }}</p>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Availability Status:</strong> 
                                        <span class="badge {{ $doctor->availability_status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($doctor->availability_status) }}
                                        </span>
                                    </p>
                                </div>

                                <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Back</a>
                                <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
