@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Add Manufacturer</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('manufacturer.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Company Name</label>
                                        <input type="text" name="company_name" id="company_name"
                                            class="form-control" value="{{ old('company_name') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" name="country" id="country" class="form-control"
                                            value="{{ old('country') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="is_active" class="form-label">Active</label>
                                        <select name="is_active" id="is_active" class="form-control">
                                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
