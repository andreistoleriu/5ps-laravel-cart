@extends('layout')

@section('title')
    {{__('Comments page')}}
@endsection

@section('content')
    <h3 style="margin-top: 15px">{{__('Comments')}} </h3>
    <hr style="background-color: black; height: 1px;">
@foreach ($comments as $comment)
        <td><input type="hidden" name="cid" value="{{ $comment->id }}" /></td>
        @if ($comment->image)
            <img src="{{ asset('storage/images/' . $comment->image) }}" width="150px">
        @else
            {{ __('No image') }}
        @endif
        <h5> {{ $comment->title }} </h5>
        <p> {{ __('Date:') }} {{ $comment->created_at }}</p>
        <p> {{ __('Message:') }} {{ $comment->message }}
        <a href="{{ route('comments.edit', $comment->cid) }}" class="edit-btn btn btn-warning">{{__('Edit')}}</a>
        <form method="POST" action="{{ route('comments.delete', $comment->cid) }}" class="form-group">
            @method('DELETE')
            @csrf
            <input type="submit" name="delete" class="btn btn-danger" value= "{{__('Delete')}}" />
        </form>
        <hr style="background-color: black; height: 1px;">
@endforeach

@endsection