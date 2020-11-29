<x-app-layout>
    <x-slot name="pageTitle">Bankkonto "{{ $bankAccount->name }}"</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bankkonto "{{ $bankAccount->name }}"
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('bank-account.display-details', ['bankAccount' => $bankAccount])

            <x-jet-section-border />

            @livewire('bank-account.display-goals', ['bankAccount' => $bankAccount])

            <x-jet-section-border />

            @livewire('bank-account.display-balances', ['bankAccount' => $bankAccount])
        </div>
    </div>
</x-app-layout>