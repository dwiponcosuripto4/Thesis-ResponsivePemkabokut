@extends('admin.layouts.navigation')

@section('content')
    <div class="container p-4">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="text-center">
                    <h1>Create a New Headline</h1>
                </div>
                <form action="{{ route('headlines.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
