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
//front end URIs
$route['default_controller'] = 'Home';
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


//Dashboard -> Media -> Add
$route['dashboard/media/folder/(:num)/add'] = 'dashboard/media/Add_media/add_media/$1';
//Dashboard -> Media -> Settings
$route['dashboard/media/settings'] = 'dashboard/media/Media_settings/media_settings';
$route['dashboard/media/settings/add-category'] = 'dashboard/media/Media_settings/add_media_category';
$route['commons/common/get-childs/(:any)/(:num)/(:num)'] = 'commons/Common/get_taxonomy_names_by_parent_id/$1/$2/$3';
//Dashboard -> Media -> Add -> Edit
$route['dashboard/media/update-media/(:num)'] = 'dashboard/media/Update_media/update_media/$1';
$route['dashboard/media/folder/(:num)/edit/(:num)'] = 'dashboard/media/Add_media/add_media/$1/$2';
//Dashboard -> Media -> Add -> Edit -> Delete
$route['dashboard/media/delete-media/(:num)'] = 'dashboard/media/Update_media/delete_media/$1';


//Dashboard -> Products -> Categories
$route['dashboard/product/category'] = 'modules/product/Category/index';
$route['dashboard/product/category/add'] = 'modules/product/Category/add_product_category';
$route['dashboard/product/category/view_all'] = 'modules/product/Category/view_all_product_categories';
$route['dashboard/product/category/delete_category/(:num)'] = 'modules/product/Category/delete_product_category/$1';
$route['dashboard/product/category/edit_category/(:num)'] = 'modules/product/Category/edit_product_category/$1';
//Dashboard -> Products
$route['dashboard/product/add'] = 'modules/product/Add_product/add';
$route['dashboard/product/view-all'] = 'modules/product/Product/view_all';
$route['dashboard/product/edit/(:num)'] = 'modules/product/Edit_product/edit/$1';

//Dashboard -> shop-setting -> loaction
$route['dashboard/shop-setting/location'] = 'modules/shop_setting/location/Location/index';
//Dashboard -> shop-setting -> loaction -> Country
$route['dashboard/shop-setting/location/add/country'] = 'modules/shop_setting/location/Country/add_country';
$route['dashboard/shop-setting/location/view/country'] = 'modules/shop_setting/location/Country/view_countries';
$route['dashboard/shop-setting/location/delete/country/(:num)'] = 'modules/shop_setting/location/Country/delete_country/$1';
$route['dashboard/shop-setting/location/edit/country/(:num)'] = 'modules/shop_setting/location/Country/edit_country/$1';
//Dashboard -> shop-setting -> loaction -> State
$route['dashboard/shop-setting/location/add/state'] = 'modules/shop_setting/location/State/add_state';
$route['dashboard/shop-setting/location/view/state'] = 'modules/shop_setting/location/State/view_states';
$route['dashboard/shop-setting/location/view/state/c/(:num)'] = 'modules/shop_setting/location/State/view_states/$1';
$route['dashboard/shop-setting/location/delete/state/(:num)/c/(:num)'] = 'modules/shop_setting/location/State/delete_state/$1/$2';
$route['dashboard/shop-setting/location/edit/state/(:num)'] = 'modules/shop_setting/location/State/edit_state/$1';
//Dashboard -> shop-setting -> Shipping
$route['dashboard/shop-setting/shipping'] = 'modules/shop_setting/shipping/Shipping/index';
$route['dashboard/shop-setting/shipping/add/option'] = 'modules/shop_setting/shipping/option/add';
$route['dashboard/shop-setting/shipping/view/option'] = 'modules/shop_setting/shipping/option/view';
$route['dashboard/shop-setting/shipping/get_by_country/option/(:num)'] = 'modules/shop_setting/shipping/option/get_options_by_country_id/$1';
$route['dashboard/shop-setting/shipping/edit/option/(:num)'] = 'modules/shop_setting/shipping/option/edit/$1';

//Dashboard -> shop-setting -> Coupons
$route['dashboard/shop-setting/coupon'] = 'modules/shop_setting/coupon/Coupon/index';
$route['dashboard/shop-setting/coupon/add/code'] = 'modules/shop_setting/coupon/Code/add';
$route['dashboard/shop-setting/coupon/view/codes'] = 'modules/shop_setting/coupon/Code/view_all';

$route['commons/common/ajax-get-rows'] = 'commons/Common/ajax_get_rows_from';



