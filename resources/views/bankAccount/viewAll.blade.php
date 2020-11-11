@extends('layouts.appNew')

@section('titleButton')
    <a href="{{ route('createBankAccount') }}"
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Erstellen
    </a>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-responsive-sm">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Kontoname</th>
                    <th>Konto Nr.</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($bankAccounts as $bankAccount)
                    <tr>
                        <td>{{ $bankAccount->id }}</td>
                        <td>
                            <a href="{{ route('bankAccountView', ['bankAccount' => $bankAccount]) }}">
                                {{ $bankAccount->name }}
                            </a>
                        </td>
                        <td>{{ $bankAccount->accountNumber }}</td>
                        <td>
                            @can('update', $bankAccount)
                                <a href="{{ route('editBankAccount', ['bankAccount' => $bankAccount]) }}" data-toggle="tooltip" data-playment="top" title="Bankkonto bearbeiten">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            @endcan

                            @can('delete', $bankAccount)
                                    <a href="{{ route('deleteBankAccount', ['bankAccount' => $bankAccount]) }}" data-toggle="tooltip" data-playment="top" title="Bankkonto löschen">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
