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
                <form action="cart?id={{ $product->id }}" method="post">
                    @csrf
                    <tr>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/images/' . $product->image) }}" width="150px">
                            @else
                                {{ __('No image') }}
                            @endif
                        </td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td><input type="submit" name="delete" class="btn btn-danger" value="{{ __('Remove') }}"></td>
                        <td><input type="hidden" name="id" value=" {{ $product->id }}"></td>
                    </tr>
                </form>
            @endforeach
            <tr>
                <td colspan="3" align="middle"><strong>
                    {{ __('TOTAL') }}</strong>
                <td colspan="2"><strong>{{ $price }}</strong></td>
            </tr>
        </table>
        
        <form method="POST" action="cart/checkout" class="form-group" >
            @csrf

            <div>
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Insert your name...">

                @if ($errors->has('name'))
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div>
                <label for="contactDetails">{{ __('Contact Details') }}</label>
                <input type="text" name="contactDetails" value="{{ old('contactDetails') }}" class="form-control" placeholder="Insert your contact details...">

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