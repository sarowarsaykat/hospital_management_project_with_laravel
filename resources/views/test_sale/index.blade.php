@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Test Sales</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a href="{{ route('test-sales.create') }}" class="btn btn-primary mb-3">Add Sale</a>
                                <table class="table table-bordered table-striped" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient</th>
                                            <th>Sale Date</th>
                                            <th>Total Quantity</th>
                                            <th>Total Amount</th>
                                            <th>Payment Method</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($testSales as $testSale)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $testSale->patient->first_name }} {{ $testSale->patient->last_name }}</td>
                                                <td>{{ $testSale->sale_date }}</td>
                                                <td>{{ $testSale->total_quantity }}</td>
                                                <td>{{ number_format($testSale->total_amount, 2) }}</td>
                                                <td>{{ $testSale->payment_method }}</td>
                                                <td>
                                                    <a href="{{ route('test-sales.show', $testSale->id) }}" 
                                                        class="btn btn-info btn-sm">View</a>
                                                    <a href="{{ route('test-sales.edit', $testSale->id) }}" 
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('test-sales.destroy', $testSale->id) }}" 
                                                          method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this test sale?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No test sale records found.</td>
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
