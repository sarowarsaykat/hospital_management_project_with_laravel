@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Edit Purchase</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('sales.update', $salesMaster->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Customer and Sale Date -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="customer_id" class="form-label">Customer</label>
                                            <select class="form-control" id="customer_id" name="customer_id" required>
                                                <option value="" disabled>Select a customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ $salesMaster->customer_id == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="sale_date" class="form-label">Sale Date</label>
                                            <input type="date" id="sale_date" name="sale_date" class="form-control"
                                                value="{{ $salesMaster->sale_date }}" required>
                                        </div>
                                    </div>

                                    <!-- Sales Table -->
                                    <div>
                                        <h4 class="mt-3">Sale Items</h4>
                                        <button id="add-row-btn" type="button" class="btn btn-primary mb-3">Add
                                            medicine</button>
                                        <table id="sales-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>medicine</th>
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
                                                @foreach ($salesDetails as $detail)
                                                    <tr>
                                                        <td>
                                                            <select class="form-control medicine-select"
                                                                name="medicine_id[]" required>
                                                                <option value="" disabled>Select a medicine
                                                                </option>
                                                                @foreach ($medicines as $medicine)
                                                                    <option value="{{ $medicine->id }}"
                                                                        {{ $detail->medicine_id == $medicine->id ? 'selected' : '' }}>
                                                                        {{ $medicine->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="unit[]" class="form-control"
                                                                value="{{ $detail->unit }}" readonly></td>
                                                        <td><input type="number" name="purchase_price[]"
                                                                class="form-control" value="{{ $detail->purchase_price }}"
                                                                readonly></td>
                                                        <td><input type="number" name="sale_price[]" class="form-control"
                                                                value="{{ $detail->sale_price }}" readonly></td>
                                                        <td><input type="number" name="quantity[]" class="form-control"
                                                                value="{{ $detail->quantity }}"></td>
                                                        <td><input type="number" name="stock[]" class="form-control"
                                                                value="{{ $detail->stock }}" readonly></td>
                                                        <td><input type="number" name="total[]" class="form-control"
                                                                value="{{ $detail->total }}" readonly></td>
                                                        <td><button type="button"
                                                                class="btn btn-danger delete-row-btn">Delete</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Total Quantity and Amount -->
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="total_quantity" class="form-label">Total Quantity</label>
                                            <input type="number" id="total_quantity" name="total_quantity"
                                                class="form-control" value="{{ $salesMaster->total_quantity }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="total_amount" class="form-label">Total Amount</label>
                                            <input type="number" id="total_amount" name="total_amount" class="form-control"
                                                value="{{ $salesMaster->total_amount }}" readonly>
                                        </div>
                                    </div>

                                    <!-- Payment Details -->
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <select id="payment_method" name="payment_method" class="form-control" required>
                                                <option value="" disabled>Select a method</option>
                                                <option value="Bkash"
                                                    {{ $salesMaster->payment_method == 'Bkash' ? 'selected' : '' }}>
                                                    Bkash</option>
                                                <option value="Nagad"
                                                    {{ $salesMaster->payment_method == 'Nagad' ? 'selected' : '' }}>
                                                    Nagad</option>
                                                <option value="Rocket"
                                                    {{ $salesMaster->payment_method == 'Rocket' ? 'selected' : '' }}>
                                                    Rocket</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="payment" class="form-label">Payment</label>
                                            <input type="number" id="payment" name="payment" class="form-control"
                                                value="{{ $salesMaster->payment }}" required>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
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
                <select class="form-select medicine-select" name="medicine_id[]" required>
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
                            $row.find('input[name="unit[]"]').val(data
                                .unit_name); // Update unit field
                            $row.find('input[name="purchase_price[]"]').val(data
                                .purchase_price);
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
                calculateTotals();
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

            // Recalculate totals when a row is dynamically added
            $(document).on('input', '.medicine-select', calculateTotals);
        });
    </script>
@endpush
