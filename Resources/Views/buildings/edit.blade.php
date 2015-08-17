<?php
$building = Buildings::find($id);
$managers = Managers::where('buildingCode', $building->id)->first();
$users = User::where('level', '>=', '20')->get();
$images = Files::where('group', $id)->get();
$documents = Documents::where('group', $id)->get();

$dirname = uniqid();
?>

<script language="javascript">
    $(document).ready(function(){
        $('.slickSlider').slick({
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            centerMode: false,
            variableWidth: true
        });

        $(".imageHover").hover(
                function() {
                    $(this).children("img").fadeTo(200, 0.35).end().children(".hover").show();
                },
                function() {
                    $(this).children("img").fadeTo(200, 1).end().children(".hover").hide();
                });

        $("a#image").click(function(e) {
            e.preventDefault();
            var $this = $(this),
                    id = $this.data('id'),
                    bid = $this.data('bid');
            $.ajax({
                url: "/files/destroy/" + bid,
                context: document.body
            }).done(function () {
                $('#Modal').load('/buildings/edit/<?php echo $id; ?>' );
            });
        });

        $( 'textarea#description' ).ckeditor();
    });
</script>

<div class="row adminContent">
   <div class="large-12 columns">
        <h2>{{ $building->name }}</h2>

        {{ Form::open(array('url' => 'buildings/edit/'.$building->id, 'files' => true, 'method' => 'post', 'id' => 'buildingEdit')) }}

       <div class="row">
           <div class="large-4 columns">
               {{ Form::label('buildingCode','Šifra objekta') }}
               {{ Form::text('buildingCode', $building->buildingCode) }}
           </div>
           <div class="large-8 columns">
               {{ Form::label('name','Naziv') }}
               {{ Form::text('name', $building->name) }}
           </div>
       </div>

       <div class="row">
           <div class="large-5 columns">
               {{ Form::label('street','Ulica') }}
               {{ Form::text('street', $building->street) }}
           </div>
           <div class="large-2 columns">
               {{ Form::label('houseNumber', 'Hišna št.') }}
               {{ Form::text('houseNumber', $building->houseNumber) }}
           </div>
           <div class="large-2 columns">
               {{ Form::label('zip', 'Poštna št.') }}
               {{ Form::text('zip', $building->zip) }}
           </div>
           <div class="large-3 columns">
               {{ Form::label('city', 'Pošta') }}
               {{ Form::text('city', $building->city) }}
           </div>
       </div>

       <div class="row">
           <div class="large-6 columns">
               {{ Form::label('tel','Telefon') }}
               {{ Form::text('tel', $building->tel) }}
           </div>
           <div class="large-6 columns">
               {{ Form::label('fax','Faks') }}
               {{ Form::text('fax', $building->fax) }}
           </div>
       </div>

       <div class="row">
           <div class="large-6 columns">
               {{ Form::label('email','E-mail') }}
               {{ Form::text('email', $building->email) }}
           </div>
           <div class="large-6 columns">
               {{ Form::label('url','Url naslov') }}
               {{ Form::text('url', $building->url) }}
           </div>
       </div>

       <div class="row">
           <div class="large-6 columns">
               {{ Form::label('type','Tip objekta') }}
               <select name="type" id="type">
                   @if ($building->type == 1)
                       <option value="1" selected>Stanovanjski objekt</option>
                       <option value="2">Poslovni objekt</option>
                   @else
                       <option value="1">Stanovanjski objekt</option>
                       <option value="2" selected>Poslovni objekt</option>
                   @endif
               </select>
           </div>
           <div class="large-6 columns">
               {{ Form::label('owner','Odgovorna oseba') }}
               <select name="owner">
                   @foreach ($users as $user)
                       @if ((count($managers)) && $user->partnerCode == $managers->partnerCode) <option selected value="{{ $user->id }}">{{ $user->name }} {{ $user->lastName }} {{{ isset($user->companyName) ? '('.$user->companyName.')': '' }}}</option>
                       @else <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastName }} {{{ isset($user->companyName) ? '('.$user->companyName.')': '' }}}</option>
                       @endif
                   @endforeach
               </select>
           </div>
       </div>

       <div class="row">
            <div class="large-12 columns">
                <label>Opis</label>
                <textarea id="description" name="description" rows="10">{{ $building->description }}</textarea>
            </div>
       </div>

       <div class="row" style="padding-top: 20px;">
            <fieldset>
                <label>Koordinate za Google maps</label>
                <div class="large-6 columns">
                    {{ Form::label('gmaps-1','Širina') }}
                    {{ Form::text('gmaps-1', $building->mapcoord1) }}
                </div>
                <div class="large-6 columns">
                    {{ Form::label('gmaps-2','Dolžina') }}
                    {{ Form::text('gmaps-2', $building->mapcoord2) }}
                </div>
            </fieldset>
       </div>

       <div class="row">
           <div class="large-12 columns">
               {{ Form::hidden('tempFolder', $dirname) }}
               <div style="text-align: center;"><input class="button" type="submit" id="submitButton" value="Shrani in pošlji"></div>
           </div>
        </div>
       <div class="row">
           <div class="large-12 columns" id="uploadPictures">
               <div id="dropAreaPictures" class="dropArea">
                   <a class="btn success fileinput-button button" style="margin-top:40px;">Naloži datoteke<input id="fileuploadPictures" type="file" name="file" data-url="/upload/files" multiple></a>
               </div>
               <ul id="filesP" style="margin-top:10px;">

               </ul>
           </div>
       </div>
       <div class="row">
           <ul class="small-bloc-grid-1 medium-block-grid-3 large-block-grid-5">
               @foreach ($images as $image)
                   <li>
                       <div class="imageHover">
                           <div class="hover">
                               <a id="image" data-bid="{{ $image->id }}">
                                   <i class="fi-trash"></i>
                               </a>
                           </div>
                           <img src="/img/buildings/{{ $building->id }}/{{ $image->fileName }}_thumbnail.{{ $image->extension }}">
                       </div>
                   </li>
               @endforeach
           </ul>
       </div>
        </form>
    </div>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


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

