@extends('layout')

@section('title')
    {{ __('Cart') }}
@endsection

@section('content')
    <h1>{{ __('Cart') }}</h1>

    @if(!$cart)
        @if(request()->has('success'))
            <div class="p-3 mb-2 bg-success text-white">{{ __('Order sent!') }}</div>
        @endif

        <p class="text-danger">{{ __('Cart is empty') }}</p>
    @else
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            @foreach ($products as $product)
                <tr>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/images/' . $product->image) }}" width="200px">
                        @else
                            {{ __('No image') }}
                        @endif
                    </td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td><a href="?id={{ $product->id }}" class="btn btn-danger">{{ __('Remove') }}</a></td>
                </tr>
            @endforeach
            <tr>
                <hr>
                <td colspan="3" align="middle">
                    {{ __('TOTAL') }}
                <td colspan="2"><strong>{{ $price }}</strong></td>
            </tr>
        </table>
        
        <form method="POST" class="form-group">
            @csrf

            <div>
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control">

                @if ($errors->has('name'))
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div>
                <label for="contactDetails">{{ __('Contact Details') }}</label>
                <input type="text" name="contactDetails" value="{{ old('contactDetails') }}" class="form-control">

                @if ($errors->has('contactDetails'))
                    <p class="text-danger">{{ $errors->first('contactDetails') }}</p>
                @endif
            </div>

            <div>
                <label for="comments">{{ __('Comments') }}</label>
                <textarea name="comments" class="form-control">{{ old('comments') }}</textarea>

                @if ($errors->has('comments'))
                    <p class="text-danger">{{ $errors->first('comments') }}</p>
                @endif
            </div>

            <div>
                <input type="submit" name="submit" value="{{__('Checkout') }}" class="btn btn-primary">
            </div>
        </form>
    @endif
@endsection