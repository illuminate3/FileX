<?php

namespace App\Modules\FileX\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;


class ImageCreateRequest extends FormRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}


/*
'supported_image_types' => array(
	// images
	'png' => 'image/png',
	'jpe' => 'image/jpeg',
	'jpeg' => 'image/jpeg',
	'jpg' => 'image/jpeg',
	'gif' => 'image/gif',
	'bmp' => 'image/bmp',
	'ico' => 'image/vnd.microsoft.icon',
	'tiff' => 'image/tiff',
	'tif' => 'image/tiff',
	'svg' => 'image/svg+xml',
	'svgz' => 'image/svg+xml'
)
*/


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
// 			'name'						=> 'required',
			'image'						=> 'required|mimes:png,jpe,jpeg,jpg,gif,bmp,ico,tiff,tif,svg,svgz'
		];
	}

}
