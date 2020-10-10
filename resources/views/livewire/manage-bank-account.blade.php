<form wire:submit.prevent="submit">
    <x-form-error-display/>

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" maxlength="50" class="form-control @error('name') is-invalid @endError" id="name" name="name"
               aria-describedby="nameHelp" wire:model="name">
        <small id="nameHelp" class="form-text text-muted">Dies ist der Name des Bankkontos.</small>
    </div>

    <div class="form-group">
        <label for="accountNumber">Konto Nr.</label>
        <input type="text" maxlength="15" class="form-control @error('accountNumber') is-invalid @endError" id="accountNumber" name="accountNumber"
               aria-describedby="accountNumberHelp" wire:model="accountNumber">
        <small id="accountNumberHelp" class="form-text text-muted">Hier bitte die Kontonummer eintragen.</small>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">Speichern</button>
</form>
