<?php

namespace App\Modules\Filex\Http\Controllers;

use App\Modules\Filex\Http\Models\Image;
use App\Modules\Filex\Http\Repositories\ImageRepository;

use Illuminate\Http\Request;
use App\Modules\Filex\Http\Requests\ImageCreateRequest;
use App\Modules\Filex\Http\Requests\ImageUpdateRequest;
use App\Modules\Filex\Http\Requests\DeleteRequest;


use Config;
use File;
use Flash;
use Redirect;
use Session;
use Theme;


class ImagesController extends FilexController {

	/**
	 * Image Repository
	 *
	 * @var Image
	 */
	protected $image;

	public function __construct(
			Image $image,
			ImageRepository $image_repo
		)
	{
		$this->image = $image;
		$this->image_repo = $image_repo;
// middleware
		$this->middleware('auth');
		$this->middleware('admin');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$lang = Session::get('locale');
		$images = $this->image->all();
//dd($images);

		return Theme::View('modules.filex.images.index',
			compact(
				'lang',
				'images'
				));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$lang = Session::get('locale');
//dd($lang);

		return Theme::View('modules.filex.images.create',
			compact(
				'lang'
		));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(
		ImageCreateRequest $request
		)
	{
//		$this->image_repo->store($request->all());
/*
		$photo = $this->photos;
		$photo->photo = Input::file('photo');
		$photo->save();
		$photo->url = $photo->photo->url();
		return $photo;
*/
//dd($request->image);

		$image = Image::create($request->all());


		Flash::success( trans('kotoba::files.success.image_create') );
		return redirect('admin/images');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
// 		$image = $this->image_repo->findOrFail($id);
//
// 		return View::make('HR::images.show', compact('image'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$image = $this->image->find($id);
		$extension = File::extension($image->image_file_name);
		$lang = Session::get('locale');
//dd($extension);

		$js_lang = array(
//			'CLOSE' => trans('kotoba::button.close'),
			'CLOSE' => "Close",
			'TITLE' => $image->image_file_name
		);

		$modal_title = trans('kotoba::general.command.delete');
		$modal_body = trans('kotoba::general.ask.delete');
		$modal_route = 'admin.images.destroy';
		$modal_id = $id;
		$model = '$image';

		return Theme::View('modules.filex.images.edit',
			compact(
				'image',
				'extension',
				'js_lang',
				'lang',
				'modal_title',
				'modal_body',
				'modal_route',
				'modal_id',
				'model'
		));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(
		ImageUpdateRequest $request,
		$id
		)
	{
//dd("update");
		$this->image_repo->update($request->all(), $id);

		Flash::success( trans('kotoba::files.success.image_update') );
		return redirect('admin/images');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->image->find($id)->delete();

		Flash::success( trans('kotoba::files.success.image_delete') );
		return Redirect::route('admin.images.index');
	}


	/**
	* Datatables data
	*
	* @return Datatables JSON
	*/
	public function data()
	{
//		$query = Image::select(array('images.id','images.name','images.description'))
//			->orderBy('images.name', 'ASC');
//		$query = Image::select('id', 'name' 'description', 'updated_at');
//			->orderBy('name', 'ASC');
		$query = Image::select('id', 'name', 'description', 'updated_at');
//dd($query);

		return Datatables::of($query)
//			->remove_column('id')

			->addColumn(
				'actions',
				'
					<a href="{{ URL::to(\'admin/images/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
						<span class="glyphicon glyphicon-pencil"></span>  {{ trans("kotoba::button.edit") }}
					</a>
				'
				)

			->make(true);
	}

}
