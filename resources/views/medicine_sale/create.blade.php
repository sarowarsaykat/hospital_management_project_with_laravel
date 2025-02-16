@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Create Sale</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('sales.store') }}" method="POST">
                                    @csrf

                                    <!-- Customer and Sale Date -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="customer_id">Customer</label>
                                            <select class="form-control" id="customer_id" name="customer_id" required>
                                                <option value="" disabled selected>Select a customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sale_date">Sale Date</label>
                                            <input type="date" id="sale_date" name="sale_date" class="form-control"
                                                value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <!-- Sales Table -->
                                    <div>
                                        <h4>Sale Items</h4>
                                        <button id="add-row-btn" type="button" class="btn btn-primary mb-2">Add
                                            Medicine</button>
                                        <table id="sales-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Medicine</th>
                                                    <th>Unit</th>
                                                    <th>Purchase Price</th>
                                                    <th>Sale Price</th>
                                                    <th>Quantity</th>
                                                    <th>Stock</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-control medicine-select" name="medicine_id[]"
                                                            required>
                                                            <option value="" disabled selected>Select a medicine
                                                            </option>
                                                            @foreach ($medicines as $medicine)
                                                                <option value="{{ $medicine->id }}">{{ $medicine->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="unit[]" class="form-control" readonly>
                                                    </td>
                                                    <td><input type="number" name="purchase_price[]" class="form-control"
                                                            readonly></td>
                                                    <td><input type="number" name="sale_price[]" class="form-control"
                                                            readonly></td>
                                                    <td><input type="number" name="quantity[]" class="form-control"></td>
                                                    <td><input type="number" name="stock[]" class="form-control" readonly>
                                                    </td>
                                                    <td><input type="number" name="total[]" class="form-control" readonly>
                                                    </td>
                                                    <td><button type="button"
                                                            class="btn btn-danger delete-row-btn">Delete</button></td>
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
                    <select class="form-control medicine-select" name="medicine_id[]" required>
                        <option value="" disabled selected>Select a medicine</option>
                        @foreach ($medicines as $medicine)
                            <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="unit[]" class="form-control" readonly></td>
                <td><input type="number" name="purchase_price[]" class="form-control" readonly></td>
                <td><input type="number" name="sale_price[]" class="form-control" readonly></td>
                <td><input type="number" name="quantity[]" class="form-control"></td>
                <td><input type="number" name="stock[]" class="form-control" readonly></td>
                <td><input type="number" name="total[]" class="form-control" readonly></td>
                <td><button type="button" class="btn btn-danger delete-row-btn">Delete</button></td>
            </tr>`;
            $('#sales-table tbody').append(newRow);
        });

        // Fetch medicine details via AJAX
        $(document).on('change', '.medicine-select', function() {
            const medicineId = $(this).val();
            const $row = $(this).closest('tr');

            if (medicineId) {
                $.ajax({
                    url: `/medicine-details/${medicineId}`, // Endpoint to fetch medicine details
                    method: 'GET',
                    success: function(data) {
                        $row.find('input[name="unit[]"]').val(data.unit_name || 'N/A'); 
                        $row.find('input[name="purchase_price[]"]').val(data.purchase_price);
                        $row.find('input[name="sale_price[]"]').val(data.sale_price);
                        $row.find('input[name="stock[]"]').val(data.stock);
                    },
                    error: function() {
                        alert('Error fetching medicine details.');
                    }
                });
            }
        });

        // Delete a row
        $(document).on('click', '.delete-row-btn', function() {
            $(this).closest('tr').remove();
            calculateTotals(); // Recalculate totals when row is deleted
        });

        // Calculate totals
        function calculateTotals() {
            let totalQuantity = 0;
            let totalAmount = 0;

            $('#sales-table tbody tr').each(function() {
                const quantity = parseFloat($(this).find('input[name="quantity[]"]').val()) || 0;
                const salePrice = parseFloat($(this).find('input[name="sale_price[]"]').val()) || 0;
                const total = quantity * salePrice;

                $(this).find('input[name="total[]"]').val(total.toFixed(2));
                totalQuantity += quantity;
                totalAmount += total;
            });

            $('#total_quantity').val(totalQuantity);
            $('#total_amount').val(totalAmount.toFixed(2));
        }

        // Update totals on quantity change
        $(document).on('input', 'input[name="quantity[]"]', calculateTotals);
    });
</script>
@endpush

