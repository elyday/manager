@extends('layouts.authentication')

@section('content')
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-register-image"></div>
        <div class="col-lg-6">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">E-Mail Bestätigen</h1>
                    <p class="mb-4">
                        Vielen Dank fürs Registrieren. Bevor du jedoch starten kannst, musst du zuerst eine E-Mail
                        Adresse verifizieren. Hierzu haben wir dir einen Link an deine angegebene E-Mail Adresse
                        geschickt. Wenn du diese E-Mail nicht erhalten hast, können wir dir eine Neue schicken. Klicke
                        hier zu einfach auf den Button unterhalb dieses Textes.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-info">
                        Ein neuer Verifizierungs Link wurde an deine hinterlegte E-Mail Adresse geschickt.
                    </div>
                @endif

                <form class="user" method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Verifizierungs E-Mail erneut senden
                    </button>
                </form>
                <hr>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-dark btn-user btn-block">
                        Ausloggen
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection