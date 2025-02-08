@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Create SubCategory</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <form action="{{ route('sub-categories.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">SubCategory Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter sub category name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select class="form-control" id="category_id" name="category_id" required>
                                            <option value="" disabled selected>Select a category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_active">Active</label>
                                        <select class="form-control" id="is_active" name="is_active">
                                            <option value="1" {{ old('is_active', 1) ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="0" {{ old('is_active', 1) ? '' : 'selected' }}>No
                                            </option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
