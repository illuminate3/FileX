<?php

    if (Input::get('folder') !== NULL) {
        $folder = new Folders;
        $folder->name = Input::get('folder');
        $folder->owner = Auth::user()->id;
        $folder->group = Input::get('building');

        //Sanitize folder name
        $folderName = preg_replace('/[^a-z0-9\.]/', '', strtolower($folder->name));


        $building = Input::get('building');
        if ($building !== '0') {
            $folder->path = storage_path().'/documents/buildings/' . $building . '/' . $folderName . '/';
            if (File::exists($folder->path)) {
                $addString = 1;
                while (file_exists(storage_path().'/documents/buildings/' . $building . '/' . $folderName . $addString . '/')) {
                    $addString += 1;
                }
                $folder->path = storage_path().'/documents/buildings/' . $building . '/' . $folderName . $addString . '/';
            }
            File::makeDirectory($folder->path, $mode = 0755, true, true);
            $folder->save();
        } else {
            exit();
        }

        $return["id"] = json_encode($building);
        echo json_encode($return);
        //echo json_encode($building->id);

    }

    exit();

?>