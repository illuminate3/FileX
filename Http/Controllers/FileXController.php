<?php

namespace App\Modules\Filex\Http\Controllers;

use App\Http\Controllers\Controller;

use Theme;


class FilexController extends Controller
{


	/**
	 * Initializer.
	 *
	 * @return \FilexController
	 */
	public function __construct()
	{
// middleware
		$this->middleware('auth');
		$this->middleware('admin');
	}


	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function welcome()
	{
		return Theme::View('modules.filex.welcome.filex');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Theme::View('modules.core.landing');
	}

}
