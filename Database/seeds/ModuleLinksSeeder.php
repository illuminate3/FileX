<?php

namespace App\Modules\FileX\Database\Seeds;

use Illuminate\Database\Seeder;
Use DB;
use Schema;


class ModuleSeeder extends Seeder
{

		$cms_id = DB::table('menus')
			->where('name', '=', 'cms')
			->pluck('id');

		if ($cms_id == null) {
			$cms_id = 1;
		}
	public function run()
	{


// Links -------------------------------------------------------------------
// Documents

		$link_names = array([
			'menu_id'				=> $cms_id,
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


// Images

		$link_names = array([
			'menu_id'				=> $cms_id,
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
			'title'					=> 'Images',
			'url'					=> '/admin/images',
			'menulink_id'			=> $last_insert_id,
			'locale_id'				=> $locale_id // English ID
		]);

		if (Schema::hasTable('menulinks'))
		{
			DB::table('menulink_translations')->insert( $ink_name_trans );
		}


	} // run


}
