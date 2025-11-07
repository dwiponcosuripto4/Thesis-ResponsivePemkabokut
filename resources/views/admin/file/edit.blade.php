@extends('admin.layouts.navigation')

@section('title', 'Edit File')

@section('content')
    <section>
        <div class="card bg-white p-4 shadow rounded-4 border-0">
            <h4>Edit File</h4>
            <form action="{{ route('file.update', $file->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title', $file->title) }}" required>
                </div>
                <div class="mb-3">
                    <label for="file_date" class="form-label">File Date</label>
                    <input type="date" name="file_date" id="file_date" class="form-control"
                        value="{{ old('file_date', $file->file_date) }}" required>
                </div>
                <div class="mb-3">
                    <label for="document_id" class="form-label">Document</label>
                    <select name="document_id" id="document_id" class="form-control" required>
                        <option value="">-- Pilih Dokumen --</option>
                        @foreach ($documents as $document)
                            <option value="{{ $document->id }}" {{ $file->document_id == $document->id ? 'selected' : '' }}>
                                {{ $document->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('file.data') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </section>
@endsection
