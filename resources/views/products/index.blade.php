@extends('layout')

@section('title')
    {{ __('Products') }}
@endsection

@section('content')

    <h1>{{ __('Products') }}</h1>

        <table class="table">
            <tr>
                <th>{{ __('Id') }}</th>
                <th>{{ __('Image') }}</th>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Edit') }}</th>
                <th>{{ __('Delete') }}</th>
            </tr>

            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if ($product->image)
                            <img alt="{{ __('Product image') }}" src="{{ asset('storage/images/' . $product->image) }}"
                                 width="70px" height="70px">
                        @else
                            {{ __('No image here') }}
                        @endif
                    </td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td><a class="btn btn-warning" href="products/{{ $product->id }}/edit">{{ __('Edit') }}</a></td>
                    <td>
                        <form method="POST" action="/products/{{ $product->id }}">
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
        <div>
            <a class="btn btn-primary" href="products/create">{{ __('Add a new product') }}</a>
        </div>
@endsection