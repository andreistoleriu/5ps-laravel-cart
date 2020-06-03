@extends('layout')

@section('title')
    {{ __('Add product') }}
@endsection

@section('content')
    <form method="POST" action="/products" enctype="multipart/form-data" class="form-group">
        @csrf

        @include('products.formLayout')
    </form>
@endsection