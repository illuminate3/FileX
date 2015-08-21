<?php

namespace App\Modules\FileX\Http\Models;

use Illuminate\Database\Eloquent\Model;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

// use Cviebrock\EloquentSluggable\SluggableInterface;
// use Cviebrock\EloquentSluggable\SluggableTrait;

//use Laracasts\Presenter\PresentableTrait;

use Cache;
use Config;
use DB;
use Setting;


class Document extends Model implements StaplerableInterface {


//	use PresentableTrait;
//	use SluggableTrait;
	use EloquentTrait;


	protected $table = 'documents';


// Presenter ---------------------------------------------------------------
//	protected $presenter = 'App\Modules\FileX\Http\Presenters\FileX';


// DEFINE Hidden -----------------------------------------------------------
// 	protected $hidden = [
// 		'created_at',
// 		'updated_at'
// 		];


// DEFINE Fillable ---------------------------------------------------------
	protected $fillable = [
 		'user_id',
		'document'
		];


// Staple Item -------------------------------------------------------------
	public function __construct(array $attributes = array()) {
		$this->hasAttachedFile('document', [
			'url' => '/system/files/:attachment/:id_partition/:filename'
//			'url' => '/system/files/:attachment/:id/:filename'
		]);

		parent::__construct($attributes);
	}

	public static function boot()
	{
		parent::boot();

		static::bootStapler();
	}


// Sluggable Item ----------------------------------------------------------
// 	protected $sluggable = [
// 		'build_from' => 'title',
// 		'save_to'    => 'slug',
// 	];


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
