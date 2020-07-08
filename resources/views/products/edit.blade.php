@extends('layout')

@section('title')
    {{ __('Edit product') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="form-group">
        @method('PUT')
        @csrf

        @include('products.formLayout')
    </form>

@endsection