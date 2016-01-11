<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
| http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = "index/index";

$route['admin/banner'] = "admin/banner/index";
$route['admin/banner/(:any)'] = "admin/banner/$1";
$route['admin/banner/(:any)/(:any)/(:any)'] = "admin/banner/$1/$2/$3";

$route['admin/news_sticker/(:any)'] = "admin/news_sticker/$1";


// store admin route

$route['admin/managestore'] = "admin/managestore/index";
$route['admin/managestore/(:any)'] = "admin/managestore/$1";
$route['admin/managestore/index/(:any)'] = "admin/managestore/index/$1/$2";

// product routes admin

$route['admin/category'] = "admin/category/index";
$route['admin/category/(:any)'] = "admin/category/$1";
$route['admin/category/(:any)/(:any)/(:any)'] = "admin/category/$1/$2/$3";

// category routes admin

$route['admin/product'] = "admin/manage_product/index";
$route['admin/product/(:any)'] = "admin/manage_product/$1";
$route['admin/product/add'] = "admin/manage_product/add";
//$route['admin/product/(:any)/(:any)/(:any)'] = "admin/manage_product/$1/$2/$3";
$route['admin/manage_product/detail/(:any)'] = "admin/manage_product/details/$1";

// payforpurchase admin routes

$route['admin/payforpurchase'] = "admin/payforpurchase/index";
$route['admin/payforpurchase/changeStatus/(:any)/(:any)'] = "admin/payforpurchase/changeStatus/$1/$2";
$route['admin/payforpurchase/(:any)'] = "admin/payforpurchase/$1";
$route['admin/payforpurchase/(:any)/(:any)'] = "admin/payforpurchase/$1/$2";


// managewinnerchest

$route['admin/mangwinnerchest/index'] = "admin/mangwinnerchest/index";
$route['admin/mangwinnerchest/add'] = "admin/mangwinnerchest/add";
$route['admin/mangwinnerchest/random/(:any)'] = "admin/mangwinnerchest/random/$1/$2";
$route['admin/mangwinnerchest/StoreType/(:any)'] = "admin/mangwinnerchest/StoreType/$1";
$route['admin/mangwinnerchest/(:any)'] = "admin/mangwinnerchest/$1";
$route['admin/mangwinnerchest/tresureuser'] = "admin/mangwinnerchest/tresureuser";
$route['admin/mangwinnerchest/(:any)/(:any)'] = "admin/mangwinnerchest/$1/$2";


//videos routes for admin
$route['admin/video'] = "admin/video/index";
$route['admin/video/(:any)'] = "admin/video/$1";


$route['admin/(:any)'] = "admin/admin/$1";
$route['404_override'] = '';


/**frontend routes**/

//home routes



//Signup routes

$route['scribeUser'] = "index/scribeUser";
$route['(:any)/scribeUser'] = "index/scribeUser/$1";

// sucribe 
$route['signup'] = "login/signup";
$route['(:any)/signup'] = "login/signup/$1";
// product routes frontent

$route['product'] = "product/index";
$route['(:any)/product'] = "product/index/$1";
$route['product/(:any)'] = "product/$1";
$route['product-detail/(:any)'] = "product/product_detail/$1";
$route['(:any)product-detail/(:any)'] = "product/product_detail/$1/$2";

// routes for user
$route['profile'] = "user/profile/$1";
$route['(:any)/profile'] = "user/profile/$1";
$route['(:any)/editprofile'] = "user/editProfile/$1";
$route['(:any)/profile/upload'] = "user/uploadPicture/$1";
$route['(:any)/profile/emails'] = "user/manageemail/$1";
// routes for member profile Ajax calls
$route['(:any)/profile/statesofcountry/(:any)'] = "user/getStatesOfCountry/$2/$1";
$route['(:any)/profile/citiesofstate/(:any)/(:any)'] = "user/getCitiesOfState/$2/$3/$1";
$route['(:any)/profile/zipcodesofcity/(:any)/(:any)/(:any)'] = "user/getZipCodesOfCity/$2/$3/$4/$1";


// routes for tresurechest
$route['treasurechest'] = "tresurechest/index";
$route['(:any)/treasurechest'] = "tresurechest/index/$1";


// routes for pay4mypurchase

