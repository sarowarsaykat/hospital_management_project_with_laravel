@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Create Test Sale</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('test-sales.store') }}" method="POST">
                                    @csrf

                                    <!-- Patient and Sale Date -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="patient_id">Patient</label>
                                            <select class="form-control" id="patient_id" name="patient_id" required>
                                                <option value="" disabled selected>Select a patient</option>
                                                @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sale_date">Sale Date</label>
                                            <input type="date" id="sale_date" name="sale_date" class="form-control"
                                                value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <!-- Test Sale Table -->
                                    <div>
                                        <h4>Test Items</h4>
                                        <button id="add-row-btn" type="button" class="btn btn-primary mb-2">Add Test</button>
                                        <table id="test-sale-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Test</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-control test-select" name="test_id[]" required>
                                                            <option value="" disabled selected>Select a test</option>
                                                            @foreach ($tests as $test)
                                                                <option value="{{ $test->id }}" data-price="{{ $test->price }}">{{ $test->test_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name="price[]" class="form-control price" readonly></td>
                                                    <td><input type="number" name="quantity[]" class="form-control quantity" min="1" value="1"></td>
                                                    <td><input type="number" name="total[]" class="form-control total" readonly></td>
                                                    <td><button type="button" class="btn btn-danger delete-row-btn">Delete</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Total Quantity and Amount -->
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label>Total Quantity</label>
                                            <input type="number" id="total_quantity" name="total_quantity"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Total Amount</label>
                                            <input type="number" id="total_amount" name="total_amount" class="form-control"
                                                readonly>
                                        </div>
                                    </div>

                                    <!-- Payment Details -->
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label>Payment Method</label>
                                            <select id="payment_method" name="payment_method" class="form-control" required>
                                                <option value="" disabled selected>Select a method</option>
                                                <option value="cash">Cash</option>
                                                <option value="bkash">Bkash</option>
                                                <option value="nagad">Nagad</option>
                                                <option value="rocket">Rocket</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Payment</label>
                                            <input type="number" id="payment" name="payment" class="form-control"
                                                required>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-content')
<script>
    $(document).ready(function() {
        // Add a new row
        $('#add-row-btn').click(function() {
            const newRow = `  
            <tr>
                <td>
                    <select class="form-control test-select" name="test_id[]" required>
                        <option value="" disabled selected>Select a test</option>
                        @foreach ($tests as $test)
                            <option value="{{ $test->id }}" data-price="{{ $test->price }}">{{ $test->test_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="price[]" class="form-control price" readonly></td>
                <td><input type="number" name="quantity[]" class="form-control quantity" min="1" value="1"></td>
                <td><input type="number" name="total[]" class="form-control total" readonly></td>
                <td><button type="button" class="btn btn-danger delete-row-btn">Delete</button></td>
            </tr>`;
            $('#test-sale-table tbody').append(newRow);
        });

        // Fetch test details via AJAX
        $(document).on('change', '.test-select', function() {
            const testId = $(this).val();
            const row = $(this).closest('tr');

            if (testId) {
                $.ajax({
                    url: `/test-details/${testId}`, // Endpoint to fetch test details
                    method: 'GET',
                    success: function(data) {
                        row.find('input[name="price[]"]').val(data.price || 0);
                        row.find('input[name="quantity[]"]').val(1);
                        row.find('input[name="total[]"]').val(data.price || 0);
                        updateTotals();
                    },
                    error: function() {
                        alert('Error fetching test details.');
                    }
                });
            }
        });

        // Update total when quantity is changed
        $(document).on('input', '.quantity', function() {
            const row = $(this).closest('tr');
            const price = parseFloat(row.find('input[name="price[]"]').val()) || 0;
            const quantity = parseInt($(this).val()) || 1;
            const total = price * quantity;
            row.find('input[name="total[]"]').val(total.toFixed(2));
            updateTotals();
        });

        // Delete a row
        $(document).on('click', '.delete-row-btn', function() {
            $(this).closest('tr').remove();
            updateTotals();
        });

        // Calculate total quantity and amount
        function updateTotals() {
            let totalQuantity = 0;
            let totalAmount = 0;

            $('#test-sale-table tbody tr').each(function() {
                const quantity = parseInt($(this).find('input[name="quantity[]"]').val()) || 0;
                const total = parseFloat($(this).find('input[name="total[]"]').val()) || 0;
                totalQuantity += quantity;
                totalAmount += total;
            });

            $('#total_quantity').val(totalQuantity);
            $('#total_amount').val(totalAmount.toFixed(2));
        }
    });
</script>
@endpush
