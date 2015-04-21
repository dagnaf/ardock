<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// $route['default_controller'] = "welcome";
// 在这里添加路由，然后1控制器加在contral文件夹，2写model，3些View
// 左边是网址，右边是控制器名/方法名。。。
// $route['default_controller'] = "welcome";
$route['board'] = 'board/index';
$route['board/(:num)'] = 'board/index/$1';
$route['board/search'] = 'board/search';
$route['board/search/(:any)'] = 'board/search/$1';
$route['board/search/(:any)/(:num)'] = 'board/search/$1/$2';
$route['post/(:num)'] = 'board/post/$1';
$route['post/(:num)/(:num)'] = 'board/post/$1/$2';
$route['content/(:any)'] = 'modules/html/$1';
$route['game'] = 'game';
$route['rank'] = 'rank/index';
$route['rank/(:num)'] = 'rank/index/$1';
$route['rank/(:any)'] = 'rank/user/$1';
$route['edit'] = 'edit';
$route['profile/(:any)'] = 'profile/index/$1';
$route['profile/(:any)/(:any)'] = 'profile/index/$1/$2';
// profile/david/post/2
$route['profile/(:any)/(:any)/(:num)'] = 'profile/index/$1/$2/$3';
//
$route['default_controller'] = "pages/view";
$route['404_override'] = '';
$route['logout'] = 'pages/logout';
$route['login'] = 'ajax/login';
$route['nav/(:any)'] = 'modules/nav/$1';
// $route['captcha'] = 'pages/captcha';
$route['check/(:any)'] = 'pages/ajax_check/$1';
$route['register'] = 'pages/signup';
$route['delete/(:any)/(:num)'] = 'actions/delete/$1/$2';

$route['test'] = 'pages/test';
$route['(:any)'] = 'pages/view/$1';
$route['submit/score'] = 'ajax/score';





/* End of file routes.php */
/* Location: ./application/config/routes.php */
