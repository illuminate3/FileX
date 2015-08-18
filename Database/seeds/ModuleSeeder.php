<?php

namespace App\Modules\Records\Database\Seeds;

use Illuminate\Database\Seeder;
Use DB;
use Schema;


class ModuleSeeder extends Seeder {

	public function run()
	{

// Permissions -------------------------------------------------------------
		$permissions = array(
			[
				'name'				=> 'Manage Records',
				'slug'				=> 'manage_records',
				'description'		=> 'Give permission to user to manage the Records system'
			],
		 );

		if (Schema::hasTable('permissions'))
		{
			DB::table('permissions')->insert( $permissions );
		}

// Links -------------------------------------------------------------------
// Documents

		$link_names = array([
			'menu_id'				=> 1, // admin menu
			'position'				=> 3,
		]);

		if (Schema::hasTable('menulinks'))
		{
			DB::table('menulinks')->insert( $link_names );
		}

		$last_insert_id = DB::getPdo()->lastInsertId();
		$locale_id = DB::table('locales')
			->where('name', '=', 'English')
			->where('locale', '=', 'en', 'AND')
			->pluck('id');

		$ink_name_trans = array([
			'status'				=> 1,
			'title'					=> 'Documents',
			'url'					=> '/admin/documents',
			'menulink_id'			=> $last_insert_id,
			'locale_id'				=> $locale_id // English ID
		]);

		if (Schema::hasTable('menulinks'))
		{
			DB::table('menulink_translations')->insert( $ink_name_trans );
		}


	} // run

}
