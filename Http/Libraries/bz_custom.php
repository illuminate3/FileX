<?php
/**
 * Created by PhpStorm.
 * User: blaz
 * Date: 22. 04. 15
 * Time: 12.46
 */

class bz_customUpload {

    static function bz_fileUpload($groupId, $tempFolder, $folder = NULL, $name = NULL) {

        if ($name == NULL) {
            $name = "";
        }

        //Set arrays for allowed file extensions
        $imagesArray = array('png', 'jpg', 'gif', 'bmp');
        $documentsArray = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt');

        //Create Building images folder inside public/img
        //and documents folder inside app/storage/documents/buildings/id
        $imageDestinationFolder = public_path().'/img/buildings/'.$groupId;
        if ($folder == NULL) {
            $documentsDestinationFolder = storage_path().'/documents/buildings/'.$groupId;
        } else {
            $documentsDestinationFolder = $folder;
        }


        if (!File::exists($imageDestinationFolder)) {
            File::makeDirectory($imageDestinationFolder, $mode = 0755, true, true);
        }

        if (!File::exists($documentsDestinationFolder)) {
            File::makeDirectory($documentsDestinationFolder, $mode = 0755, true, true);
        }

        $uploadFolder = public_path().'/uploads/'.$tempFolder;

        //Set order to last / the biggest number from same group
        $filesOrder = Files::orderBy('order', 'DESC')->where('group', $groupId)->take(1)->pluck('order');

        if (! $filesOrder = NULL) {
            $order = $filesOrder + 1;
        } else {
            $order = 1;
        }
        $documentsOrder = Documents::where('group','=',$groupId)->orderBy('order','desc')->first();

        if (! $documentsOrder = NULL) {
            $order = $documentsOrder + 1;
        } else {
            $order = 1;
        }

        //Browse TEMP folder for files; detect file types and move them to appropriate folders
        if (!(count(glob($uploadFolder.'/*')) === 0 )) {
            //There are some files in there so move them to correct folder
            $files = scandir($uploadFolder);
            foreach ($files as $file) {
                //Skip . and .. in folder
                if (in_array($file, array(".",".."))) continue;
                $extension = File::extension($file);
                //Check if file extension is in allowed types arrays
                if (in_array($extension, $imagesArray)) {
                    //Move file to image folder
                    rename($uploadFolder.'/'.$file, $imageDestinationFolder.'/'.$file);

                    //Remove extension from file name
                    $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);

                    //load  & resize image
                    $resizer = ImageResizer::load($imageDestinationFolder.'/'.$file);
                    $resizer->autocrop(16, 9)->resizeWidth(970)->export($imageDestinationFolder, $filename.'_full');
                    $resizer = ImageResizer::load($imageDestinationFolder.'/'.$file);
                    $resizer->autocrop(4, 3)->resizeWidth(200)->export($imageDestinationFolder, $filename.'_mid');
                    $resizer->autocrop(4, 3)->resizeWidth(100)->export($imageDestinationFolder, $filename.'_thumbnail');

                    //Make new entry in files DB
                    $filesDb = new Files;
                    $filesDb->owner = Auth::user()->getId();
                    $filesDb->name = $name;
                    $filesDb->fileName = $filename;
                    $filesDb->path = $imageDestinationFolder;
                    $filesDb->group = $groupId;
                    $filesDb->mime = 'mime';
                    $filesDb->extension = $extension;
                    $filesDb->order = $order;
                    $filesDb->save();
                } else
                    if (in_array($extension, $documentsArray)) {
                        //Move file to documents folder
                        rename($uploadFolder.'/'.$file, $documentsDestinationFolder.$file);
                        //Make new entry in documents DB
                        $documentsDb = new Documents;
                        $documentsDb->owner = Auth::user()->getId();
                        $documentsDb->name = $name;
                        $documentsDb->fileName = $file;
                        $documentsDb->path = $documentsDestinationFolder;
                        $documentsDb->group = $groupId;
                        $documentsDb->mime = 'mime';
                        $documentsDb->extension = $extension;
                        $documentsDb->order = $order;
                        $documentsDb->save();
                    } else {
                        File::delete($file);
                    }


            }
            //Delete temporary folder inside public/uploads/
            File::deleteDirectory($uploadFolder);
        }
    }


}