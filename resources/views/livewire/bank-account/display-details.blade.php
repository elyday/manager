<x-manager-action-section wire:poll="polling">
    <x-slot name="title">
        Details
    </x-slot>

    <x-slot name="description">
        Hier siehst du alle Details kurz und knackig aufgelistet.
    </x-slot>

    <x-slot name="content">
        <div class="text-blue-500 font-bold">Durchschnitt</div>

        <table class="table-auto">
            <tbody>
            <tr>
                <th>Kontostand</th>
                <td>$ {{ number_format($this->averageBalance, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Differenz ($)</th>
                <td>$ {{ number_format($this->averageBalanceDifferenceDollar, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Differenz (%)</th>
                <td>{{ number_format($this->averageBalanceDifferencePercentage, 2, ',', '.') }} %</td>
            </tr>
            </tbody>
        </table>
    </x-slot>
</x-manager-action-section>