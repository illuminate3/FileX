<?php

    class userTableSeeder extends Seeder
    {
        public $folder;
        public $path;

        public function run()
        {
            $this->folder = str_random(15) .''. time();
            $this->path = storage_path().'/user-files/'.$this->folder;
            File::makeDirectory($this->path, $mode = 0757, true, true);
            DB::table('users')->delete();
            User::create(array(
                'partnerCode' => '1234567890',
                'companyName' => 'Huda Firma d.o.o.',
                'name' => 'Franc',
                'lastName' => 'Novak',
                'email' => 'franc.novak@gmail.com',
                'vat' => 'SI561234567890',
                'password' => Hash::make('test'),
                'level' => 10,
                'folder' =>  $this->folder,
            ));
            $this->folder = str_random(15) .''. time();
            $this->path = storage_path().'/user-files/'.$this->folder;
            File::makeDirectory($this->path, $mode = 0757, true, true);
            User::create(array(
                'partnerCode' => '0000',
                'companyName' => 'Iskra d.d.',
                'name' => 'admin',
                'lastName' => '',
                'email' => 'admin@admin.com',
                'vat' => 'SI561234567890',
                'password' => Hash::make('admin'),
                'level' => 30,
                'folder' =>  $this->folder,
            ));
        }
    }


?>
