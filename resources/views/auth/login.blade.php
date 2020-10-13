@extends('layouts.authentication')

@section('content')
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
        <div class="col-lg-6">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Willkommen zurück!</h1>
                </div>

                <x-form-error-display/>

                @if (session('status'))
                    <div class="alert alert-info">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="user" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control form-control-user"
                               id="exampleInputEmail" aria-describedby="emailHelp" placeholder="E-Mail Adresse..">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" required autocomplete="current-password" class="form-control form-control-user"
                               id="exampleInputPassword" placeholder="Passwort">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Login
                    </button>
                </form>
                <hr>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a class="small" href="{{ route('password.request') }}">Passwort vergessen?</a>
                    </div>
                @endif


                <div class="text-center">
                    <a class="small" href="{{ route('register') }}">Registrieren</a>
                </div>
            </div>
        </div>
    </div>
@endsection