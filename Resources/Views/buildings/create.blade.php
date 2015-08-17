<?php
    $users = User::all();

    //set temporary folder name
    $dirname = uniqid();
?>

    <script language="javascript">
        $(document).ready(function(){
            $( 'textarea#description' ).ckeditor();
        });
    </script>

{{ Form::open(array('url' => 'buildings/create', 'files' => true, 'method' => 'POST', 'id' => 'buildingCreate')) }}

    <div class="row">
        <div class="large-12 columns">
            <h2>Nov objekt</h2>

            <div class="row">
                <div class="large-4 columns">
                    {{ Form::label('buildingCode','Šifra objekta') }}
                    {{ Form::text('buildingCode') }}
                </div>
                <div class="large-8 columns">
                    {{ Form::label('name','Naziv') }}
                    {{ Form::text('name') }}
                </div>
            </div>

            <div class="row">
                <div class="large-5 columns">
                    {{ Form::label('street','Ulica') }}
                    {{ Form::text('street') }}
                </div>
                <div class="large-2 columns">
                    {{ Form::label('houseNumber', 'Hišna št.') }}
                    {{ Form::text('houseNumber') }}
                </div>
                <div class="large-2 columns">
                    {{ Form::label('zip', 'Poštna št.') }}
                    {{ Form::text('zip') }}
                </div>
                <div class="large-3 columns">
                    {{ Form::label('city', 'Pošta') }}
                    {{ Form::text('city') }}
                </div>
            </div>

            <div class="row">
                <div class="large-6 columns">
                    {{ Form::label('tel','Telefon') }}
                    {{ Form::text('tel') }}
                </div>
                <div class="large-6 columns">
                    {{ Form::label('fax','Faks') }}
                    {{ Form::text('fax') }}
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    {{ Form::label('email','E-mail') }}
                    {{ Form::text('email') }}
                </div>
                <div class="large-6 columns">
                    {{ Form::label('url','Url naslov') }}
                    {{ Form::text('url') }}
                </div>
            </div>
                <div class="row">
                    <div class="large-6 columns">
                        {{ Form::label('type','Tip objekta') }}
                        {{ Form::select('type',array('2'=>'Poslovni objekt', '1'=>'Stanovanjski objekt')) }}
                    </div>
                    <div class="large-6 columns">
                        {{ Form::label('owner','Odgovorna oseba') }}
                        <select name="owner">
                            <option>Izberite odgovorno osebo...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastName }} {{{ isset($user->companyName) ? '('.$user->companyName.')': '' }}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <textarea id="description" name="description" rows="10"></textarea>
                        {{ Form::hidden('tempFolder', $dirname) }}
                    </div>
                </div>
                <div class="row" style="padding-top: 10px;">
                    <div class="large-6 columns">
                        {{ Form::label('gmapccord1','Širina') }}
                        {{ Form::text('gmapcoord1') }}
                    </div>
                    <div class="large-6 columns">
                        {{ Form::label('gmapccord2','Dolžina') }}
                        {{ Form::text('gmapcoord2') }}
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns" id="uploadPictures">
                        <div id="dropAreaPictures" class="dropArea">
                            <span class="btn success fileinput-button button" style="margin-top:40px;"><span>Naloži slike / dokumente</span><input id="fileuploadPictures" type="file" name="file" data-url="/upload/files" multiple></span>
                        </div>
                        <ul id="filesP" style="margin-top:10px;">

                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <div style="text-align: center;"><input type="submit" class="button" value="shrani in pošlji"></div>
                    </div>
                </div>
        </div>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>

{{ Form::close() }}

    <script>
        $(function () {
            var ulp = $('#uploadPictures #filesP');
            $('#fileuploadPictures').fileupload({
                dropZone: $('#dropAreaPictures'),
                add: function (e, data) {

                    var tpl = $('<li class="working"><input type="text" value="0" data-width="38" data-height="38"'+
                    ' data-fgColor="rgb(0,140,186)" data-readOnly="1" data-bgColor="#c5c5c5" /><p></p><span></span></li>');

                    // Append the file name and file size
                    tpl.find('p').text(data.files[0].name)
                            .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

                    // Add the HTML to the UL element
                    data.context = tpl.appendTo(ulp);

                    // Initialize the knob plugin
                    tpl.find('input').knob();


                    // Listen for clicks on the cancel icon
                    tpl.find('span').click(function(){

                        if(tpl.hasClass('working')){
                            jqXHR.abort();
                        }

                        tpl.fadeOut(function(){
                            tpl.remove();
                        });

                    });


                    var jqXHR = data.submit();
                },

                progress: function(e, data){

                    // Calculate the completion percentage of the upload
                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    // Update the hidden input field and trigger a change
                    // so that the jQuery knob plugin knows to update the dial
                    data.context.find('input').val(progress).change();

                    if(progress == 100){
                        data.context.removeClass('working');
                    }
                },

                fail:function(e, data){
                    // Something has gone wrong!
                    data.context.addClass('error');

                    //Append error info
                    //var tpl = $(document).find('#filesP li p');
                   // tpl.append('<i>Napaka - ' + data + '</i>');

                },

                done: function(){
                    r = data.result;
                    var tpl = $(document).find('#filesP li p');
                    if (r.success) {

                    } else {
                        tpl.append('<i>Napaka - ' + r.reason + '</i>');
                    }

                }

            });

            // Prevent the default action when a file is dropped on the window
            $(document).on('drop dragover', function (e) {
                e.preventDefault();
            });

            // Helper function that formats the file sizes
            function formatFileSize(bytes) {
                if (typeof bytes !== 'number') {
                    return '';
                }

                if (bytes >= 1000000000) {
                    return (bytes / 1000000000).toFixed(2) + ' GB';
                }

                if (bytes >= 1000000) {
                    return (bytes / 1000000).toFixed(2) + ' MB';
                }

                return (bytes / 1000).toFixed(2) + ' KB';
            }

        });
    </script>
