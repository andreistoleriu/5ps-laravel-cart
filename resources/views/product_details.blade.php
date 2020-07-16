@extends('layout')

@section('title')
    {{ __('Product details') }}
@endsection

@section('content')

    <h1>{{ __('Product details') }}</h1>
    <hr>
        <div class="card" style="width: 30rem">
            @if ($product->image)
                <img src="{{ asset('storage/images/' . $product->image) }}" class="card-img-top" width="150px">
            @else
                {{ __('No image') }}
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $product->title }}</h5>
                <p class="card-text"> {{ $product->description }}</p>
                <h5>$ {{ $product->price }}</h5>
            </div>
        </div>
        <a style="margin-top:15px" href="{{ route('index') }}" class="btn btn-warning"><?= __('Go to index') ?></a>
        <h5 style="margin-top: 15px"><?= ('Comments:') ?> </h5>
        <hr style="background-color: black; height: 1px;">
    @foreach ($comments as $comment)
            <p>{{ __('Date:') }}<span> {{$comment->created_at}}</span></p>
            <p>{{ $comment->message }}</p>
            <hr style="background-color: black; height: 1px;">
    @endforeach

        <h6><? __('Add a comment:') ?></h6>
        <form method="POST" class="form-group" action="{{ route('productDetails.create', ['id' => $product->id]) }}">
        @csrf
            <label for="add_comment"></label>
            <textarea name="comment" id="comment" cols="5" rows="5" class="form-control"></textarea>
            <td><input type="submit" name="add_a_comment" class="btn btn-primary" value="<?= __('Add a comment') ?>" /></td>
        </form>

@endsection