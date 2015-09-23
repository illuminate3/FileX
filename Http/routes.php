<?php

/*
|--------------------------------------------------------------------------
| Origami
|--------------------------------------------------------------------------
*/

// Route::pattern('news', '[0-9a-z]+');

// Resources
// Controllers

Route::group(['prefix' => 'filex'], function() {
	Route::get('welcome', [
		'uses'=>'FilexController@welcome'
	]);
});



// Route::group(array('before' => 'auth'), function()
// {
// 	\Route::get('elfinder', 'Barryvdh\Elfinder\ElfinderController@showIndex');
// 	\Route::any('elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
// 	\Route::get('elfinder/ckeditor4', 'Barryvdh\Elfinder\ElfinderController@showCKeditor4');
// });


// API DATA

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/


// Route::resource('news', 'ArticlesController', array('except' => array('show')));
//
// Route::get('{slug}', array('as' => 'news', 'uses' => 'ArticleController@show'))
// 	->where('slug', App\Modules\Filex\Http\Models\Article::$slugPattern);

// Controllers

// API DATA
// 	Route::get('api/sites', array(
// 	//	'as'=>'api.sites',
// 		'uses'=>'SitesController@data'
// 		));

//Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
Route::group(['prefix' => 'admin'], function() {

// Controllers

	Route::resource('documents', 'DocumentsController');
	Route::resource('images', 'ImagesController');


    /**
     * Documents
    **/

//     Route::get('documents/index', 'documentsController@index');
//     Route::get('documents/add', 'documentsController@create');


    /*
    Route::get('documents/add/{id}', 'documentsController@add');
    Route::post('documents/add/{id}', function ($id) {
        $fileUpload = new bz_customUpload();
        $fileUpload->bz_fileUpload($id, Input::get('folder'), Input::get('name'));

        return Redirect::to('upravljanje/'.$id);
    });
    */
/*
    Route::get('documents/edit/{id}', 'documentsController@edit');
    Route::post('documents/edit/{id}', function ($id) {
        $document = Documents::find($id);
        $document->name = Input::get('name');
        $document->save();
        return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
    });
    Route::post('documents/create', function() {
        $name       = Input::get('name');
        $group      = Input::get('selectedFolder');
        $tempFolder = Input::get('tempFolder');
        $folder     = Folders::where('id', $group)->pluck('path');

        $fileUpload = new bz_customUpload();
        $fileUpload->bz_fileUpload($group, $tempFolder, $folder, $name);

        return Redirect::back()->with('message','Podatki so bili uspešno shranjeni.');
    });
*/


// 	Route::resource('news', 'NewsController');
// 	Route::resource('news_statuses', 'NewsStatusesController');

// Routes
// 	Route::delete('news/{id}', array(
// 		'as'=>'news.destroy',
// 		'uses'=>'NewsController@destroy'
// 		));
// 	Route::delete('sites/{id}', array(
// 	//	'as'=>'sites.destroy',
// 		'uses'=>'SitesController@destroy'
// 		));

// API DATA
// 	Route::get('api/news_statuses', array(
// //		'as'=>'api.news_statuses',
// 		'uses'=>'NewsStatusesController@data'
// 		));

});

/*
Route::get('blog', 'FrontendController@get_blog');
Route::get('blog/{any}', 'FrontendController@get_post')->where('any', '.*');
Route::get('{page}', 'FrontendController@get_page')->where('page', '.*');
*/

// Route::get('/news/{news}', 'FrontDeskController@get_article')->where('news', '.*');



/*
Route::resource('news', 'ArticlesController', array('except' => array('show')));

Route::group(array('prefix' => 'news'), function () {

	Route::post("{id}/up", array(
		'as' => "articles.up",
		'uses' => "ArticlesController@up",
	));
	Route::post("{id}/down", array(
		'as' => "articles.down",
		'uses' => "ArticlesController@down",
	));

	Route::get('export', array(
		'as' => 'articles.export',
		'uses' => 'ArticlesController@export',
	));

	Route::get('{id}/confirm', array(
		'as' => 'articles.confirm',
		'uses' => 'ArticlesController@confirm',
	));

});

// The slug route should be registered last since it will capture any slug-like
// route
Route::get('{slug}', array('as' => 'news', 'uses' => 'ArticleController@show'))
	->where('slug', App\Modules\Filex\Http\Models\Article::$slugPattern);
*/

/*
//Route::when('assets/*', 'AssetsController');
*/
