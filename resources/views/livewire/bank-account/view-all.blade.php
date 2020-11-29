<x-manager-action-section>
    <x-slot name="content">
        <x-jet-button wire:click="createNewBankAccount" wire:loading.attr="disabled">
            Erstellen
        </x-jet-button>
        <br><br>

        <x-jet-action-message class="mr-3" on="saved">
            <div class="font-medium text-green-600">Bankkonto wurde gespeichert.</div>
            <br>
        </x-jet-action-message>

        <x-jet-action-message class="mr-3" on="deleted">
            <div class="font-medium text-green-600">Bankkonto wurde gelöscht.</div>
            <br>
        </x-jet-action-message>

        <table class="border-collapse w-full">
            <thead>
            <tr>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                    #
                </th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                    Kontoname
                </th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                    Konto Nr.
                </th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->accounts as $bankAccount)
                <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Company name</span>
                        {{ $bankAccount->id }}
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Country</span>
                        <a href="{{ route('bankAccountView', ['bankAccount' => $bankAccount]) }}"
                           class="text-blue-400 hover:text-blue-600">
                            {{ $bankAccount->name }}
                        </a>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                        {{ $bankAccount->accountNumber }}
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
                        @can('update', $bankAccount)
                            <a wire:click="editBankAccount({{ $bankAccount }})" wire:loading.attr="disabled"
                               class="text-blue-400 hover:text-blue-600">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        @endcan

                        @can('delete', $bankAccount)
                            <a wire:click="deleteBankAccount({{ $bankAccount }})" wire:loading.attr="disabled"
                               class="text-blue-400 hover:text-blue-600">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <x-jet-dialog-modal wire:model="editingBankAccount">
            <x-slot name="title">
                {{ $this->title }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4" x-on:edit-bank-account.window="setTimeout(() => $refs.name.focus(), 250)">
                    <x-jet-label for="name" value="Name"/>
                    <x-jet-input id="name" type="text" maxlength="50" class="mt-1 block w-full"
                                 x-ref="name"
                                 wire:model.defer="name"
                                 wire:keydown.enter="submitBankAccount" />
                    <x-jet-input-error for="name" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="accountNumber" value="Konto Nr."/>
                    <x-jet-input id="accountNumber" type="text" maxlength="15" class="mt-1 block w-full"
                                 wire:model.defer="accountNumber"
                                 wire:keydown.enter="submitBankAccount" />
                    <x-jet-input-error for="accountNumber" class="mt-2"/>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('editingBankAccount')" wire:loading.attr="disabled">
                    Nope
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="submitBankAccount" wire:loading.attr="disabled">
                    Speichern
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

        <x-jet-dialog-modal wire:model="deletingBankAccount">
            <x-slot name="title">
                Bankkonto löschen
            </x-slot>

            <x-slot name="content">
                <div class="font-weight-bold text-red-600">Möchtest du das Bankkonto "{{ $this->bankAccountName }}" wirklich löschen?</div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('deletingBankAccount')" wire:loading.attr="disabled">
                    Nope
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="submitDeleteBankAccount" wire:loading.attr="disabled">
                    Löschen
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-manager-action-section>