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

                                    <div>
                                        <h4>Sale Items</h4>
                                        <button id="add-row-btn" type="button" class="btn btn-primary mb-2">Add Medicine</button>
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
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label>Total Quantity</label>
                                            <input type="number" id="total_quantity" name="total_quantity" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Total Amount</label>
                                            <input type="number" id="total_amount" name="total_amount" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label>Payment Method</label>
                                            <select id="payment_method" name="payment_method" class="form-control" required>
                                                <option value="" disabled selected>Select a method</option>
                                                <option value="Bkash">Bkash</option>
                                                <option value="Nagad">Nagad</option>
                                                <option value="Rocket">Rocket</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Payment</label>
                                            <input type="number" id="payment" name="payment" class="form-control" required>
                                        </div>
                                    </div>

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
            $('#add-row-btn').click(function() {
                let newRow = `<tr>
                    <td>
                        <select class="form-control medicine-select" name="medicine_id[]" required>
                            <option value="" disabled selected>Select a medicine</option>
                            @foreach ($medicines as $medicine)
                                <option value="{{ $medicine->id }}" 
                                    data-unit="{{ $medicine->unit->name }}" 
                                    data-purchase-price="{{ $medicine->purchase_price }}" 
                                    data-sale-price="{{ $medicine->sale_price }}" 
                                    data-stock="{{ $medicine->stock }}">
                                    {{ $medicine->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="unit[]" class="form-control unit-name" readonly></td>
                    <td><input type="number" name="purchase_price[]" class="form-control purchase-price" readonly></td>
                    <td><input type="number" name="sale_price[]" class="form-control sale-price" readonly></td>
                    <td><input type="number" name="quantity[]" class="form-control quantity"></td>
                    <td><input type="number" name="stock[]" class="form-control stock" readonly></td>
                    <td><input type="number" name="total[]" class="form-control total" readonly></td>
                    <td><button type="button" class="btn btn-danger delete-row-btn">Delete</button></td>
                </tr>`;
                $('#sales-table tbody').append(newRow);
            });

            $(document).on('change', '.medicine-select', function() {
                let selected = $(this).find(':selected');
                let row = $(this).closest('tr');
                row.find('.unit-name').val(selected.data('unit'));
                row.find('.purchase-price').val(selected.data('purchase-price'));
                row.find('.sale-price').val(selected.data('sale-price'));
                row.find('.stock').val(selected.data('stock'));
                row.find('.quantity').val(1);
                row.find('.total').val(selected.data('sale-price'));
                calculateTotals();
            });

            $(document).on('input', '.quantity', function() {
                let row = $(this).closest('tr');
                let quantity = parseFloat(row.find('.quantity').val()) || 0;
                let price = parseFloat(row.find('.sale-price').val()) || 0;
                row.find('.total').val((quantity * price).toFixed(2));
                calculateTotals();
            });

            $(document).on('click', '.delete-row-btn', function() {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            function calculateTotals() {
                let totalQuantity = 0,
                    totalAmount = 0;

                $('#sales-table tbody tr').each(function() {
                    totalQuantity += parseFloat($(this).find('.quantity').val()) || 0;
                    totalAmount += parseFloat($(this).find('.total').val()) || 0;
                });

                $('#total_quantity').val(totalQuantity);
                $('#total_amount').val(totalAmount.toFixed(2));
            }
        });
    </script>
@endpush
