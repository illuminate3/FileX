<?php

namespace App\Modules\Filex\Database\Seeds;

use Illuminate\Database\Seeder;
Use DB;
use Schema;


class ModuleLinksSeeder extends Seeder
{


	public function run()
	{

		$cms_id = DB::table('menus')
			->where('name', '=', 'cms')
			->pluck('id');

		if ($cms_id == null) {
			$cms_id = 1;
		}

// Links -------------------------------------------------------------------
// Documents

		$link_names = array([
			'menu_id'				=> $cms_id,
			'status_id'				=> 1,
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
			'title'					=> 'Documents',
			'status'				=> 1,
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
			'status_id'				=> 1,
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
			'title'					=> 'Images',
			'status'				=> 1,
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
