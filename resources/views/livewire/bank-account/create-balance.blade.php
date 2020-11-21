<form wire:submit.prevent="submit">
    <x-form-error-display/>

    <div class="form-group">
        <label for="captured">Erfasst am</label>
        <input type="date" class="form-control @error('captured') is-invalid @endError" id="captured" name="captured"
               aria-describedby="capturedHelp" wire:model="captured">
        <small id="capturedHelp" class="form-text text-muted">Wann wurde dieser Kontostand
            erfasst?</small>
    </div>

    <div class="form-group">
        <label for="value">Kontostand</label>
        <input type="text" class="form-control @error('value') is-invalid @endError" id="value" name="value"
               aria-describedby="valueHelp" wire:model="value">
        <small id="valueHelp" class="form-text text-muted">Welcher Kontostand wurde erfasst?</small>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">Erfassen</button>
</form>