<?php

namespace App\Modules\Filex\Http\Middleware;

use Closure;
use CMenu;
use Caffeinated\Menus\Builder;


use App\Modules\Menus\Http\Models\Menu as LMenu;
use App\Modules\Menus\Http\Models\Menulink;

use App;
use Cache;
use Config;
//use DB;
//use Menu;
use Session;
//use Theme;


class MenuFilexMiddleware
{


	/**
	 * Run the request filter.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure                  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{


		CMenu::make('navFilex', function(Builder $menu) {
//			$activeTheme = Theme::getActive();
//Cache::forget('menu_Filex');

			$links = Cache::get('menu_Filex', null);
			if ($links == null) {
//dd('menu_admin');
				$links = Cache::rememberForever('menu_Filex', function() {
					$main_menu_id = LMenu::where('name', '=', 'media')->pluck('id');
					return Menulink::where('menu_id', '=', $main_menu_id)->IsEnabled()->orderBy('position')->get();
				});
			}
//dd($links);

			foreach ($links as $link)
			{
$url = ltrim($link->url, '/');
				$menu->add($link->title, ['url' => $url, 'class' => '']);
			}

// 			$menu->add('Home', '/');
// 			$menu->add('About', '/about');
// 			$menu->add('Blog', '/blog');
// 			$menu->add('Contact Me', '/contact-me');
		});

		return $next($request);
	}


}
