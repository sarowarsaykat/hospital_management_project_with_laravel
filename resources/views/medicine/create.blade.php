@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Add Medicine</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Enter product name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category_id">Category</label>
                                                <select class="form-control" id="category_id" name="category_id" required>
                                                    <option value="" disabled selected>Select a category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subcategory_id">Sub Category</label>
                                                <select class="form-control" id="subcategory_id" name="subcategory_id" required>
                                                    <option value="" disabled selected>Select a subcategory</option>
                                                    @foreach ($subcategorys as $subcategory)
                                                        <option value="{{ $subcategory->id }}">
                                                            {{ $subcategory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="manufacturer_id">Manufacturer</label>
                                                <select class="form-control" id="manufacturer_id" name="manufacturer_id" required>
                                                    <option value="" disabled selected>Select a manufacturer</option>
                                                    @foreach ($manufacturers as $manufacturer)
                                                        <option value="{{ $manufacturer->id }}">
                                                            {{ $manufacturer->company_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="unit_id">Units</label>
                                                <select class="form-control" id="unit_id" name="unit_id" required>
                                                    <option value="" disabled selected>Select a unit</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}">
                                                            {{ $unit->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="purchase_price" class="form-label">Purchase Price</label>
                                                <input type="number" class="form-control" id="purchase_price" name="purchase_price"
                                                    step="0.01" placeholder="Enter product purchase price" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sale_price" class="form-label">Sale Price</label>
                                                <input type="number" class="form-control" id="sale_price" name="sale_price"
                                                    step="0.01" placeholder="Enter product sale price" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image" class="form-label">Product Image</label>
                                                <input type="file" class="form-control" name="image" id="image" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="is_active">Active</label>
                                                <select class="form-control" id="is_active" name="is_active">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
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