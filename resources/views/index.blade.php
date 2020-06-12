@extends('layout')

@section('content')
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

            @forelse ($products as $product)
                <form action="/" method="POST">
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
                        <td><input type="hidden" name="id" value="{{ $product->id }}"></td>
                    </tr>
                </form>
                    
                @empty
                <tr>
                    <td colspan="5">{{ __('The products are added in the cart') }}</td>
                </tr>
            @endforelse
        </table>
@endsection