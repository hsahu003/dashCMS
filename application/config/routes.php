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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//dashboard URI
$route['dashboard/login'] = 'dashboard/login/index';
$route['dashboard/logout'] = 'dashboard/login/logout';
$route['dashboard'] = 'dashboard/home/index';

// 

//Dashboard -> Setting
$route['dashboard/settings'] = 'dashboard/settings/common/index';
$route['ajax/add-image'] = 'dashboard/settings/common/ajax_add_image';
$route['ajax/remove-image'] = 'dashboard/settings/common/ajax_remove_image';

//Dashboard -> Setting -> Admin URI -> View
$route['dashboard/settings/admin/view/(:any)/(:any)'] = 'dashboard/settings/admin/view_admins/$1/$2';
$route['dashboard/settings/admin/view'] = 'dashboard/settings/admin/view_admins/status/1';
$route['dashboard/settings/admin/view/all'] = 'dashboard/settings/admin/view_admins/all';

//Dashboard -> Setting -> Admin URI -> Add
$route['dashboard/settings/admin/add'] = 'dashboard/settings/admin/add_admin';

//Dashboard -> Setting -> Admin URI -> Edit
$route['dashboard/settings/admin/edit/(:num)'] = 'dashboard/settings/admin/edit_admin/$1';

$route['ajax/delete-admin'] = 'dashboard/settings/admin/ajax_remove_admin';
$route['ajax/disable-admin'] = 'dashboard/settings/admin/ajax_disable_admin';

//Dashboard -> Settings -> User -> Ajax