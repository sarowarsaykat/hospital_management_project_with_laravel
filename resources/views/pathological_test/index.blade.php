@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Pathological Tests</h3>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('pathological-tests.create') }}" class="btn btn-success mb-2">Add New Test</a>
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Test Name</th>
                                        {{-- <th>Test Code</th> --}}
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pathologicalTests as  $index =>$test)
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $test->test_name }}</td>
                                            {{-- <td>{{ $test->test_code }}</td> --}}
                                            <td>{{Str::limit($test->description, 40) }}</td>
                                            <td>{{ $test->price }} Tk</td>
                                            <td>
                                                <span
                                                    class="badge {{ $test->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ ucfirst($test->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('pathological-tests.show', $test->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pathological-tests.edit', $test->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('pathological-tests.destroy', $test->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
