@extends('layouts.appNew')

@section('titleButton')
    <a href="{{ route('bankAccounts') }}"
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Zurück
    </a>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-body">
            @livewire('manage-bank-account', ['bankAccount' => $bankAccount])
        </div>
    </div>
@endsection
