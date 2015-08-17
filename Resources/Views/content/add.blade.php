<?php
/**
 * Created by PhpStorm.
 * User: blaz
 * Date: 24. 07. 15
 * Time: 12.59
 */
$menus = Menu::all();
?>
<script language="javascript">
    $(document).ready(function(){

        $('#editor, #name, label[for="name"]').hide();
        $('textarea#content').ckeditor();
        $(':submit').attr('disabled', true);

        $('select#group').change( function() {
            if ($('#group').val()!=0) {
                $('#editor, #name, label[for="name"]').show();
                $(':submit').attr('disabled', false);
            } else {
                $('#editor, #name, label[for="name"]').hide();
                $(':submit').attr('disabled', true);
            }
        });
    });
</script>

<div class="row">
    <div class="large-12 columns">
        <div class="large-12 columns">
            <h3>Dodajanje vsebine</h3>
        </div>
        {{ Form::open(array('url' => 'content/add/', 'files' => false, 'method' => 'POST', 'id' => 'contentAdd')) }}

        <div class="large-6 columns">
            {{ Form::label('group', 'Kategorija') }}
            <select name="group" id="group">
                <option value="0">Izberite kategorijo</option>
                @foreach ($menus as $menu)
                    @if (Content::where('group',$menu->id)->pluck('content') == '')
                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                    @else
                        <option disabled>*** {{ $menu->name }} ***</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="large-6 columns">
            <div class="panel callout radius">
                <p>Izberete lahko le kategorije, ki še nimajo vsebine. Če kategorije ni mogoče izbrati, pomeni, da že ima vsebino, ki jo lahko urejate iz prejšnjega seznama.</p>
            </div>
        </div>

        <div class="large-12 columns">
            {{ Form::label('name', 'Naziv') }}
            {{ Form::text('name') }}
        </div>


        <div class="large-12 columns" id="editor">
            <label>Vsebina</label>
            <textarea id="content" name="content" rows="10"></textarea>
        </div>

        <div class="row">
            <div class="large-12 columns">
                <div style="text-align: center;"><input class="button" type="submit" id="submitButton" value="Shrani in pošlji"></div>
            </div>
        </div>

        {{ Form::close() }}
    </div>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
