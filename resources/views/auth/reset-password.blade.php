@extends('layouts.authentication')

@section('content')
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
        <div class="col-lg-6">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Passwort zurücksetzen</h1>
                </div>

                <x-form-error-display/>

                <form class="user" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-group">
                        <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required
                               autofocus class="form-control form-control-user" placeholder="E-Mail Adresse..">
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