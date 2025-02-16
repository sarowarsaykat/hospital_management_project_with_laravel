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
        <!-- form start-->
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Sales Invoice</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-header text-center">
                                <h3 class="mb-0">Sales Invoice</h3>
                                <p class="mb-0"><strong>Invoice ID:</strong> {{ $sale->id }}</p>
                                <p><strong>Date:</strong> {{ $sale->sale_date }}</p>
                            </div>
                            <div class="card-body">

                                <!-- Customer Information -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Customer Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Name:</strong> {{ $sale->customer->name }}</p>
                                            <p><strong>Email:</strong> {{ $sale->customer->email ?? 'N/A' }}</p>
                                            <p><strong>Phone:</strong> {{ $sale->customer->phone ?? 'N/A' }}</p>
                                            <p><strong>Address:</strong> {{ $sale->customer->address ?? 'N/A' }}</p>
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
                                                <th>Sale Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sale->salesDetails as $index => $detail)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $detail->medicine->name }}</td>
                                                    <td>{{ $detail->unit }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>{{ number_format($detail->sale_price, 2) }}</td>
                                                    <td>{{ number_format($detail->total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4"></th>
                                                <th>Total Quantity</th>
                                                <th>{{ $sale->total_quantity }}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="4"></th>
                                                <th>Total Amount</th>
                                                <th>{{ number_format($sale->total_amount, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Footer Buttons -->
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('sales.index') }}" class="btn btn-secondary hide-print">Back</a>
                                    <button onclick="window.print()" class="btn btn-primary hide-print">Print
                                        Invoice</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- form end-->
    </div>
@endsection
