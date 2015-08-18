<?php
    $building = Buildings::find($id);
    $dirname = uniqid();
?>

    {{ HTML::script('/js/load-image.all.min.js') }}
    {{ HTML::script('/js/canvas-to-blob.min.js') }}
    {{ HTML::script('/js/jquery.iframe-transport.js') }}
    {{ HTML::script('/js/jquery.fileupload.js') }}
    {{ HTML::script('/js/jquery.fileupload-process.js') }}
    {{ HTML::script('/js/jquery.fileupload-image.js') }}
    {{ HTML::script('/js/jquery.fileupload-audio.js') }}
    {{ HTML::script('/js/jquery.fileupload-video.js') }}
    {{ HTML::script('/js/jquery.fileupload-validate.js') }}
    {{ HTML::script('/js/jquery.knob.js') }}

    <div class="row">
        <div class="large-12 columns">
            <h3>Nov dokument za objekt {{ $building->name }}</h3>
        </div>
        {{ Form::open(array('url' => 'documents/add/'. $building->id, 'files' => true, 'method' => 'POST', 'id' => 'documentAdd')) }}

        <div class="large-12 columns">
            {{ Form::label('name','Opis dokumenta:') }}
            {{ Form::text('name') }}
            {{ Form::hidden('folder', $dirname) }}
        </div>

        <div class="row">
            <div class="large-12 columns" id="uploadDocuments">
                <div id="dropAreaDocuments" class="dropArea">
                    <span class="btn success fileinput-button button" style="margin-top:40px;">Naloži dokumente<input id="fileuploadDocuments" type="file" name="file" data-url="/upload/files" multiple></span>
                </div>
                <ul id="filesD" style="margin-top:10px;">

                </ul>
            </div>
        </div>

        <div class="row">
            <div class="large-12 columns">
                <div style="text-align: center;"><input class="button" type="submit" id="submitButton" value="Shrani in pošlji"></div>
            </div>
        </div>
    </div>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>

    <script>
        $(function () {
            var ulp = $('#uploadDocuments #filesD');
            $('#fileuploadDocuments').fileupload({
                dropZone: $('#dropAreaDocuments'),
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