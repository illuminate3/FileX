<?php

namespace App\Modules\Filex\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Config;


class DocumentCreateRequest extends FormRequest {

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
'supported_document_types' => array(
// generic
	'txt' => 'text/plain',
// adobe
	'pdf' => 'application/pdf',
	'psd' => 'image/vnd.adobe.photoshop',
	'ai' => 'application/postscript',
	'eps' => 'application/postscript',
	'ps' => 'application/postscript',
// ms office
	'doc' => 'application/msword',
	'rtf' => 'application/rtf',
	'xls' => 'application/vnd.ms-excel',
	'ppt' => 'application/vnd.ms-powerpoint',
// open office
	'odt' => 'application/vnd.oasis.opendocument.text',
	'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
	'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

),
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
			'document'					=> 'required|mimes:txt,pdf,doc,docx,rtf,xls,ppt,odt,ods,xlsx'
		];
	}

}
