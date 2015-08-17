<?php
    $folders = Folders::all();
?>

{{ Form::label('folder1', 'Mapa') }}
<select id="folder" name="folder">
    @if (! empty($folders))
        @foreach ($folders as $folder)
            <option value="{{ $folder->id }}">{{ $folder->name }}</option>
        @endforeach
    @endif
</select>