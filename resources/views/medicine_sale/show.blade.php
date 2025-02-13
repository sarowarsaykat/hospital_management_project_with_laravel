@extends('layout.master')

@section('content')
    <style>
        @media print {
            .hide-print {
                display: none;
            }
        }
    </style>

    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Purchase List</h3>
                        </div>

                        <div class="card-body">
                            <!-- Invoice Header -->
                            <div class="card-header text-center">
                                <h3 class="mb-0">Purchase Invoice</h3>
                                <p class="mb-0"><strong>Invoice ID:</strong> {{ $purchase->id }}</p>
                                <p><strong>Date:</strong> {{ $purchase->purchase_date }}</p>
                            </div>

                            <!-- Supplier Information -->
                            <div class="mb-4">
                                <h5 class="mb-3">Supplier Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name:</strong> {{ $purchase->supplier->name ?? 'N/A' }}</p>
                                        <p><strong>Email:</strong> {{ $purchase->supplier->email ?? 'N/A' }}</p>
                                        <p><strong>Phone:</strong> {{ $purchase->supplier->phone ?? 'N/A' }}</p>
                                        <p><strong>Address:</strong> {{ $purchase->supplier->address ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Items Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Medicine</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Purchase Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->details as $index => $detail)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $detail->medicine->name ?? 'N/A' }}</td>
                                                <td>{{ $detail->unit->name ?? 'N/A' }}</td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>{{ number_format($detail->purchase_price, 2) }}</td>
                                                <td>{{ number_format($detail->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4"></th>
                                            <th>Total Quantity</th>
                                            <th>{{ $purchase->total_quantity }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4"></th>
                                            <th>Total Amount</th>
                                            <th>{{ number_format($purchase->total_amount, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Footer Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('purchases.index') }}" class="btn btn-secondary hide-print">Back</a>
                                <button onclick="window.print()" class="btn btn-primary hide-print">Print Invoice</button>
                            </div>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div> <!-- /.col-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.card-body -->
    </div> <!-- /.content-wrapper -->
@endsection
