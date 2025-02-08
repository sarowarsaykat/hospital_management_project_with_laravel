@extends('layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Doctor List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a href="{{ route('doctors.create') }}" class="btn btn-primary mb-2">+ Add Doctor</a>
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Specialization</th>
                                            <th>Consultation Fee</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($doctors as $index => $doctor)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $doctor->first_name . ' ' . $doctor->last_name }}</td>
                                                <td>{{ $doctor->email }}</td>
                                                <td>{{ $doctor->specialization }}</td>
                                                <td>৳{{ number_format($doctor->consultation_fee, 2) }}</td>
                                                <td>
                                                    <span class="badge {{ $doctor->availability_status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                                        {{ ucfirst($doctor->availability_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this doctor?');"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
