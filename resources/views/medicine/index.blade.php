@extends('layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Medicine</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a href="{{ route('medicines.create') }}" class="btn btn-primary mb-3">Add
                                    Medicine</a>
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            {{-- <th>Subcategory</th>
                                            <th>Manufacturer</th>
                                            <th>Unit</th> --}}
                                            {{-- <th>Purchase Price</th>
                                            <th>Sale Price</th> --}}
                                            <th>Stock</th>
                                            <th>Image</th>
                                            <th>Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($medicines as $medicine)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $medicine->name }}</td>
                                                <td>{{ $medicine->category->name }}</td>
                                                {{-- <td>{{ optional($medicine->subcat)->name }}</td>
                                                <td>{{ $medicine->manufacturer->company_name }}</td>
                                                <td>{{ $medicine->unit->name }}</td> --}}
                                                {{-- <td>{{ $medicine->purchase_price }}</td>
                                                <td>{{ $medicine->sale_price }}</td> --}}
                                                <td>{{ $medicine->stock }}</td>
                                                <td>
                                                    @if ($medicine->image)
                                                        <img src="{{ asset('uploads/medicines/' . $medicine->image) }}"
                                                            alt="medicine Image" width="60px" height="60px">
                                                    @else
                                                        <span>No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $medicine->is_active ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <a href="{{ route('medicines.show', $medicine->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('medicines.edit', $medicine->id) }}"
                                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('medicines.destroy', $medicine->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="fas fa-trash"></i></button>
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
