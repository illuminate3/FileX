<?php
/**
 * Created by PhpStorm.
 * User: blaz
 * Date: 7. 07. 15
 * Time: 14.04
 */

$notes = Notes::find($id);
$buildings = Buildings::all();

?>
<script language="javascript">
    $(document).ready(function(){
        $( 'textarea#content' ).ckeditor();
    });
</script>

{{ Form::open(array('url' => 'notes/edit/'.$id, 'files' => false, 'method' => 'post', 'id' => 'noteAdd')) }}
<div class="row">
    <div class="row">
        <div class="large-12 columns">
            <h3>Urejanje obvestila</h3>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            {{ Form::label('name','Naziv') }}
            {{ Form::text('name', $notes->name) }}
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>Vsebina</label>
            <textarea id="content" name="content" rows="10">{{ $notes->content  }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns" style="height: 15px;"></div>
    </div>
    <div class="row">
        <div class="large-6 columns">
            {{ Form::label('building','Objekt') }}
            <select name="building" id="building">
                @foreach($buildings as $building)
                    <option @if ($building->buildingCode == $notes->group) selected @endif value="{{ $building->buildingCode }}">{{ $building->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="large-6 columns">
            {{ Form::checkbox('published', 'yes', $notes->visibility==1 ? true : false) }} Objavljeno <br />
            {{ Form::checkbox('urgent', 'yes') }} Nujno <br />
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns">
            <div style="text-align: center;"><input class="button" type="submit" id="submitButton" value="Shrani in pošlji"></div>
        </div>
    </div>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
{{ Form::close() }}

<a class="close-reveal-modal" aria-label="Close">&#215;</a>