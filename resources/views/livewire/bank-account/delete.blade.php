<form wire:submit.prevent="submit">
    <x-form-error-display/>

    <div class="form-group">
        <label for="name">Möchtest du wirklich dieses Bankkonto löschen?</label>
        <small id="nameHelp" class="form-text text-muted">Das löschen eines Bankkontos lässt sich nicht
            rückgängig machen.</small>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">Löschen</button>
</form>