<?php
    $user = Auth::user();
    $lastFolder = Folders::orderBy('created_at','desc')->first();
    $buildings = Buildings::all();
    $dirname = uniqid();
?>

<script language="JavaScript">
    $(document).ready(function() {
        $('#uploadArea, .foldersIndex, .createFolder, #fileName').hide();

        <?php if (isset($id)) { ?>
        showFolders(<?php echo $id; ?>);
        $('.createFolder').fadeIn();
        var building = <?php echo $id; ?>
        <?php } ?>

        $('select#building').change( function() {
            if (!($('select#building').val() == 0)) {
                showFolders($('select#building').val());
                $('.createFolder').fadeIn();
            }
        });

        //$('.alert-box > a.close').click($('.alert-box').fadeOut());

        $(document).on('click', '#createFolderLink', function() {
            var newFolder = $('#newFolder').val();
            @if (!isset($id)) var building = $('#building').val(); @endif
            if (newFolder == '') {
                alert ('Izbrati morate ime mape');
                $('#newFolder').focus();
            } else {
                $.ajax ({
                    url: '/folder/create',
                    type: 'post',
                    data: {
                        folder: newFolder,
                        building: building
                    },
                    dataType: "json",
                    success: function(data) {
                        //var dataArray = jQuery.parseJSON(data);
                        //$('#folderSelection').load('/folder/selection');
                        $('#newFolder').val('');
                        //$('#folder').val(dataArray['id']);
                        alert ("dataArray value: " + data['id']);
                        showFolders(@if (!isset($id)) $('#building').val() @else {{ $id }} @endif );
                    }
                })
            }
        });

        function showFolders(id) {
            $('.foldersIndex').fadeOut();
            $('.foldersIndex').load('/folder/index/' + id, function() {
                $('.foldersIndex').fadeIn();
            });
        }

    });

    $(document).on('click', '.folderData', function() {
        $('.folderDataSelected').toggleClass('folderDataSelected');
        $(this).addClass('folderDataSelected');
        $('input[name="selectedFolder"]').val($(this).attr('id'));
        showUploadArea();
        $('#submitButton').removeClass('disabled');
    });



    function showUploadArea() {
        if ( !($('select#building').val() == 0) && !($('input[name="selectedFolder"]').val == '') ) {
            $('#uploadArea, #fileName').fadeIn();
        } else {
            $('#uploadArea, #fileName').fadeOut();
        }
    }


</script>

<form id="documentCreate" method="post" action="/documents/create" enctype="multipart/form-data">

    <div class="row">
    <div class="large-12 columns">
        <h3>Dodajanje dokumentov @if (isset($id)) za objekt {{ Buildings::find($id)->pluck('name') }} @endif</h3>
    </div>

    <form id="documentCreate" method="POST" action="documents/create"></form>
    <div class="large-12 columns">

        {{ Form::label('building', 'Objekt') }}
        <select id="building" name="building">
            @if (!isset($id))
            <option value="0">Izberite objekt...</option>
                @if (! empty($buildings))
                    @foreach ($buildings as $building)
                        <option value="{{ $building->id }}">{{ $building->name }}, {{ $building->street }} {{ $building->houseNumber }}, {{ $building->city }} </option>
                    @endforeach
                @endif
            @else
                <option value="{{ $id }}" selected>{{ Buildings::find($id)->pluck('name') }}</option>
            @endif
        </select>

    </div>
    <div class="large-12 columns foldersIndex">

    </div>
    {{ Form::hidden('selectedFolder') }}
    {{ Form::hidden('tempFolder', $dirname) }}
    <div class="createFolder large-12 columns">
        <div class="row collapse" style="vertical-align: bottom;">
            <div class="large-8 columns">
                <input type="text" id="newFolder" name="newFolder">
            </div>
            <div class="large-4 columns"><a href=#" class="button postfix" id="createFolderLink">Kreirajte novo mapo</a></div>
        </div>
    </div>

    <div class="large-12 columns" id="fileName">
        {{ Form::label('name', 'Ime oz. kratek opis datoteke') }}
        {{ Form::text('name') }}
    </div>

    @if (! empty($buildings))
    <div class="row" id="uploadArea">
        <div class="large-12 columns" id="uploadDocuments">
            <div id="dropAreaDocuments" class="dropArea" style="height: 200px;">
                <span class="btn success fileinput-button button" style="margin-top:60px;">Naloži dokumente<input id="fileuploadDocuments" type="file" name="file" data-url="/upload/files"></span>
            </div>
            <ul id="filesD" style="margin-top:10px;">

            </ul>
        </div>
    </div>
    <div class="row">
        <div class="large-12 columns">
            <div style="text-align: center;"><input class="button disabled" type="submit" id="submitButton" value="Shrani in pošlji"></div>
        </div>
    </div>
    @endif



    <a class="close-reveal-modal" aria-label="Close" >&#215;</a>
</div>

</form>

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
                        $('#dropAreaDocuments').fadeIn();
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

            done:function(e, data) {
                $('#dropAreaDocuments').fadeOut();
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