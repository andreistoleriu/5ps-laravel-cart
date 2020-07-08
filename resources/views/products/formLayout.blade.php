<div>
    <label for="title">{{ __('Title') }}</label>
    <input type="text" class="form-control" name="title" value="{{ $product ?? '' ? $product->title : old('title') }}">

    @if ($errors->has('title'))
        <p class="text-danger">{{ $errors->first('title') }}</p>
    @endif
</div>

<div>
    <label for="description">{{ __('Description') }}</label>
    <textarea class="form-control" name="description" cols="30" rows="10">{{ $product ?? '' ? $product->description : old('description') }}</textarea>

    @if ($errors->has('description'))
        <p class="text-danger">{{ $errors->first('description') }}</p>
    @endif
</div>

<div>
    <label for="price">{{ __('Price') }}</label>
    <input type="text" class="form-control" name="price" value="{{ $product ?? '' ? $product->price : old('price') }}">

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