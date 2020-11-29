<x-manager-action-section>
    <x-slot name="title">
        Kontostände
    </x-slot>

    <x-slot name="description">
        Dies ist sind alle erfassten Kontostände.
    </x-slot>

    <x-slot name="content">
        <x-jet-button wire:click="createNewBalance" wire:loading.attr="disabled">
            Erfassen
        </x-jet-button>
        <br><br>

        <x-jet-action-message class="mr-3" on="created">
            <div class="font-medium text-green-600">Der Kontostand wurde erfasst.</div>
            <br>
        </x-jet-action-message>

        <x-jet-action-message class="mr-3" on="deleted">
            <div class="font-medium text-green-600">Der erfasste Kontostand wurde gelöscht.</div>
            <br>
        </x-jet-action-message>

        <table class="border-collapse w-full">
            <thead>
            <tr>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                    Erfasst am
                </th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                    Kontostand
                </th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                    Differenz ($)
                </th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                    Differenz (%)
                </th>
                <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->balances as $balance)
                <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Company name</span>
                        {{ \Carbon\Carbon::parse($balance->captured)->format('d.m.Y') }}
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Country</span>
                        $ {{ number_format($balance->value, 2, ',', '.') }}
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                        <div @if($balance->differenceDollar > 0) class="text-green-500"
                             @elseif($balance->differenceDollar < 0) class="text-red-500" @endif>
                            $ {{ number_format($balance->differenceDollar, 2, ',', '.') }}
                        </div>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Status</span>
                        <div @if($balance->differencePercentage > 0) class="text-green-500"
                             @elseif($balance->differencePercentage < 0) class="text-red-500" @endif>
                            {{ number_format($balance->differencePercentage, 2, ',', '.') }} %
                        </div>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
                        @can('delete', $balance)
                            <a href="#" wire:click="deleteBalance({{ $balance }})">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <x-jet-dialog-modal wire:model="createBalance">
            <x-slot name="title">
                Kontostand erfassen
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4" x-on:create-balance.window="setTimeout(() => $refs.captured.focus(), 250)">
                    <x-jet-label for="captured" value="Erfasst am"/>
                    <x-jet-input id="captured" type="date" maxlength="50" class="mt-1 block w-full"
                                 x-ref="captured"
                                 wire:model.defer="captured"
                                 wire:keydown.enter="submitBalance" />
                    <x-jet-input-error for="captured" class="mt-2"/>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="value" value="Kontostand"/>
                    <x-jet-input id="value" type="text" maxlength="15" class="mt-1 block w-full"
                                 wire:model.defer="value"
                                 wire:keydown.enter="submitBalance" />
                    <x-jet-input-error for="value" class="mt-2"/>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('createBalance')" wire:loading.attr="disabled">
                    Nope
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="submitBalance" wire:loading.attr="disabled">
                    Speichern
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-manager-action-section>