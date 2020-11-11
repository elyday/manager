<form wire:submit.prevent="submit">
    <x-form-error-display/>

    <div class="form-group">
        <label for="startedAt">Startet am</label>
        <input type="date" class="form-control @error('captured') is-invalid @endError" id="startedAt" name="startedAt"
               aria-describedby="startedAt" wire:model="startedAt">
        <small id="startedAtHelp" class="form-text text-muted">Wann startet dieses Ziel?</small>
    </div>

    <div class="form-group">
        <label for="goal">Ziel</label>
        <input type="text" class="form-control @error('value') is-invalid @endError" id="goal" name="goal"
               aria-describedby="goalHelp" wire:model="goal">
        <small id="goalHelp" class="form-text text-muted">Wie lautet das Ziel?</small>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">Erstellen</button>
</form>