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
                            <h3 class="card-title">Test Sale Invoice</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-header text-center">
                                <h3 class="mb-0">Test Sale Invoice</h3>
                                <p class="mb-0"><strong>Invoice ID:</strong> {{ $testSaleMaster->id }}</p>
                                <p><strong>Date:</strong> {{ $testSaleMaster->sale_date }}</p>
                            </div>
                            <div class="card-body">

                                <!-- Patient Information -->
                                <div class="mb-4">
                                    <h5 class="mb-3">Patient Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Name:</strong> {{ $testSaleMaster->patient->first_name }} {{ $testSaleMaster->patient->last_name }}</p>
                                            <p><strong>Email:</strong> {{ $testSaleMaster->patient->email ?? 'N/A' }}</p>
                                            <p><strong>Phone:</strong> {{ $testSaleMaster->patient->phone ?? 'N/A' }}</p>
                                            <p><strong>Address:</strong> {{ $testSaleMaster->patient->address ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Test Sale Details Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Test</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($testSaleMaster->testSalesDetails as $index => $detail)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $detail->pathologicalTest->test_name }}</td> 
                                                    <td>{{ number_format($detail->price, 2) }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>{{ number_format($detail->total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3"></th>
                                                <th>Total Quantity</th>
                                                <th>{{ $testSaleMaster->total_quantity }}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="3"></th>
                                                <th>Total Amount</th>
                                                <th>{{ number_format($testSaleMaster->total_amount, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Footer Buttons -->
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('test-sales.index') }}" class="btn btn-secondary hide-print">Back</a>
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
