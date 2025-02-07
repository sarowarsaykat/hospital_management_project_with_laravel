@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Edit Pathological Test</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('pathological-tests.update', $pathologicalTest->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="test_name" class="form-label">Test Name</label>
                                                <input type="text" name="test_name" id="test_name" class="form-control" value="{{ $pathologicalTest->test_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="test_code" class="form-label">Test Code</label>
                                                <input type="text" name="test_code" id="test_code" class="form-control" value="{{ $pathologicalTest->test_code }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control">{{ $pathologicalTest->description }}</textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ $pathologicalTest->price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="active" {{ $pathologicalTest->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ $pathologicalTest->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ route('pathological-tests.index') }}" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
