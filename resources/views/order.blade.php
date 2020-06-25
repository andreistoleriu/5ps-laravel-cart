@extends('layout')

@section('title')
    {{ __('Order') }}
@endsection

@section('content')

    <p>{{ __('Name: ') . $order->name }}</p>
    <p>{{ __('Contact details: ') . $order->contact_details }}</p>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th></th>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Price') }}</th>
            </tr>
        </thead>
            
        @foreach ($products as $product)
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
                <td>{{ $product->product_price }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" align="middle"><strong>
                {{ __('TOTAL') }}</strong>
            <td colspan="2"><strong>{{ $price }}</strong></td>
        </tr>
    </table>
@endsection