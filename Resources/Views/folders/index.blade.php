<?php
/**
 * Created by PhpStorm.
 * User: blaz
 * Date: 8. 07. 15
 * Time: 17.23
 */

    $folders = Folders::where('group',$id)->orderBy('created_at', 'DESC')->get();
?>

    @if (count($folders))
        <div class="large-12 columns foldersIndexInnerContainer">
        @foreach ($folders as $folder)
            <div class="large-3 columns left folderData" id="{{ $folder->id }}">
                <div class="folderIconContainer"></div>
                <div class="folderNameContainer">{{ $folder->name }}</div>
            </div>
        @endforeach
        </div>
    @else
        <div data-alert class="alert-box info radius">Za ta objekt še ni ustvarjenih map.<a href="#" class="close">&times;</a></div>
    @endif