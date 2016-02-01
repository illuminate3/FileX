<?php

namespace App\Modules\Filex\Http\Repositories;

use App\Modules\Core\Http\Repositories\BaseRepository;
use App\Modules\Filex\Http\Models\Image;

//use Config;
use DB;
//use Image;
use Input;
use Lang;
use Request;


class ImageRepository extends BaseRepository {


	/**
	 * The Module instance.
	 *
	 * @var App\Modules\ModuleManager\Http\Models\Module
	 */
	protected $image;


	/**
	 * Create a new ModuleRepository instance.
	 *
   	 * @param  App\Modules\ModuleManager\Http\Models\Module $module
	 * @return void
	 */
	public function __construct(
		Image $image
		)
	{
		$this->model = $image;
	}


	/**
	 * Get role collection.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function create()
	{
		//
	}


	/**
	 * Get user collection.
	 *
	 * @param  string  $slug
	 * @return Illuminate\Support\Collection
	 */
	public function show($id)
	{
		$image = $this->model->find($id);
//		$image = $this->model->with('employees')->find($id);
//		$image = $this->model->with('users')->find($id);
//dd($image);

		if ($image->logo != NULL) {
			$logo = $image->logo;
		} else {
			$logo = null;
		}

//dd($image->division_id);
//		$division = $image->present()->divisionName($image->division_id);
		$contact = $image->present()->contactName($image->user_id);

		return compact(
			'contact',
//			'division',
			'logo',
			'image'
		);
	}


	/**
	 * Get user collection.
	 *
	 * @param  int  $id
	 * @return Illuminate\Support\Collection
	 */
	public function edit($id)
	{
// 		$image = $this->model->find($id);
// 		return compact(
// 			'image'
// 		);
	}


	/**
	 * Get all models.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function store($input)
	{
//dd($input);

//		$this->model = new Image;
		$this->model->create($input);
	}


	/**
	 * Update a role.
	 *
	 * @param  array  $inputs
	 * @param  int    $id
	 * @return void
	 */
	public function update($input, $id, $file, $show_path)
	{
//dd($file);
		$image = Image::find($id);

		if ($file != NULL) {
			$input['logo'] = $show_path . $file;
		}
			$input['division_id'] = null;
			$input['logo'] = null;

		$image->update($input);
	}


// Functions --------------------------------------------------

	public function getImages()
	{
		$images = DB::table('images')->lists('name', 'id');
		return $images;
	}

	public function getImage($barcode)
	{
		$image = DB::table('images')
			->where('barcode', '=', $barcode)
			->get();

		return $image;
	}

	public function getContacts()
	{
		$contacts = DB::table('users')->lists('name', 'id');
//		$contacts = DB::table('profiles')->lists('email', 'user_id');
//		$contacts = DB::table('profiles')->lists('first_name' . '&nbsp;' . 'last_name', 'user_id');
// 		if ( empty($contacts) ) {
// 			$contacts = DB::table('users')->lists('email', 'id');
// 		}
		return $contacts;
	}

// 	public function getDivisions()
// 	{
// 		$divisions = DB::table('divisions')->lists('name', 'id');
// 		return $divisions;
// 	}

/*
	public function getContactUser($id)
	{
		$user = DB::table('profiles')
			->where('user_id', '=', $id)
			->first();
		return $user;
	}
*/


}
