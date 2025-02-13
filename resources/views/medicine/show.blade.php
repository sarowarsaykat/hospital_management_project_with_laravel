@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Medicine Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name:</strong> {{ $medicine->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Category:</strong> {{ $medicine->category->name ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Sub Category:</strong> {{ $medicine->subcategory->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Manufacturer:</strong>
                                            {{ $medicine->manufacturer->company_name ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Unit:</strong> {{ $medicine->unit->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Purchase Price:</strong>
                                            {{ number_format($medicine->purchase_price, 2) }} tk</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Sale Price:</strong> {{ number_format($medicine->sale_price, 2) }} tk</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Stock:</strong> {{ $medicine->stock ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Active Status:</strong>
                                        <span class="badge {{ $medicine->is_active ? 'badge-success' : 'badge-danger' }}">
                                            {{ $medicine->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Medicine Image:</strong></p>
                                    @if ($medicine->image)
                                        <img src="{{ asset('uploads/medicines/' . $medicine->image) }}"
                                            alt="medicine Image" width="60px" height="60px">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </div>

                                <a href="{{ route('medicines.index') }}" class="btn btn-secondary">Back</a>
                                <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
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
