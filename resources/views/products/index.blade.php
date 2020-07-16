@extends('layout')

@section('title')
    {{ __('Products') }}
@endsection

@section('content')

    <h1>{{ __('Products') }}</h1>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Edit') }}</th>
                    <th>{{ __('Delete') }}</th>
                </tr>
            </thead>

            @forelse ($products as $product)
                <tr>
                    <td>
                        @if ($product->image)
                        <img src="{{ asset('storage/images/' . $product->image) }}" width="150px">
                        @else
                            {{ __('No image here') }}
                        @endif
                    </td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td><a class="btn btn-warning" href="{{ route('products.edit', $product->id) }}">{{ __('Edit') }}</a></td>
                    <td>
                        <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                            @method('DELETE')
                            @csrf

                            <input class="btn btn-danger" type="submit" name="delete" value="{{ __('Delete') }}">
                        </form>
                    </td>
                </tr>
            
            @empty
                <tr>
                    <td colspan="7">{{ __('No products available') }}</td>
                </tr>
            @endforelse
        </table>
        <div div class="d-flex justify-content-around">
            <a class="btn btn-primary" href="{{ route('products.create') }}">{{ __('Add a new product') }}</a>
            <a class="btn btn-warning" href="{{ route('comments.index') }}">{{ __('Manage comments') }}</a>
        </div>
@endsection