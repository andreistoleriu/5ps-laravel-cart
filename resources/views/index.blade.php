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
                <tr>
                    <td>
                        @if ($product->image)
                            <img src="{{ URL::to('/') }}/images/{{ $product->image }}" width="70px" height="70px">
                        @else
                            {{ __('No image') }}
                        @endif
                    </td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td><a href="?id={{ $product->id }}" class="btn btn-primary">{{ __('Add') }}</a></td>
                </tr>

                @empty
                <tr>
                    <td colspan="5">{{ __('The products are added in the cart') }}</td>
                </tr>
            @endforelse
        </table>
@endsection