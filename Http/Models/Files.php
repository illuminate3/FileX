<?php


class Files extends Eloquent
{
    protected $table = 'files';

    public static $imageUplaodRules = array(
        'file' => 'mimes:jpeg,bmp,png'
    );

    public static $messages = array (
        'required'  => 'Vpis v to polje je obvezen',
        'same'      => 'Zapisa v poljih se ne ujemata'
    );
}