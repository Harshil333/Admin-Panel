@extends('layouts.app')
@section('content')
<div class="container text-center">
    <h3>Add New Category</h3>
    <div class="jumbotron">
        <form action="/categories" method="POST">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Add It!</button>
        </form>
    </div>
</div>
@endsection