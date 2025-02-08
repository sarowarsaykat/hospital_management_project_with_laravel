@extends('layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Suppliers</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">Add supplier</a>
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $supplier->name }}</td>
                                                <td>{{ $supplier->email }}</td>
                                                <td>{{ $supplier->phone }}</td>
                                                <td>{{ $supplier->address }}</td>
                                                <td>{{ $supplier->is_active ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
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
