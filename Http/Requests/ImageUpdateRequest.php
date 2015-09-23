<?php

namespace App\Modules\Filex\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;


class ImageUpdateRequest extends FormRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}


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
