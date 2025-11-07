@extends('admin.layouts.navigation')

@section('title', 'Data Documents & Files')

@section('content')
    <section>
        <div class="card bg-white p-4 shadow rounded-4 border-0">
            <div class="d-flex justify-content-between mb-4">
                <div>
                    <h4>Data Folder Documents & Files</h4>
                </div>
                <div>
                    <a href="{{ route('data.create') }}" class="btn btn-primary">Add new Data</a>
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
                            <th width="30%">Title</th>
                            <th width="15%">Documents</th>
                            <th width="20%">Category</th>
                            <th width="8%">ID</th>
                            <th width="22%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $dataItem)
                            <tr>
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td>{{ $dataItem->title }}</td>
                                <td class="text-center">{{ $dataItem->documents->count() }}</td>
                                <td>{{ $dataItem->category->title ?? 'No Category' }}</td>
                                <td class="text-center">{{ $dataItem->id }}</td>
                                <td>
                                    <a href="{{ route('data.show', $dataItem->id) }}" class="btn btn-success">Show</a>
                                    <a href="{{ route('data.edit', $dataItem->id) }}" class="btn btn-info">Edit</a>
                                    <form action="{{ route('data.destroy', $dataItem->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this document?')">
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
    </section>

@endsection
