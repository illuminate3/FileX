<?php

namespace App\Modules\Records\Http\Controllers;

use App\Http\Controllers\Controller;

use Theme;


class RecordsController extends Controller
{


	/**
	 * Initializer.
	 *
	 * @return \RecordsController
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
		return Theme::View('modules.records.welcome.Records');
	}


}
