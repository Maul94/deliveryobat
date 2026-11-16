<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 	= 'C_login';
$route['404_override'] 			= '';
$route['translate_uri_dashes'] 	= FALSE;

/* route login */
$route['login'] 				= 'C_login';
// $route['do_login'] 				= 'C_login/do_login';
// $route['register'] 				= 'C_login/register';
// $route['get_px'] 				= 'C_login/get_px';
// $route['simpan_register'] 		= 'C_login/simpan_register';
$route['usrlogin'] 				= 'C_login/usrlogin';
$route['do_usrlogin'] 			= 'C_login/do_usrlogin';
$route['logout'] 				= 'C_login/logout';

/* route master region */
$route['getCity/(:num)']	= 'C_region/getCity/$1';
$route['getDis/(:num)']		= 'C_region/getDis/$1';
$route['getSubdis/(:num)']	= 'C_region/getSubdis/$1';

/* route dashboard */
$route['dashboard']				= 'C_dashboard';
$route['get_notif']				= 'C_dashboard/get_notif';
$route['give_rate/(:num)']		= 'C_dashboard/give_rate/$1';
$route['save_rate']				= 'C_dashboard/save_rate';

/* route delivery */
$route['delivery_list']								= 'C_delivery';
$route['deliveryjson']								= 'C_delivery/deliveryjson';
$route['deliveryjson/(:any)']						= 'C_delivery/deliveryjson/$1';
$route['deliveryjson/(:any)/(:num)']				= 'C_delivery/deliveryjson/$1/$2';
$route['entry_delivery']							= 'C_delivery/entry_delivery';
$route['save_delivery']								= 'C_delivery/save_delivery';
$route['detail_delivery/(:num)']					= 'C_delivery/detail_delivery/$1';
$route['batal_delivery/(:num)/(:any)']				= 'C_delivery/batal_delivery/$1/$2';
$route['edit_delivery/(:num)']						= 'C_delivery/edit_delivery/$1';

$route['driver_anterin']							= 'C_delivery/driver_anterin';
$route['get_ordinary/(:num)']						= 'C_delivery/get_ordinary/$1';
$route['set_ordinary/(:num)/(:num)']				= 'C_delivery/set_ordinary/$1/$2';
$route['selesai_delivery/(:num)']					= 'C_delivery/selesai_delivery/$1';

$route['report']				= 'C_report';
$route['print_report']			= 'C_report/print_report';


// $route['detail_delivery/(:num)/(:num)']				= 'C_delivery/detail_delivery/$1/$2';
// $route['update_status/(:num)/(:num)/(:num)']		= 'C_delivery/update_status/$1/$2/$3';
// $route['update_status/(:num)/(:num)/(:num)/(:num)']	= 'C_delivery/update_status/$1/$2/$3/$4';
// $route['update_nurse/(:num)/(:num)']				= 'C_delivery/update_nurse/$1/$2';
// $route['payment_delivery/(:num)/(:num)']			= 'C_delivery/payment_delivery/$1/$2';
// $route['save_payment/(:any)']						= 'C_delivery/save_payment/$1';

/* route user */
// $route['get_nurse']				= 'C_user/get_nurse';
