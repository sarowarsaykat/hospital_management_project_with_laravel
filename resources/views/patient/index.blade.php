@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Patients List</h3>
                        </div>

                        <div class="card-body table-responsive">
                            <a href="{{ route('patients.create') }}" class="btn btn-primary mb-2">Add New Patient</a>
                            <table class="table table-bordered table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patients as $patient)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $patient->first_name . ' ' . $patient->last_name }}</td>
                                            <td>{{ $patient->email }}</td>
                                            <td>{{ $patient->phone }}</td>
                                            <td>
                                                <span class="badge {{ $patient->is_active == 'active' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ ucfirst($patient->is_active) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> 
                                                </a>

                                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?')">
                                                        <i class="fas fa-trash"></i> 
                                                    </button>
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
@endsection
