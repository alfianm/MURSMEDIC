<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'C_index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;
//-----------------------------------------------------------------------------------------------//
//untuk pengiriman data via http get, untuk menghindari terlihat nya parameter yang di kirim di url, gunakan ini :
//$route['menu-edit-(:any)'] = 'C_menu/edit/$1';
//$1 adalah default parameter yang dikirim == 1
//-----------------------------------------------------------------------------------------------//
$route['index'] = 'C_index';

$route['menu'] = 'C_menu';

$route['log'] = 'C_log';

$route['profile'] = 'C_profile';

$route['md_grant'] = 'C_md_grant';
$route['md_user'] = 'C_md_user';
$route['md_rack'] = 'C_md_rack';
$route['md_storage'] = 'C_md_storage';
$route['md_product_category'] = 'C_md_product_category';
$route['md_product'] = 'C_md_product';
$route['md_distributor'] = 'C_md_distributor';
$route['md_supplier'] = 'C_md_supplier';
$route['md_ekspedisi'] = 'C_md_ekspedisi';
$route['md_forwarder'] = 'C_md_forwarder';

$route['i_input_data'] = 'C_i_input_data';
$route['i_approve_data'] = 'C_i_approve_data';
$route['i_summary'] = 'C_i_summary';

$route['o_input_data'] = 'C_o_input_data';
$route['o_approve_data'] = 'C_o_approve_data';
$route['o_tally_sheet'] = 'C_o_tally_sheet';
$route['o_delivery_note'] = 'C_o_delivery_note';
$route['o_delivery_note_status'] = 'C_o_delivery_note_status';

$route['r_stock_rack'] = 'C_r_stock_rack';
$route['r_stock_product'] = 'C_r_stock_product';
$route['r_stock_product_sample'] = 'C_r_stock_product_sample';
$route['r_stock_product_return'] = 'C_r_stock_product_return';
$route['r_inbound'] = 'C_r_inbound';
$route['r_outbound'] = 'C_r_outbound';
// KARANTINA
$route['q_data'] = 'C_q_data';
$route['q_sample'] = 'C_q_sample';
$route['q_return'] = 'C_q_return';
$route['i_input_data_quarantine'] = 'C_i_input_data_quarantine';
$route['i_inbound'] = 'C_i_inbound';
//-----------------------------------------------------------------------------------------------//
