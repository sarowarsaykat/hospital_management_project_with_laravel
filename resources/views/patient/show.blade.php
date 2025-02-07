@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Patient Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>First Name:</strong> {{ $patient->first_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Last Name:</strong> {{ $patient->last_name }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Email:</strong> {{ $patient->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Phone:</strong> {{ $patient->phone }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Address:</strong> {{ $patient->address ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Date of Birth:</strong> {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d M, Y') : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Blood Type:</strong> {{ $patient->blood_type }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Emergency Contact:</strong> {{ $patient->emergency_contact }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Medical History:</strong></p>
                                    <p>{{ $patient->medical_history ?? 'N/A' }}</p>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Status:</strong> 
                                        <span class="badge {{ $patient->is_active == 'active' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($patient->is_active) }}
                                        </span>
                                    </p>
                                </div>

                                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back</a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
