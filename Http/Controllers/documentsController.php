<?php

namespace App\Modules\Core\Http\Controllers;

use App\Modules\Core\Http\Models\Documents;
use App\Modules\Core\Http\Repositories\DocumentRepository;

use Illuminate\Http\Request;
use App\Modules\Core\Http\Requests\DeleteRequest;
use App\Modules\Core\Http\Requests\DocumentCreateRequest;
use App\Modules\Core\Http\Requests\DocumentUpdateRequest;

use Cache;
use Flash;
use Session;
use Setting;
use Theme;


class DocumentsController extends RecordsController {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('documents.index');
	}

	public function add($id)
	{
		return View::make('documents.add', compact('id'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$id = Request::query('id');
		if ($id!== FALSE) {
			return View::make('documents.create', compact('id'));
		} else {
			return View::make('documents.create');
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('documents.edit', compact('id'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
