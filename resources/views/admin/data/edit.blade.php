@extends('admin.layouts.navigation')

@section('title', 'Edit Data')

@section('content')
    <section>
        <div class="card bg-white p-4 shadow rounded-4 border-0">
            <h4>Edit Data</h4>
            <form action="{{ route('data.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title', $data->title) }}" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">-- Pilih Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $data->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('data.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </section>
@endsection
