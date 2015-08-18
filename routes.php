<?php


    Route::get('/', array('as' => 'home', 'uses' => 'pagesController@index'));


    //Admin pages

    //Route::get('admin/user_management', 'adminPagesController@userManagement');


    /**
     * Users
     **/

    Route::get('users', array('before' => 'auth', 'uses' =>  'userController@index'));
    Route::post('users/index', 'userController@index');
    Route::get('users/create', 'userController@create');
    Route::post('users/create', function()
        {
            $folder = str_random(15) .''. time();
            $path = storage_path().'/user-files/'.$folder;
            File::makeDirectory($path, $mode = 0755, true, true);
            $user = new User;
            $user->partnerCode  = Input::get('partnerCode');
            $user->companyName  = Input::get('companyName');
            $user->vat          = Input::get('vat');
            $user->street       = Input::get('street');
            $user->houseNumber  = Input::get('houseNumber');
            $user->zip          = Input::get('zip');
            $user->city         = Input::get('city');
            $user->name         = Input::get('name');
            $user->lastName     = Input::get('lastName');
            $user->email        = Input::get('email');
            $user->tel          = Input::get('tel');
            $user->level        = Input::get('level');
            $user->group        = Input::get('building');
            $user->folder       = $folder;
            $user->save();
            return Redirect::to('/users');
        }
    );

    Route::pattern('id', '[0-9]+');
    Route::get('users/edit/{id}', array('before' => 'auth', 'uses' => 'userController@edit'));
    Route::post('users/edit/{id}', function($id)
        {
            $user = User::find($id);
            $user->companyName  = Input::get('companyName');
            $user->vat          = Input::get('vat');
            $user->street       = Input::get('street');
            $user->houseNumber  = Input::get('houseNumber');
            $user->zip          = Input::get('zip');
            $user->city         = Input::get('city');
            $user->name         = Input::get('name');
            $user->lastName     = Input::get('lastName');
            $user->email        = Input::get('email');
            $user->tel          = Input::get('tel');
            $level              = Input::get('level');
            $buildingCode       = Input::get('building');
            //If user level has changed, check if user needs to be added or removed from managers table
            if ($user->level !== $level) {
                //Sanitize old and possible faulty entries: delete manager entries for this user and building in managers table
                Managers::where('partnerCode',$user->partnerCode)->delete();
                if ($level == 20 && $buildingCode !== '0') {
                    //User has been assigned as building manager
                    //Insert entry
                    $manager = new Managers;
                    $manager->partnerCode = $user->partnerCode;
                    $manager->buildingCode = $buildingCode;
                    $manager->save();
                }
            }
            $user->group        = $buildingCode;
            $user->level        = $level;
            $user->update();

            return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
        }
    );

    Route::get('users/destroy/{id}', 'userController@destroy');


    /**
     * User Pages
    **/

    Route::get('users/documents/{id}', array('before' => 'auth.byId', 'uses' => 'userController@showDocuments'));



    /**
     * Buildings
    **/

    Route::get('buildings', 'buildingsController@index');
    Route::get('buildings/index', 'buildingsController@index');
    Route::get('buildings/create', 'buildingsController@create');

    Route::post('buildings/create', function()
    {
        //Set arrays for allowed file types
        $imagesArray = array('png', 'jpg', 'gif', 'bmp');
        $documentsArray = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt');

        //Save data to DB and move uploaded files

        $building = new Buildings;
        $buildingCode = Input::get('buildingCode');
        $building->buildingCode     = $buildingCode;
        $building->name             = Input::get('name');
        $building->street           = Input::get('street');
        $building->houseNumber      = Input::get('houseNumber');
        $building->zip              = Input::get('zip');
        $building->city             = Input::get('city');
        $building->tel              = Input::get('tel');
        $building->fax              = Input::get('fax');
        $building->email            = Input::get('email');
        $building->url              = Input::get('url');
        $building->type             = Input::get('type');
        $owner                      = Input::get('owner');

        // Check if manager is selected and create entry in managers table

        if ($owner !== '') {
            $user = User::find($owner);

            //Delete previous and possible faulty entries for this pair (partnerCode - buildingCode)

            Managers::where('partnerCode', $user->id)->where('buildingCode', $building->id)->delete();
            $manager = new Managers;
            $manager->partnerCode = $user->id;
            $manager->buildingCode = $building->id;
            $manager->save();

            //set user level 20 to selected maanger

            if ($user->level < 20) {
                $user->level = 20;
                $user->update();
            }
        }

        $building->description      = Input::get('description');
        $building->mapcoord1        = Input::get('gmapcoord1');
        $building->mapcoord2        = Input::get('gmapcoord2');
        $building->slug = preg_replace('/\s+/', '_', $building->name);

        $building->save();

        //Call to custom upload function:

        $fileUpload = new bz_customUpload();
        $fileUpload->bz_fileUpload($building->id, Input::get('tempFolder'), NULL,  NULL);

        return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
    });

    Route::get('buildings/edit/{id}', 'buildingsController@edit');
    Route::post('buildings/edit/{id}', function($id) {
        $building = Buildings::find($id);
        $buildingCode = Input::get('buildingCode');

        $building->buildingCode = $buildingCode;
        $building->name         = Input::get('name');
        $building->street       = Input::get('street');
        $building->houseNumber  = Input::get('houseNumber');
        $building->zip          = Input::get('zip');
        $building->city         = Input::get('city');
        $building->tel          = Input::get('tel');
        $building->fax          = Input::get('fax');
        $building->url          = Input::get('url');
        $building->email        = Input::get('email');
        $owner                  = Input::get('owner');

        // If building manager has been changed, new one needs to be assigned
        // Managers table needs to be updated accordingly
        // $partnerCode = User::where('id',$owner)->pluck('partnerCode');

        // delete currently assigned manager
        Managers::where('buildingCode', $building->id)->delete();

        // add new manager record
        $manager = new Managers;
        $manager->partnerCode = $owner;
        $manager->buildingCode = $building->id;
        $manager->save();

        $building->description = Input::get('description');
        $building->type = Input::get('type');
        $building->mapcoord1 = Input::get('gmaps-1');
        $building->mapcoord2 = Input::get ('gmaps-2');
        $building->save();

        //Call to custom upload function:

        $fileUpload = new bz_customUpload();
        $fileUpload->bz_fileUpload($building->id, Input::get('tempFolder'), NULL, NULL);

        return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
    });


    //Temporary upload function
    Route::post('upload/files', function () {

        $file = Input::file('file');

        if ($file) {
            //Check if right file type
            $allowed = array('png', 'jpg', 'gif', 'bmp', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
            if(in_array(strtolower($file->getClientOriginalExtension()), $allowed)){
                //Does TEMP folder exist?
                $temp = Input::get('tempFolder');
                if ($temp == '') { $temp = 'Empty_folder'; }
                $destinationPath = public_path().'/uploads/' . $temp;
                if (!File::exists($destinationPath)) {
                    //If NOT, create it
                    File::makeDirectory($destinationPath, $mode = 0755, true, true);
                }

                //delete all temp folders older than 24hours
                if (file_exists(public_path().'/uploads')) {
                    foreach (new DirectoryIterator(public_path().'/uploads') as $fileInfo) {
                        if ($fileInfo->isDot()) {
                            continue;
                        }
                        if (time() - $fileInfo->getCTime() >= 1*24*60*60) { //1 day
                            unlink($fileInfo->getRealPath());
                        }
                    }
                }

            } else {
                //Todo: return json response for failed file upload -> unsupported file type
                // return Response::json('Ta tip datoteke ni dovoljen', 404);
                //return Response::json(array('success' => false, 'reason' => 'Ta tip datoteke ni dovoljen'));
                //echo 'Ta tip datoteke ni dovoljen';
                //break;

            }

            //Sanitise filename
            $filename = preg_replace('/[^a-z0-9\.]/', '_', strtolower($file->getClientOriginalName()));

            //Move temp file
            $upload_success = $file->move($destinationPath, $filename);

            if ($upload_success) {

                return Response::json('success', 200);
            } else {
                //Todo: return response for failed file upload
               // return Response::json(array('success' => false, 'reason' => 'Datoteka je prevelika'));
            }
        } else {
            //Todo: return json response for failed file upload -> no file selected
            //return Response::json('error', 415);
        }
    });


    /**
     * Files
    **/

    Route::get('files/destroy/{id}', 'filesController@destroy');
    Route::post('files/update/{id}', function() {
        //Unserialize passed array
        //Store values to db
        $array = json_decode(Input::get('array'));
        if (! empty($array)) {
            $counter = 1;
            foreach ($array as $id) {
                $file = Files::find($id);
                $file->order = $counter;
                $file->save();
                echo "id: ".$id . " => " . $counter . "<br />";
                $counter=$counter+1;
            }
        } else {
            echo "DOohhH! empty array";
        }
    });
    Route::get('files/edit/{id}', 'filesController@edit');
    Route::post('files/edit/{id}', function($id) {
        $file = Files::find($id);
        if (! empty($file)) {
            $file->name = Input::get('name');
            $file->save();
        }
        return Redirect::to('upravljanje/'.Input::get('buildingId'));
    });

    /**
     * Notes
     **/

    Route::get('notes/', 'notesController@index');
    Route::get('notes/add', 'notesController@add');
    Route::post('notes/add', function(){
        $note = new Notes;
        $note->name = Input::get('name');
        $note->content = Input::get('content');
        $note->owner = Auth::user()->id;
        $note->group = Input::get('building');
        if (Input::get('published') == "yes") {
            $note->visibility = 1;
        } else {
            $note->visibility = 0;
        }
        $note->save();
        return Redirect::back()->with('message','Obvestilo je bilo uspešno ustvarjeno');
    });
    Route::get('notes/edit/{id}', 'notesController@edit');
    Route::post('notes/edit/{id}', function($id) {
        $note = Notes::find($id);
        $note->name = Input::get('name');
        $note->content = Input::get('content');
        $note->owner = Auth::user()->id;
        $note->group = Input::get('building');
        if (Input::get('published') == "yes") {
            $note->visibility = 1;
        } else {
            $note->visibility = 0;
        }
        $note->save();
        return Redirect::back()->with('message','Obvestilo je bilo uspešno shranjeno');
    });



    /**
     * Upravljanje objektov
    **/

    Route::get('upravljanje', 'pagesController@upravljanje');
    Route::get('upravljanje/{id}', array('before' => 'auth', function($id) {
        return View::make('pages.upravljanjeShow', compact('id'));
        })
    );

    /**
     * Upravljanje folderjev
    **/

        Route::get('folder/selection','foldersController@selection');
        Route::post('folder/create', 'foldersController@create');
        Route::get('folder/index/{id}', 'foldersController@index');

    /**
     * Upravljanje vsebine
     */

        Route::get('content','contentController@index');
        Route::get('content/add', 'contentController@add');
        Route::post('content/add', function() {
            $content = new Pages;
            $content->name = Input::get('name');
            $content->group = Input::get('group');
            $content->content = Input::get('content');
            $content->owner = Auth::user()->id;
            $content->visibility = 1;
            $content->save();
        });
        Route::get('content/{id}', 'contentController@edit');
        Route::post('content/{id}','contentController@save');
        Route::get('content/destroy/{id}', 'contentController@destroy');
        Route::get('content/visibility/{id}', 'contentController@visibility');

    /**
     * Upravljanje navigacije
     */

        Route::get('menu','menuController@index');
        Route::get('menu/{id}', 'menuController@edit');
        Route::get('menu/add', 'menuController@add');
        Route::post('menu/create', function() {
            if (Input::get('name')!== '') {
                $menu = new Menu;
                $menu->name = ucfirst(Input::get('name'));
                $menu->level = Input::get('level');
                $menu->owner = Auth::user()->id;
                $menu->link = Input::get('link');
                $menu->save();
                //Create entry in content table
                $content = new Content;
                $content->name = $menu->name;
                $content->group = $menu->id;
                $content->content = '';
                $content->owner = Auth::user()->id;
                $content->visibility = 0;
                $content->save();
                //return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
                Session::flash('message', 'Podatki so bili uspešno shranjeni.');
            }
            else {
                //return Redirect::back()->withErrors(['message', 'Niste vnesli imena elementa!']);
                Session::flash('error', 'Napaka! Niste vnesli zahtevanih podatkov.');
            }
        });
        Route::post('menu/update', function() {
            $i = 0;
            foreach (Input::get('sort') as $value) {
                Menu::where('id', $value)->update(array('order' => $i));
                $i++;
            }
        });
        Route::get('menu/edit/{id}', 'menuController@edit');
        Route::post('menu/edit/{id}', function($id) {
            $menu = Menu::find($id);
            $menu->name = Input::get('name');
            $menu->level = Input::get('level');
            $menu->link = Input::get('link');
            $menu->save();
            return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
        });
        Route::get('menu/destroy/{id}', 'menuController@destroy');
        Route::get('menu/visibility/{id}', 'menuController@changeVisibility');


        // Catch slug for frontend content
        //First catch reserved names
        Route::get('upravljanje', 'pagesController@upravljanje');
        Route::get('{slug}', function($slug) {
            $page = Content::where('group','=',(Menu::where('slug','=',$slug)->pluck('id')))->first();

            if (!is_null($page)) { return View::make('pages.show', compact('page')); }
            else {
                return Redirect::to('/');
            }
        });
