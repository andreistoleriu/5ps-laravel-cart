@extends('layout')

@section('title')
    {{ __('Login') }}
@endsection

@section('content')

    @if (session('status'))
        <div style="max-width: 30%; margin: 10px auto;">
            <p class="text-danger">{{ __('Please login to access that page') }}</p>
        </div>
    @endif

    <form method="POST" class="form-group">
        @csrf

        <div style="max-width: 30%; margin: 20px auto;">
            <label for="name">{{ __('Username') }}</label>
            <input style="margin-bottom: 10px;" type="text" name="username" value="{{ old('name') }}" class="form-control">

            @if ($errors->has('username'))
                <p class="text-danger">{{ $errors->first('username') }}</p>
            @endif

            <label for="password">{{ __('Password') }}</label>
            <input style="margin-bottom: 10px;" type="password" name="password" class="form-control">

            @if ($errors->has('password'))
                <p class="text-danger">{{ $errors->first('password') }}</p>
            @endif

            <input type="submit" class="btn btn-primary" name="submit" value="{{ __('Log in') }}">
        </div>
    </form>
@endsection