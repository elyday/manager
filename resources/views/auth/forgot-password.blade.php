@extends('layouts.authentication')

@section('content')
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
        <div class="col-lg-6">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Passwort vergessen?</h1>
                    <p class="mb-4">
                        Das kann schon mal passieren. Gebe unten einfach deine E-Mail Adresse ein und wir schicken dir
                        einen Link mit dem du dein Passwort zurücksetzen kannst.
                    </p>
                </div>

                <x-form-error-display />

                @if (session('status'))
                    <div class="alert alert-info">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="user" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <input type="email" id="email" name="email" :value="old('email')" required autofocus
                               class="form-control form-control-user" placeholder="E-Mail Adresse..">
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Passwort zurücksetzen
                    </button>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="{{ route('register') }}">Registrieren</a>
                </div>
                <div class="text-center">
                    <a class="small" href="{{ route('login') }}">Bereits Registriert? Jetzt Einloggen!</a>
                </div>
            </div>
        </div>
    </div>
@endsection