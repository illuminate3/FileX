<?php
/**
 * Created by PhpStorm.
 * User: blaz
 * Date: 4. 08. 15
 * Time: 11.00
 */
$content = Content::find($id);

?>

<script language="javascript">
    $(document).ready(function(){
        $('textarea#content').ckeditor();
    });
</script>

<div class="row adminContent">
    <div class="large-12 columns">
        <h3>Urejanje vsebine</h3>
    </div>

    {{ Form::open(array('url' => 'content/'.$id, 'files' => false, 'method' => 'post', 'id' => 'contentEdit')) }}

    <div class="large-8 columns">
        {{ Form::label('name', 'Naziv') }}
        {{ Form::text('name', $content->name) }}
    </div>
    <div class="large-4 columns">
        {{ Form::label('owner', 'Avtor') }}
        {{ Form::text('owner', Auth::user()->name, array('disabled')) }}
    </div>

    <div class="large-12 columns">
        <textarea id="content" name="content" rows="10">{{ $content->content }}</textarea>
    </div>

    <div class="row">
        <div class="large-12 columns">
            <div style="text-align: center;"><input class="button" type="submit" id="submitButton" value="Shrani in pošlji"></div>
        </div>
    </div>

    {{ Form::close(); }}

    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>