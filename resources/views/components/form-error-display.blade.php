@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        Die folgenden Fehler sind aufgetreten:

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif