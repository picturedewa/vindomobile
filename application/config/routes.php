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
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8

$route['banner/new']['post'] = 'api/banner/insertbanner';
$route['banner/del']['post'] = 'api/banner/deletebanner';

$route['product/new']['post'] = 'api/product/insertproduct';
$route['product/del']['post'] = 'api/product/deleteproduct';

$route['kategori/new']['post'] = 'api/kategori/insertcate';
$route['kategori/del']['post'] = 'api/kategori/deletecate';
$route['kategori/edit']['post'] = 'api/kategori/editcate';

$route['promo/new']['post'] = 'api/promo/insertpromo'; 
$route['promo/del']['post'] = 'api/promo/deletepromo';
$route['promo/edit']['post'] = 'api/promo/editpromo';

$route['about/savemap']['post'] = 'api/about/savemap';
$route['market/save']['post'] = 'api/marketplace/inputmarket';
$route['market/delmarket']['post'] = 'api/marketplace/deletemarketplace';
$route['market/edit']['post'] = 'api/marketplace/editmarket';

$route['hadiah/save']['post'] = 'api/hadiah/insertgiveway';
$route['hadiah/edit']['post'] = 'api/hadiah/updategiveway';
$route['hadiah/del']['post'] = 'api/hadiah/deletehadiah';

$route['sosmed/save']['post'] = 'api/sosmed/inputmarket';
$route['sosmed/delmarket']['post'] = 'api/sosmed/deletemarketplace';
$route['sosmed/edit']['post'] = 'api/sosmed/editmarket';

$route['store/save']['post'] = 'api/store/insertstore';
$route['store/edit']['post'] = 'api/store/editstore';
$route['store/del']['post'] = 'api/store/deletestore'; 

$route['others/save']['post'] = 'api/others/insertvch';
$route['others/del']['post'] = 'api/others/delvoucher';
