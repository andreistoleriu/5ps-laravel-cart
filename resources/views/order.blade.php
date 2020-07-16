@extends('layout')

@section('title')
    {{ __('Order') }}
@endsection

@section('content')

    <p>{{ __('Name: ') }} <span>{{ $order->name }}</span></p>
    <p>{{ __('Contact details: ') }} <span>{{ $order->contact_details }}</span></p>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th></th>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Price') }}</th>
            </tr>
        </thead>
            
        @foreach ($order->products as $product)
            <tr>
                <td>
                    @if ($product->image)
                        <img
                            alt="{{ __('Product image') }}"
                            src="{{ asset('storage/images/' . $product->image) }}"
                            width="150px">
                    @else
                        {{ __('No image here') }}
                    @endif
                </td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->pivot->product_price }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" align="middle"><strong>
                {{ __('TOTAL') }}</strong>
            <td colspan="2"><strong>{{ $order->price }}</strong></td>
        </tr>
    </table>
@endsection