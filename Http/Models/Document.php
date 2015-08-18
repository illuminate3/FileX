<?php

namespace App\Modules\Records\Http\Models;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

use Laracasts\Presenter\PresentableTrait;

use Cache;
use Config;
use DB;
use Setting;


class Document extends Model implements SluggableInterface {


	use PresentableTrait;
	use SluggableTrait;

	protected $table = 'documents';


// Presenter ---------------------------------------------------------------
	protected $presenter = 'App\Modules\Records\Http\Presenters\Records';


// DEFINE Hidden -----------------------------------------------------------
	protected $hidden = [
		'created_at',
		'updated_at'
		];

// DEFINE Fillable ---------------------------------------------------------
	protected $fillable = [
 		'image',
		'is_featured',
		'is_timed',
		'is_navigation',
		'order',
		'publish_start',
		'publish_end',
		'news_status_id',
		'slug',
		'user_id',
		// Translatable columns
		'meta_description',
		'meta_keywords',
		'meta_title',
		'class',
		'content',
		'summary',
		'title'
		];


// Sluggable Item ----------------------------------------------------------
	protected $sluggable = [
		'build_from' => 'title',
		'save_to'    => 'slug',
	];


// Relationships -----------------------------------------------------------

// hasMany
// belongsTo
// belongsToMany


// Functions ---------------------------------------------------------------

// limit

	public function scopeLimitTop($query)
	{
		return $query->limit( Setting::get('top_news_count', Config::get('news.top_news_count')) );
	}


// IS

	public function scopeIsBanner($query)
	{
		return $query->where('is_banner', '=', 1);
	}

	public function scopeIsFeatured($query)
	{
		return $query->where('is_featured', '=', 1);
	}

	public function scopeIsPublished($query)
	{
		return $query
			->where('news_status_id', '=', 2);
	}

	public function scopeIsTimed($query)
	{
		return $query->where('is_timed', '=', 1);
	}


// Not

	public function scopeNotFeatured($query)
	{
		return $query->where('is_featured', '=', 0);
	}

	public function scopeNotTimed($query)
	{
		return $query->where('is_timed', '=', 0);
	}


// Dates

	public function scopePublishEnd($query)
	{
	//	$today = new DateTime();
	//dd($today);
		$date = date("Y-m-d");
	//dd($date);
	//	return $query->where('created_at', '>', $today->modify('-7 days'));
		return $query->where('publish_end', '>=', $date);
	}

	public function scopePublishStart($query)
	{
		$date = date("Y-m-d");
	//dd($date);
		return $query->where('publish_start', '<=', $date);
	}


}
