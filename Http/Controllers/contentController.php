<?php
/**
 * Created by PhpStorm.
 * User: blaz
 * Date: 24. 07. 15
 * Time: 12.09
 */

class contentController extends \BaseController {


    public function index() {
        return View::make('content.index');
    }


    public function edit($id) {
        return View::make('content.edit',compact('id'));
    }


    public function save($id) {
        $content = Content::find($id);
        if (!empty ($content)) {
            $content->name = Input::get('name');
            $content->owner = Auth::user()->id;
            $content->content = Input::get('content');
            $content->save();
            return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
        } else {
            return Redirect::back()->withError('message','Prišlo je do napake. spremembe niso bile shranjene.');
        }

    }


    public function add() {
        return View::make('content.add');
    }


    public function visibility($id) {
        $content = Content::find($id);
        if (!empty ($content)) {

            $menu = Menu::find($content->group);

            if ($content->visibility == 0) {
                $content->visibility = 1;
                $menu->visibility = 1;
            } else {
                $content->visibility = 0;
                $menu->visibility = 0;
            }

            $content->save();
            $menu->save();

            return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
        } else {
            return Redirect::back()->withError('message','Prišlo je do napake. spremembe niso bile shranjene.');
        }
    }

    public function destroy($id) {
        $content = Content::find($id);
        if (!empty ($content)) {
            $menu = Menu::find($content->group);
            $content->delete();
            $menu->delete();
            return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
        } else {
            return Redirect::back()->withError('message','Prišlo je do napake. spremembe niso bile shranjene.');
        }
    }


}