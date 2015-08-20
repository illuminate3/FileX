<?php

return [

//vendor:publish --provider="App\Modules\Records\Providers\RecordsServiceProvider" --tag="config"
//vendor:publish --provider="App\Modules\Records\Providers\RecordsServiceProvider" --tag="js"
//vendor:publish --provider="App\Modules\Records\Providers\RecordsServiceProvider" --tag="plugins"
//vendor:publish --provider="App\Modules\Records\Providers\RecordsServiceProvider" --tag="views"

/*
|--------------------------------------------------------------------------
| db settings
|--------------------------------------------------------------------------
*/
'records_db' => array(
	'prefix'					=> '',
),


/*
width: A style that defines a width only (landscape). Height will be automagically selected to preserve aspect ratio. This works well for resizing images for display on mobile devices, etc.
xheight: A style that defines a heigh only (portrait). Width automagically selected to preserve aspect ratio.
widthxheight#: Resize then crop.
widthxheight!: Resize by exacty width and height. Width and height emphatically given, original aspect ratio will be ignored.
widthxheight: Auto determine both width and height when resizing. This will resize as close as possible to the given dimensions while still preserving the original aspect ratio.
*/

'image_styles' => [
	'landscape'					=> '1356x500!',
	'preview'					=> '700x500!',
	'portrait'					=> '150x196!',
	'thumb'						=> '100x100!'
]

];
