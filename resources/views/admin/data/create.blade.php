@extends('admin.layouts.navigation')

@section('content')
    <div class="container p-4">
        <section>
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    <div class="text-center">
                        <h1>Create a New Data</h1>
                    </div>
                    <form action="{{ route('data.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title" id="title"
                                value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <label for="category_id">Category:</label>
                        <select name="category_id" class="form-control" id="category-select">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-lg btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
    </div>
    </section>
@endsection
