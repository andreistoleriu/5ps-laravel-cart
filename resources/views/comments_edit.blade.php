@extends('layout')

@section('title')
    {{ __('Edit comment') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('comments.update', $comment->id) }}" enctype="multipart/form-data" class="form-group">
        @method('PUT')
        @csrf

        <div>
            <label for="message">{{ __('Message') }}</label>
            <textarea class="form-control" name="message" cols="30" rows="10">{{ $comment ?? '' ? $comment->message : old('message') }}</textarea>
        
            @if ($errors->has('message'))
                <p class="text-danger">{{ $errors->first('message') }}</p>
            @endif
        </div>

        <input type="submit" name="edit_comm" class="btn btn-warning" value="{{ __('Edit comment') }}" />
    </form>

@endsection