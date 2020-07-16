@extends('layout')

@section('content')

<h1>{{ __('Home') }}</h1>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th></th>
            <th>{{ __('Title') }}</th>
            <th>{{ __('Description') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Action') }}</th>
            <th></th>
        </tr>
    </thead>

    @forelse ($products as $product)
        <form action="{{ route('index') }}" method="POST">
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
                <td><input type="submit" name="add" class="btn btn-primary" value=" {{ __('Add') }}"></td>
                <td><a href="{{ route('productDetails.index', ['id' => $product->id]) }}" class="btn btn-warning"><?= __('View Details') ?></a></td>
                <td><input type="hidden" name="id" value="{{ $product->id }}"></td>
            </tr>
        </form>
    @empty
        <tr>
            <td colspan="7">{{ __('No products available') }}</td>
        </tr>
    @endforelse
</table>

@endsection