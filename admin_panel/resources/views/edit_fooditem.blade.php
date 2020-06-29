@extends('layouts.app')

@section('content')

<div class="container text-center">
    <form action="{{url('/fooditems/'.$foodItem["id"].'/edit')}}" method="post">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$foodItem["name"]) }}" required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

            <div class="col-md-6">
                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price',$foodItem["price"]) }}" required>

                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="discount_price" class="col-md-4 col-form-label text-md-right">{{ __('Discount Price') }}</label>

            <div class="col-md-6">
                <input id="discount_price" type="number" class="form-control @error('discount_price') is-invalid @enderror" name="discount_price" value="{{ old('discount_price',$foodItem["discount_price"]) }}">

                @error('discount_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
            <div class="col-md-6">
                <input type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" value="{{ old('image',$foodItem["image"]) }}">

                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

            <div class="col-md-6">
                <textarea name="description" class="form-control" id="description" required>{{ old('description',$foodItem["description"]) }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="category_name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>

            <div class="col-md-6">
                <select name="category_name" id="category_name" class="form-control" value="{{ old('category_name',$foodItem["category_name"]) }}" required>
                    <option value="">Choose Category...</option>
                    @if(count($categories)>0)
                        @foreach ($categories as $category)
                            <option value="{{$category["name"]}}">{{$category["name"]}}</option>
                        @endforeach
                    @endif
                </select>

                @error('category_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

@endsection