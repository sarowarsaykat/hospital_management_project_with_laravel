@extends('layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Edit Supplier</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                            
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $supplier->email) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $supplier->address) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_active">Active</label>
                                        <select class="form-control" id="is_active" name="is_active">
                                            <option value="1" {{ old('is_active', $supplier->is_active) == 1 ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ old('is_active', $supplier->is_active) == 0 ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                            
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