$route['Pay4MyPurchase'] = "paymypurchase/index";
$route['(:any)/Pay4MyPurchase'] = "paymypurchase/index/$1";
$route['Pay4MyPurchase/(:any)'] = "paymypurchase/$1";
$route['(:any)/Pay4MyPurchase/(:any)'] = "paymypurchase/$2/$1";


// routes for staichtmlpages

$route['karmora-kash'] = "statichtml/karmorakash";
$route['(:any)/karmora-kash'] = "statichtml/karmorakash/$1";
$route['about-us'] = "statichtml/aboutus";
$route['(:any)/about-us'] = "statichtml/aboutus/$1";
$route['cash-back'] = "statichtml/cashbackextension";
$route['(:any)/cash-back'] = "statichtml/cashbackextension/$1";
$route['how-to-win'] = "statichtml/howtowin";
$route['(:any)/how-to-win'] = "statichtml/howtowin/$1";


//routes for karmora videos

$route['video'] = 'karmoravideos/index';
$route['(:any)/video'] = 'karmoravideos/index/$1';


//route for karmora mall

$route['retail-mall'] = "karmoramall/index";
$route['(:any)/retail-mall'] = "karmoramall/index/$1";


//stores routes
$route['store/storeSearch'] = "store/storeSearch";
$route['store/storeSearch/(:any)'] = "store/storeSearch/$1";
$route['(:any)/store/storeSearch/(:any)'] = "store/storeSearch/$2/$1";

$route['store'] = "store/allStore/all";
$route['(:any)/store'] = "store/allStore/all/$1";
$route['store/(:any)'] = "store/allStore/$1";
$route['(:any)/store/(:any)'] = "store/allStore/$2/$1";
$route['store/store_search/(:any)'] = "store/store_search/$1";

//trending stores routes
$route['trending-stores/(:any)'] = "store/trendingStore/$1";
$route['(:any)/trending-stores/(:any)'] = "store/trendingStore/$2/$1";
$route['trending-store/(:any)'] = "store/trendingStoreInfo/$1";
$route['(:any)/trending-store/(:any)'] = "store/trendingStoreInfo/$2/$1";


//offers routes
$route['special-offer/(:any)'] = "store/specialDeals/$1";
$route['(:any)/special-offer/(:any)'] = "store/specialDeals/$2/$1";

// trends & stores common
$route['store-visit/(:any)'] = "store/storeVisit/$1";
$route['(:any)/store-visit/(:any)'] = "store/storeVisit/$2/$1";



$route['store-detail/(:any)'] = "store/storeDetail/$1";
$route['(:any)/store-detail/(:any)'] = "store/storeDetail/$2/$1";

$route['favourtie/(:any)'] = "store/favourtie/$1";
$route['(:any)/favourtie/(:any)'] = "store/favourtie/$2/$1";
$route['Unfavourtie/(:any)'] = "store/Unfavourtie/$1";
$route['(:any)/Unfavourtie/(:any)'] = "store/Unfavourtie/$2/$1";

$route['Sfavourtie/(:any)'] = "store/Sfavourtie/$1";
$route['(:any)/Sfavourtie/(:any)'] = "store/Sfavourtie/$2/$1";
$route['SUnfavourtie/(:any)/(:any)'] = "store/SUnfavourtie/$1/$2";
$route['(:any)/SUnfavourtie/(:any)/(:any)'] = "store/SUnfavourtie/$2/$3/$1";

// for favrt page store
$route['(:any)/FUnfavourtie/(:any)'] = "myfavorites/FUnfavourtie/$2/$1";
$route['(:any)/FCUnfavourtie/(:any)'] = "myfavorites/FCUnfavourtie/$2/$1";

// for store detail page
$route['(:any)/Cofavourtie/(:any)/(:any)'] = "store/Cofavourtie/$2/$3/$1";
$route['(:any)/CoUnfavourtie/(:any)/(:any)'] = "store/CoUnfavourtie/$2/$3/$1";



// login and logout
$route['(:any)/login'] = "login/index/$1";
$route['login'] = "login/index/$1";
$route['(:any)/logout'] = "login/logout/$1";
$route['logout'] = "login/logout";



// general routes {keep this section always at last}
$route['(:any)/index'] = "index/index/$1";
$route['(:any)'] = "index/index/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
