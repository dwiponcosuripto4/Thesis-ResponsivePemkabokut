@extends('admin.layouts.navigation')

@section('content')
    <div class="container p-4">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="text-center">
                    <h1>Create a New Document and Upload Files</h1>
                </div>

                <form action="{{ route('document.store') }}" method="post" enctype="multipart/form-data" id="file-form">
                    @csrf

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" id="title"
                            value="{{ old('title') }}">
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <label for="data_id">Data:</label>
                    <select name="data_id" class="form-control" id="data-select">
                        <option value="">-- Select Data --</option>
                        @foreach ($data as $dataItem)
                            <option value="{{ $dataItem->id }}">{{ $dataItem->title }}</option>
                        @endforeach
                    </select>

                    <div class="file-section" style="margin-top: 20px;">
                        <h5>Add Files</h5>
                        <div class="file-entry">
                            <div class="mb-3">
                                <label for="file_title" class="form-label">File Title</label>
                                <input type="text" name="files[0][title]" class="form-control"
                                    placeholder="Enter file title">
                            </div>
                            <div class="mb-3">
                                <label for="file_path" class="form-label">Choose File</label>
                                <input type="file" name="files[0][file]" class="form-control"
                                    accept=".pdf,.doc,.docx,.jpg,.png,.zip,.rar,.xls,.xlsx">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary" id="add-file">Add File</button>

                    <div class="mb-3" style="margin-top: 20px;">
                        <label for="file_date" class="form-label">File Date</label>
                        <input type="date" class="form-control" id="file_date" name="file_date"
                            value="{{ old('file_date') }}" required>
                    </div>

                    <button type="submit" class="btn btn-lg btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/admin/document/create.css') }}">
    <script src="{{ asset('js/admin/document/create.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
