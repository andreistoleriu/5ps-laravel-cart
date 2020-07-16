@extends('layout')

@section('title')
    {{ __('Edit product') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="form-group">
        @method('PUT')
        @csrf

        <div>
            <label for="title">{{ __('Title') }}</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $product->title) }}">
        
            @if ($errors->has('title'))
                <p class="text-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>
        
        <div>
            <label for="description">{{ __('Description') }}</label>
            <textarea class="form-control" name="description" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>
        
            @if ($errors->has('description'))
                <p class="text-danger">{{ $errors->first('description') }}</p>
            @endif
        </div>
        
        <div>
            <label for="price">{{ __('Price') }}</label>
            <input type="text" class="form-control" name="price" value="{{ old('price', $product->price) }}">
        
            @if ($errors->has('price'))
                <p class="text-danger">{{ $errors->first('price') }}</p>
            @endif
        </div>
        
        <div>
            <label for="image">{{ __('Choose an image') }}</label>
            <input type="file" class="form-control" name="image">
        
            @if ($errors->has('image'))
                <p class="text-warning">{{ $errors->first('image') }}</p>
            @endif
        </div>
        
        <div>
            <input type="submit" class="btn btn-primary" name="submit" value="{{ __('Submit') }}">
        </div>

    </form>

@endsection