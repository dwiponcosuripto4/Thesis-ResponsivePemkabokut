@extends('admin.layouts.navigation')

@section('title', $document->title)

@section('content')
    <div class="card bg-white p-4 shadow rounded-4 border-0">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h4>Document Details</h4>
            </div>
            <div>
                <a href="{{ route('document.data') }}" class="btn btn-secondary">Back to Documents</a>
                <a href="{{ route('document.edit', $document->id) }}" class="btn btn-primary">Edit Document</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $document->title }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Title:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $document->title }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Data Category:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $document->data->title ?? 'No Data' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Created:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $document->created_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Updated:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $document->updated_at->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($document->file && $document->file->count() > 0)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Associated Files</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>File Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($document->file as $file)
                                            <tr>
                                                <td>{{ basename($file->file_path) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($file->file_date)->format('d M Y') }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                        class="btn btn-sm btn-primary">Download</a>
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
        @endif
    </div>
@endsection
