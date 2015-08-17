<?php

class foldersController extends \BaseController {

    public function selection()
    {
        return View::make('folders.selection');
    }


    public function create()
    {
        return View::make('folders.create');
    }


    public function index($id)
    {
        return View::make('folders.index', compact('id'));
    }

}