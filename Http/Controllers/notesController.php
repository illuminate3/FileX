<?php

class NotesController extends \BaseController {


    public function add() {
        return View::make('notes.add');
    }

    public function index() {
        return View::make('notes.index');
    }

    public function edit($id) {
        return View::make('notes.edit', compact('id'));
    }

}