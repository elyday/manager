@extends('layouts.authentication')

@section('content')
    <div class="row">
        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
        <div class="col-lg-7">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Registrieren</h1>
                </div>

                <x-form-error-display/>

                <form class="user" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group ">
                        <input type="text" class="form-control form-control-user" id="name" name="name"
                               value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="email" name="email"
                               value="{{ old('email') }}" required placeholder="Email Address">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user" id="password" name="password"
                                   required autocomplete="new-password" placeholder="Passwort">
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control form-control-user" id="password_confirmation"
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="Passwort wiederholen">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Registrieren
                    </button>
                </form>
                <hr>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a class="small" href="{{ route('password.request') }}">Passwort vergessen?</a>
                    </div>
                @endif

                <div class="text-center">
                    <a class="small" href="{{ route('login') }}">Bereit Registriert? Jetzt einloggen!</a>
                </div>
            </div>
        </div>
    </div>
@endsection