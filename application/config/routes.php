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
  |	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'page';
$route['404_override'] = 'page/page_not_found';
$route['login'] = 'auth/login';
$route['signup'] = 'auth/signup';
$route['recover'] = 'auth/recover';
$route['about-us'] = 'page/about_us';
$route['contact-us'] = 'page/contact_us';
$route['myaccount'] = 'page/myaccount';
$route['checkout'] = 'page/checkout';
$route['cart'] = 'page/cart';
$route['FAQ'] = 'page/FAQ';
$route['order'] = 'page/order';
$route['singleproduct'] = 'page/singleproduct';
$route['products'] = 'page/products';
$route['category'] = 'page/category';
$route['terms'] = 'page/terms';
$route['list_factory'] = 'user/list_factory';
$route['factory'] = 'user/factory';
$route['factory/(:any)'] = 'user/factory/$1';
$route_array = explode('/', $_SERVER['REQUEST_URI']);
if (!is_file(APPPATH . 'controllers/' . str_replace('-', '_', ucfirst(end($route_array)) . '.php'))) {
	$route['(:any)'] = 'page/pages/$1';
}
$route['translate_uri_dashes'] = TRUE;
