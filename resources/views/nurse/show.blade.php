@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Nurse Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>First Name:</strong> {{ $nurse->first_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Last Name:</strong> {{ $nurse->last_name }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Email:</strong> {{ $nurse->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Phone:</strong> {{ $nurse->phone }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Qualification:</strong> {{ $nurse->qualification }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Nursing License Number:</strong> {{ $nurse->nursing_license_number }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Department:</strong> {{ $nurse->department }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Salary:</strong> {{ number_format($nurse->salary, 2) }} Tk</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Address:</strong> {{ $nurse->address ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Gender:</strong> {{ $nurse->gender }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Date of Birth:</strong> {{ $nurse->dob ? \Carbon\Carbon::parse($nurse->dob)->format('d M, Y') : 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Experience:</strong></p>
                                    <p>{{ $nurse->experience }}</p>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Availability Status:</strong> 
                                        <span class="badge {{ $nurse->availability_status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($nurse->availability_status) }}
                                        </span>
                                    </p>
                                </div>

                                <a href="{{ route('nurses.index') }}" class="btn btn-secondary btn-sm">Back</a>
                                <a href="{{ route('nurses.edit', $nurse->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('nurses.destroy', $nurse->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
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
