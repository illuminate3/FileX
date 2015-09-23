<?php

namespace App\Modules\Filex\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class FilexDatabaseSeeder extends Seeder
{


	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('App\Modules\Filex\Database\Seeds\ModulePermissionsSeeder');
		$this->call('App\Modules\Filex\Database\Seeds\ModuleLinksSeeder');

	}


}
