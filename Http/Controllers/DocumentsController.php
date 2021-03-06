<?php

namespace App\Modules\Filex\Http\Controllers;

use App\Modules\Filex\Http\Models\Document;
use App\Modules\Filex\Http\Repositories\DocumentRepository;

use Illuminate\Http\Request;
use App\Modules\Filex\Http\Requests\DocumentCreateRequest;
use App\Modules\Filex\Http\Requests\DocumentUpdateRequest;
use App\Modules\Filex\Http\Requests\DeleteRequest;


//use Config;
use File;
use Flash;
use Input;
use Redirect;
use Session;
use Theme;


class DocumentsController extends FilexController {

	/**
	 * Document Repository
	 *
	 * @var Document
	 */
	protected $document;

	public function __construct(
			Document $document,
			DocumentRepository $document_repo
		)
	{
		$this->document = $document;
		$this->document_repo = $document_repo;
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
		$documents = $this->document->all();
//dd($documents);

		return Theme::View('modules.filex.documents.index',
			compact(
				'lang',
				'documents'
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

		return Theme::View('modules.filex.documents.create',
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
		DocumentCreateRequest $request
		)
	{
//		$document = Document::create($request->all());
		$documents = Input::file('documents');

		foreach($documents as $document)
		{
			$document = Document::create(['document' => $document]);
		}


		Flash::success( trans('kotoba::files.success.document_create') );
		return redirect('admin/documents');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
// 		$document = $this->document_repo->findOrFail($id);
//
// 		return View::make('HR::documents.show', compact('document'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$document = $this->document->find($id);
		$extension = File::extension($document->document_file_name);
		$lang = Session::get('locale');
//dd($document->document_file_name);

		$js_lang = array(
//			'CLOSE' => trans('kotoba::button.close'),
			'CLOSE' => "Close",
			'TITLE' => $document->document_file_name
		);

		$modal_title = trans('kotoba::general.command.delete');
		$modal_body = trans('kotoba::general.ask.delete');
		$modal_route = 'admin.documents.destroy';
		$modal_id = $id;
		$model = '$document';

		return Theme::View('modules.filex.documents.edit',
			compact(
				'document',
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
		DocumentUpdateRequest $request,
		$id
		)
	{
//dd("update");
		$this->document_repo->update($request->all(), $id);

		Flash::success( trans('kotoba::files.success.document_update') );
		return redirect('admin/documents');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->document->find($id)->delete();

		Flash::success( trans('kotoba::files.success.document_delete') );
		return Redirect::route('admin.documents.index');
	}


	/**
	* Datatables data
	*
	* @return Datatables JSON
	*/
	public function data()
	{
//		$query = Document::select(array('documents.id','documents.name','documents.description'))
//			->orderBy('documents.name', 'ASC');
//		$query = Document::select('id', 'name' 'description', 'updated_at');
//			->orderBy('name', 'ASC');
		$query = Document::select('id', 'name', 'description', 'updated_at');
//dd($query);

		return Datatables::of($query)
//			->remove_column('id')

			->addColumn(
				'actions',
				'
					<a href="{{ URL::to(\'admin/documents/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
						<span class="glyphicon glyphicon-pencil"></span>  {{ trans("kotoba::button.edit") }}
					</a>
				'
				)

			->make(true);
	}

}
