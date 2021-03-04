@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row col-sm-12 justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-8">
        <div id="login-card" class="card">
            <div class="card-header">Bejelentkezés</div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">E-mail cím</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control blue @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Jelszó</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control blue @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row col-sm-12">
                        <div id="remember-box" class="col-sm-12 col-md-8 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input blue" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    Megjegyzés
                                </label>
                            </div>
                        </div>

                        <div id="login-input-box" class="col-sm-12 col-md-8 offset-md-4">
                            <button id="login-button" type="submit" class="btn btn-primary blue">
                                Bejelentkezés
                            </button>

                            @if (Route::has('password.request'))
                                <a id="password-reset-button" href="{{ route('password.request') }}">Elfelejtette a jelszavát?</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
