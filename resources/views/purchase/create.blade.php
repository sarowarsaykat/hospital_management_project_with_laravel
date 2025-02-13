@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Create Purchase</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('purchases.store') }}" method="POST">
                                    @csrf

                                    <!-- Supplier and Purchase Date -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="supplier_id">Supplier</label>
                                            <select class="form-control" id="supplier_id" name="supplier_id" required>
                                                <option value="" disabled selected>Select a supplier</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="purchase_date">Purchase Date</label>
                                            <input type="date" id="purchase_date" name="purchase_date"
                                                class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <!-- Purchase Items Table -->
                                    <div>
                                        <h4>Purchase Items</h4>
                                        <button id="add-row-btn" type="button" class="btn btn-primary mb-2">Add
                                            Medicine</button>
                                        <table id="purchases-table" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Medicine</th>
                                                    <th>Unit</th>
                                                    <th>Purchase Price</th>
                                                    <th>Quantity</th>
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
                                                                <option value="{{ $medicine->id }}"
                                                                    data-unit-id="{{ $medicine->unit->id }}"
                                                                    data-unit="{{ $medicine->unit->name }}"
                                                                    data-price="{{ $medicine->purchase_price }}">
                                                                    {{ $medicine->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control unit-name"
                                                            name="unit_name[]" readonly>
                                                        <input type="hidden" class="unit-id" name="unit_id[]">
                                                    </td>
                                                    <td><input type="number" name="purchase_price[]"
                                                            class="form-control purchase-price" readonly></td>
                                                    <td><input type="number" name="quantity[]"
                                                            class="form-control quantity"></td>
                                                    <td><input type="number" name="total[]" class="form-control total"
                                                            readonly></td>
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
                let newRow = `<tr>
                    <td>
                        <select class="form-control medicine-select" name="medicine_id[]" required>
                            <option value="" disabled selected>Select a medicine</option>
                            @foreach ($medicines as $medicine)
                                <option value="{{ $medicine->id }}" data-unit-id="{{ $medicine->unit->id }}" data-unit="{{ $medicine->unit->name }}" data-price="{{ $medicine->purchase_price }}">
                                    {{ $medicine->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control unit-name" name="unit_name[]" readonly>
                        <input type="hidden" class="unit-id" name="unit_id[]">
                    </td>
                    <td><input type="number" name="purchase_price[]" class="form-control purchase-price" readonly></td>
                    <td><input type="number" name="quantity[]" class="form-control quantity"></td>
                    <td><input type="number" name="total[]" class="form-control total" readonly></td>
                    <td><button type="button" class="btn btn-danger delete-row-btn">Delete</button></td>
                </tr>`;
                $('#purchases-table tbody').append(newRow);
            });

            // Auto-fill unit and price
            $(document).on('change', '.medicine-select', function() {
                let selected = $(this).find(':selected');
                let row = $(this).closest('tr');
                row.find('.unit-name').val(selected.data('unit')); // Show unit name
                row.find('.purchase-price').val(selected.data('price'));
                row.find('.unit-id').val(selected.data('unit-id')); // Set unit ID
                row.find('.quantity').val(1); // Optional: Reset quantity to 1 on selection
                row.find('.total').val(selected.data('price')); // Update total as well
                calculateTotals();
            });

            // Calculate total price
            $(document).on('input', '.quantity', function() {
                let row = $(this).closest('tr');
                let quantity = parseFloat(row.find('.quantity').val()) || 0;
                let price = parseFloat(row.find('.purchase-price').val()) || 0;
                row.find('.total').val((quantity * price).toFixed(2));

                calculateTotals();
            });

            // Delete row
            $(document).on('click', '.delete-row-btn', function() {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            function calculateTotals() {
                let totalQuantity = 0,
                    totalAmount = 0;

                $('#purchases-table tbody tr').each(function() {
                    totalQuantity += parseFloat($(this).find('.quantity').val()) || 0;
                    totalAmount += parseFloat($(this).find('.total').val()) || 0;
                });

                $('#total_quantity').val(totalQuantity);
                $('#total_amount').val(totalAmount.toFixed(2));
            }
        });
    </script>
@endpush
