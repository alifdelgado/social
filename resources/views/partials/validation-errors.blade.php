@if ($errors->any())
    <div id="validation-errors">
        <ul class="list-group">
            @foreach ($errors as $error)
                <li class="list-group-item">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
