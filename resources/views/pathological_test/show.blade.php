@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Pathological Test Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Test Name:</strong> {{ $test->test_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Test Code:</strong> {{ $test->test_code }}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Price:</strong> {{ number_format($test->price, 2) }} Tk</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Status:</strong> 
                                            <span class="badge {{ $test->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                                {{ ucfirst($test->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p><strong>Description:</strong></p>
                                    <p>{{ $test->description ?? 'N/A' }}</p>
                                </div>

                                <a href="{{ route('pathological-tests.index') }}" class="btn btn-secondary btn-sm">Back</a>
                                <a href="{{ route('pathological-tests.edit', $test->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('pathological-tests.destroy', $test->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
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
