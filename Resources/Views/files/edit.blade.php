<?php
/**
 * Created by PhpStorm.
 * User: blaz
 * Date: 11. 05. 15
 * Time: 12.40
 */

    $file = Files::find($id);
?>

<div class="row">
    <h2>Urejanje slike</h2>
    {{ Form::open(array('url' => 'files/edit/'.$file->id, 'files' => false, 'method' => 'post', 'id' => 'imageEdit')) }}
    <div class="row">
        <div class="large-12 columns">
            {{ Form::label('name','Opis slike:') }}
            {{ Form::text('name',$file->name) }}
        </div>
    </div>
    <div class="row">
        <div class="large-2 columns">
            {{ Form::label('extension','Tip datoteke:') }}
            {{ Form::text('extension',$file->extension, array('disabled' => 'disabled')) }}
        </div>
        <div class="large-4 columns">
            {{ Form::label('fileName','Ime datoteke:') }}
            {{ Form::text('fileName',$file->fileName, array('disabled' => 'disabled')) }}
        </div>
        <div class="large-6 columns">
            {{ Form::label('path','Pot:') }}
            {{ Form::text('path', $file->path, array('disabled' => 'disabled')) }}
            {{ Form::hidden('buildingId', $file->group) }}
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <input class="button" type="submit" id="submitButton" value="Shrani in pošlji">
        </div>
    </div>
</div>
<a class="close-reveal-modal" aria-label="Close">&#215;</a>