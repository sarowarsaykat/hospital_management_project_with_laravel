@extends('layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Manufacturer</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a href="{{ route('manufacturer.create') }}" class="btn btn-primary mb-3">Add Manufacturer</a>
                                <table class="table table-bordered"  id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Company Name</th>
                                            <th>Country</th>
                                            <th>Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($manufacturers as $manufacturer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $manufacturer->company_name }}</td>
                                                <td>{{ $manufacturer->country }}</td>
                                                <td>{{ $manufacturer->is_active ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <a href="{{ route('manufacturer.edit', $manufacturer->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('manufacturer.destroy', $manufacturer->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No manufacturers found.</td>
                                            </tr>
                                        @endforelse
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
