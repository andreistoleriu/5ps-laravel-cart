@extends('layout')

@section('title')
    {{ __('Login') }}
@endsection

@section('content')
    <h1>{{ __('Login') }}</h1>

    @if (request()->has('unauthorized'))
        <p>{{ __('You must be logged in to access this page') }}</p>
    @endif

    <form method="POST" class="form-group">
        @csrf

        <div>
            <label for="name">{{ __('Username') }}</label>
            <input type="text" name="name" class="form-control">

            @if (isset($errorMessage['name']))
                @foreach ($errorMessage['name'] as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            @endif
        </div>

        <div>
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" class="form-control">

            @if (isset($errorMessage['password']))
                @foreach ($errorMessage['password'] as $error)
                    <p>{!! $error !!}</p>
                @endforeach
            @endif
        </div>

        <div>
            <input type="submit" class="btn btn-primary" name="submit" value="{{ __('Log in') }}">
        </div>
    </form>
@endsection