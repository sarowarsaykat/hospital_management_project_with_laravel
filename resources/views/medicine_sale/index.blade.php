@extends('layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Medicine Sales</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Add
                                    Sale</a>
                                <table class="table table-bordered table-striped" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>Sale Date</th>
                                            <th>Total Quantity</th>
                                            <th>Total Amount</th>
                                            <th>Payment Method</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sales as $sale)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sale->customer->name }}</td>
                                                <td>{{ $sale->sale_date }}</td>
                                                <td>{{ $sale->total_quantity }}</td>
                                                <td>{{ number_format($sale->total_amount, 2) }}</td>
                                                <td>{{ $sale->payment_method }}</td>
                                                <td>
                                                    <a href="{{ route('sales.show', $sale->id) }}"
                                                        class="btn btn-info btn-sm">View</a>
                                                    <a href="{{ route('sales.edit', $sale->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                                        style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this sale?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No sales records found.</td>
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
