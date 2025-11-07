@extends('admin.layouts.navigation')

@section('title', 'Data Categories')

@section('content')
    <div class="card bg-white p-4 shadow rounded-4 border-0">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h4>Data Categories</h4>
            </div>
            <div>
                <a href="{{ route('category.create') }}" class="btn btn-primary">Add new Category</a>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Informasi</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Title</th>
                        <th width="10%">Posts</th>
                        <th width="15%">Created At</th>
                        <th width="15%">Updated At</th>
                        <th width="8%">ID</th>
                        <th width="22%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                        <tr>
                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                            <td>{{ $category->title }}</td>
                            <td class="text-center">{{ $category->posts->count() }}</td>
                            <td>{{ $category->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $category->updated_at->format('d M Y, H:i') }}</td>
                            <td class="text-center">{{ $category->id }}</td>
                            <td>
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-info">Edit</a>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
