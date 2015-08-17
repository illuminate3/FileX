<?php

class filesController extends \BaseController {


    public function destroy($id) {

        Files::find($id)->delete();

    }


    public function update($array) {

    }


    public function edit($id) {
        return View::make('files.edit', compact('id'));
    }


}

?>