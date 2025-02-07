@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Nurses List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a href="{{ route('nurses.create') }}" class="btn btn-primary mb-2">Add Nurse</a>
                                <table class="table table-bordered table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Department</th>
                                            <th>Availability</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($nurses as $index => $nurse)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $nurse->first_name . ' ' . $nurse->last_name }}</td>
                                                <td>{{ $nurse->email }}</td>
                                                <td>{{ $nurse->phone }}</td>
                                                <td>{{ $nurse->department }}</td>
                                                <td>
                                                    <span class="badge {{ $nurse->availability_status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                                        {{ ucfirst($nurse->availability_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('nurses.show', $nurse->id) }}" class="btn btn-info btn-sm"> <i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('nurses.edit', $nurse->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('nurses.destroy', $nurse->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this nurse?');">
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
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
