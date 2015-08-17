<?php
    $buildings = Buildings::all();
?>

<script language="javascript">
    $(document).ready(function(){
        $( 'textarea#content' ).ckeditor();
    });
</script>

{{ Form::open(array('url' => 'notes/add', 'files' => false, 'method' => 'post', 'id' => 'noteAdd')) }}
<div class="row">
    <div class="row">
        <div class="large-12 columns">
            <h3>Novo obvestilo</h3>
        </div>
    </div>
    <div class="row">
        <div class="large-7 columns">
            {{ Form::label('name','Naziv') }}
            {{ Form::text('name') }}
        </div>
        <div class="large-5 columns">
            {{ Form::label('building','Objekt') }}
            <select name="building" id="building">
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}">{{ $building->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <label>Vsebina</label>
            <textarea id="content" name="content" rows="10"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns" style="height: 15px;"></div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            {{ Form::checkbox('published', 'yes') }} Objavljeno <br />
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