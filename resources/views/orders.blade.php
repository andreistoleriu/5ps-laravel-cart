@extends('layout')

@section('title')
    {{ __('Orders') }}
@endsection

@section('content')

    <h1>{{ __('Orders') }}</h1>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Contact details') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>

        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->contact_details }}</td>
                <td>{{ $order->price }}</td>
                <td><a href="order?id={{ $order->id }}">{{ __('View Details') }}</a></td>
            </tr>
        @endforeach
    </table>
@endsection