<?php
    $document = Documents::find($id);
    $building = Buildings::find($document->group);
?>

<div class="row">
    <h2>Urejanje dokumenta</h2>
    {{ Form::open(array('url' => 'documents/edit/'.$document->id, 'files' => false, 'method' => 'post', 'id' => 'documentEdit')) }}
    <div class="row">
        <div class="large-12 columns">
            {{ Form::label('name','Opis dokumenta:') }}
            {{ Form::text('name',$document->name) }}
        </div>
    </div>
    <div class="row">
        <div class="large-2 columns">
            {{ Form::label('extension','Tip datoteke:') }}
            {{ Form::text('extension',$document->extension, array('disabled' => 'disabled')) }}
        </div>
        <div class="large-4 columns">
            {{ Form::label('fileName','Ime datoteke:') }}
            {{ Form::text('fileName',$document->fileName, array('disabled' => 'disabled')) }}
        </div>
        <div class="large-6 columns">
            {{ Form::label('path','Pot:') }}
            {{ Form::text('path', $document->path, array('disabled' => 'disabled')) }}
            {{ Form::hidden('buildingId', $building->id) }}
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input class="button" type="submit" id="submitButton" value="Shrani in pošlji">
        </div>
    </div>
    {{ Form::close() }}
</div>
<a class="close-reveal-modal" aria-label="Close">&#215;</a>