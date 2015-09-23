<?php

namespace App\Modules\Filex\Http\Repositories;

use App\Modules\Core\Http\Repositories\BaseRepository;
use App\Modules\Filex\Http\Models\Document;

use Config;
use DB;
use Image;
use Input;
use Lang;
use Request;


class DocumentRepository extends BaseRepository {


	/**
	 * The Module instance.
	 *
	 * @var App\Modules\ModuleManager\Http\Models\Module
	 */
	protected $document;


	/**
	 * Create a new ModuleRepository instance.
	 *
   	 * @param  App\Modules\ModuleManager\Http\Models\Module $module
	 * @return void
	 */
	public function __construct(
		Document $document
		)
	{
		$this->model = $document;
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
		$document = $this->model->find($id);
//		$document = $this->model->with('employees')->find($id);
//		$document = $this->model->with('users')->find($id);
//dd($document);

		if ($document->logo != NULL) {
			$logo = $document->logo;
		} else {
			$logo = null;
		}

//dd($document->division_id);
//		$division = $document->present()->divisionName($document->division_id);
		$contact = $document->present()->contactName($document->user_id);

		return compact(
			'contact',
//			'division',
			'logo',
			'document'
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
// 		$document = $this->model->find($id);
// 		return compact(
// 			'document'
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

//		$this->model = new Document;
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
		$document = Document::find($id);

		if ($file != NULL) {
			$input['logo'] = $show_path . $file;
		}
			$input['division_id'] = null;
			$input['logo'] = null;

		$document->update($input);
	}


// Functions --------------------------------------------------

	public function getDocuments()
	{
		$documents = DB::table('documents')->lists('name', 'id');
		return $documents;
	}

	public function getDocument($barcode)
	{
		$document = DB::table('documents')
			->where('barcode', '=', $barcode)
			->get();

		return $document;
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
