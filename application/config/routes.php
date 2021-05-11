<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['about-us'] = 'pages/about';
$route['change-password'] = 'users/change_password';
$route['check-purchase/(:any)'] = 'pages/check_purchase/$1';
$route['customer-support'] = 'pages/customer_support';
$route['dropshipping-dictionary'] = 'pages/dictionary';
$route['forgot-password'] = 'pages/forgot_password';
$route['messages'] = 'pages/messages';
$route['login'] = 'pages/login';
$route['logout'] = 'pages/logout';
$route['maintenance'] = 'pages/maintenance';
$route['modules/(:any)'] = 'pages/modules/$1';
$route['modules/(:any)/(:any)'] = 'pages/section/$1/$2';
$route['modules/(:any)/(:any)/(:any)'] = 'pages/section/$1/$2/$3';
$route['modules/updates'] = 'pages/updates';
$route['modules/version/2/(:any)/(:any)'] = 'versions/section_2/$1/$2';
$route['modules/version/3/(:any)'] = 'versions/section_3';
$route['my-profile'] = 'pages/my_profile';
$route['password'] = 'users/password';
$route['privacy-policy'] = 'pages/privacy_policy';
$route['q-and-a-mastersheet'] = 'pages/faq';
$route['rankings'] = 'pages/rankings';
$route['rate_us'] = 'pages/rating';
$route['search'] = 'pages/search';
$route['support'] = 'pages/support';
$route['terms-and-conditions'] = 'pages/terms_and_conditions';
$route['tools'] = 'pages/tools';
$route['update-profile'] = 'pages/update_profile';
$route['user-profile/(:any)'] = 'pages/view_profile/$1';
$route['user-status'] = 'pages/user_status';
$route['verification'] = 'pages/verification';

$route['admin'] = 'admin/index';
$route['admin/contents'] = 'courses/all_contents';
$route['admin/frequently-asked-questions'] = 'faq/index';
$route['admin/frequently-asked-questions/(:any)'] = 'faq/edit_faq/$1';
$route['admin/modules'] = 'courses/index';
$route['admin/modules/(:any)'] = 'courses/create_course/$1';
$route['admin/modules/v2/(:any)'] = 'courses/create_course_2/$1';
$route['admin/posts'] = 'admin/posts';
$route['admin/products'] = 'products/index';
$route['admin/products/(:any)'] = 'products/edit/$1';
$route['admin/programs'] = 'programs/index';
$route['admin/rated-products'] = 'rated_products/index';
$route['admin/rated-products/(:any)'] = 'rated_products/edit/$1';
$route['admin/ratings'] = 'admin/ratings';
$route['admin/resources'] = 'resources/index';
$route['admin/resources/create'] = 'resources/create_resource';
$route['admin/resources/edit/(:any)'] = 'resources/edit_resource/$1';
$route['admin/reviews'] = 'reviews/index';
$route['admin/reviews/(:any)'] = 'reviews/edit_review/$1';
$route['admin/settings'] = 'settings/index';
$route['admin/settings/(:any)'] = 'settings/pages/$1';
$route['admin/support'] = 'admin/support';
$route['admin/users/(:any)'] = 'admin/profile/$1';

$route['default_controller'] = 'pages/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;