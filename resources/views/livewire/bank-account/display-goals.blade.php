@if(empty($goals))
    <div class="alert alert-info" role="alert">Es wurden keine Ziele gefunden.</div>
@else
    <table class="table table-striped table-responsive-sm">
        <thead>
        <tr>
            <th>Gestartet</th>
            <th>Beendet</th>
            <th>Ziel ($)</th>
            <th>Letzter Kontostand ($)</th>
            <th>Erreicht (%)</th>
            <th>Abgeschlossen?</th>
            <th>Zeit vergangenen (Tage)</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($goals as $goal)
            <tr>
                <td>{{ \Carbon\Carbon::parse($goal->startedAt)->format('d.m.Y') }}</td>
                <td>
                    @if($goal->endedAt !== null)
                        {{ \Carbon\Carbon::parse($goal->endedAt)->format('d.m.Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>${{ number_format($goal->goal, 2, ',', '.') }}</td>
                <td>${{ number_format($goal->lastBalance, 2, ',', '.') }}</td>
                <td>{{ number_format($goal->calculateReachedPercentage(), 2, ',', '.') }} %</td>
                <td>
                    @if($goal->endedAt !== null)
                        <div style="color: green;">Ja</div>
                    @else
                        <div style="color: red;">Nein</div>
                    @endif
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($goal->startedAt)->diffInDays($goal->endedAt) }}
                </td>
                <td>
                    @can('update', $goal)
                        @if($goal->endedAt === null)
                            <a href="#" wire:click="completeGoal({{ $goal->id }})" data-toggle="tooltip" data-playment="top" title="Ziel abschließen">
                                <i class="fas fa-check"></i>
                            </a>
                        @endif
                    @endcan

                    @can('delete', $goal)
                        <a href="#" wire:click="deleteGoal({{ $goal->id }})" data-toggle="tooltip" data-playment="top" title="Ziel löschen">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif