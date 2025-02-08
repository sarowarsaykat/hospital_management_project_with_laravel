@extends('layout.master')
@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Edit Manufacturer</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('manufacturer.update', $manufacturer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Company Name</label>
                                        <input type="text" name="company_name" id="company_name"
                                            class="form-control"
                                            value="{{ old('company_name', $manufacturer->company_name) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" name="country" id="country" class="form-control"
                                            value="{{ old('country', $manufacturer->country) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="is_active" class="form-label">Active</label>
                                        <select name="is_active" id="is_active" class="form-control">
                                            <option value="1"
                                                {{ old('is_active', $manufacturer->is_active) == '1' ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="0"
                                                {{ old('is_active', $manufacturer->is_active) == '0' ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                        @error('is_active')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('manufacturer.index') }}" class="btn btn-secondary">Cancel</a>
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
