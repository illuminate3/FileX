<?php
/**
 * Created by PhpStorm.
 * User: blaz
 * Date: 24. 07. 15
 * Time: 12.59
 */
$contents = Content::all();
$num = 1;
?>

@extends ('master');

@section ('content');

    <div class="row contentsIndex">
        <div class="">
            @if (isset($message))
                <div class="large-12 columns alert-box success" style="margin-top: 20px; margin-bottom: 0px;">
                    {{ $message; }}
                </div>
            @endif
        </div>

        <div class="large-12 columns">
            <h3>Pregled vsebine</h3>
        </div>

        <div class="right large-12 columns" style="text-align: right;"><a id="modalLink" data-bid="/content/add" class="tiny button"><i class="fi-plus"></i> Nova vsebina</a></div>

        @foreach ($contents as $content)
            <?php $timestamp = strtotime($content->created_at); $datetime = date("d. m. Y (H:i:s)", $timestamp); ?>
            <div class="large-12 columns contentItem @if ($content->visibility == 0) notVisible @endif">
                <a id="modalLink" href="" data-bid="/content/{{ $content->id }}">{{ $content->name }}</a>
                <br />
                <span class="slugContainer">@if ($content->owner!=='') <i class="fi-user"></i> {{ User::find($content->owner)->name }} {{ User::find($content->owner)->lastName }} @endif</span>
                <span class="right">
                        <span class="contentItemPublished">
                           Objavljeno: {{ $datetime }}
                        </span>
                        <span class="menuItemVisibility">
                            <a id="contentItemVisibility" data-id="{{ $content->id }}"><i class="fi-eye"></i></a>
                        </span>
                        <span class="menuItemDelete">
                            <a id="contentItemDelete" data-id="{{ $content->id }}"><i class="fi-trash"></i></a>
                        </span>
            </div>
        @endforeach

    </div>

    <script>
        $(function() {
            $('a#contentItemDelete').click(function() {
                var id = $(this).data('id');
                if (confirm ('Zbrišem izbrani element?')) {
                    $.ajax({
                        context: document.body,
                        url: '/content/destroy/' + id
                    }).done(function () {
                        location.reload();
                    });
                }
            });
            $('a#contentItemVisibility').click(function() {
                var id = $(this).data('id');
                $.ajax({
                    context: document.body,
                    url: '/content/visibility/' + id
                }).done(function () {
                    location.reload();
                });
            })
            $('.menuIndex #submitButton').click(function () {
                $.ajax({
                    data: $( "#menuAdd" ).serialize(),
                    type: 'POST',
                    url: '/menu/create'
                }).done(function () {
                    location.reload();
                });
            })
        });
    </script>

@stop
