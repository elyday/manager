@extends('layouts.authentication')

@section('content')
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
        <div class="col-lg-6">
            <div class="p-5" x-data="{ recovery: false }">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Two-Factor!</h1>
                    <p class="mb-4" x-show="! recovery">
                        Bitte bestätige den Zugang zu deinem Konto, indem du den Authentifizierungscode eingibst, den du
                        von deiner Authentifizierungsanwendung erhalten hast.
                    </p>

                    <p class="mb-4" x-show="recovery">
                        Bitte bestätige den Zugang zu deinem Konto, indem du einen Wiederherstellungscode eingibst.
                    </p>
                </div>

                <x-form-error-display/>

                <form class="user" method="POST" action="{{ route('two-factor.login') }}">
                    @csrf

                    <div class="form-group" x-show="! recovery">
                        <input type="text" name="code" id="code" autofocus x-ref="code" autocomplete="one-time-code"
                               class="form-control form-control-user" placeholder="Code">
                    </div>

                    <div class="form-group" x-show="recovery">
                        <input type="text" name="recovery_code" id="recovery_code" autofocus x-ref="recovery_code"
                               autocomplete="one-time-code" class="form-control form-control-user"
                               placeholder="Wiederherstellungscode">
                    </div>

                    <button type="button" class="btn btn-dark btn-user btn-block" x-show="! recovery"
                            x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        Wiederherstellungscode benutzen
                    </button>

                    <button type="button" class="btn btn-dark btn-user btn-block" x-show="recovery"
                            x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        Authentifizierungscode benutzen
                    </button>
                    <br>
                    <br>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection