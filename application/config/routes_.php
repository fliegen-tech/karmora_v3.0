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

$route['default_controller'] = "index";
$route['admin/category/(:any)'] = "admin/category/$1";
$route['admin/reporting/(:any)'] = "admin/reporting/$1";
$route['admin/banner/(:any)'] = "admin/banner/$1";
$route['admin/managestore/(:any)'] = "admin/managestore/$1";
$route['admin/managestore/index/(:any)'] = "admin/managestore/index/$1/$2";
$route['admin/pages/(:any)'] = "admin/pages/$1";
$route['admin/video/(:any)'] = "admin/video/$1";
$route['admin/menu/(:any)'] = "admin/menu/$1";
$route['admin/news_sticker/(:any)'] = "admin/news_sticker/$1";
$route['admin/admin_user/(:any)'] = "admin/admin_user/$1";
$route['admin/account_type/(:any)'] = "admin/account_type/$1";
$route['admin/mangeforum/(:any)'] = "admin/mangeforum/$1";
$route['admin/managepost/(:any)'] = "admin/managepost/$1";
$route['admin/mangewinit/(:any)'] = "admin/mangewinit/$1";
$route['admin/mangewinit/index/(:any)'] = "admin/mangewinit/index/$1/$2";
$route['admin/mangewinit/changeStatus/(:any)'] = "admin/mangewinit/changeStatus/$1/$2";
$route['admin/mangewinit/reasonD/(:any)'] = "admin/mangewinit/reasonD/$1";
$route['admin/mangewinit/rejected/(:any)'] = "admin/mangewinit/rejected/$1";
$route['admin/mangewinit/approved/(:any)'] = "admin/mangewinit/approved/$1";
$route['admin/mangewinit/fliterS/(:any)'] = "admin/mangewinit/fliterS/$1";

$route['admin/mangekevin/(:any)'] = "admin/mangekevin/$1";
$route['admin/mangekevin/index/(:any)'] = "admin/mangekevin/index/$1/$2";
$route['admin/mangekevin/changeStatus/(:any)'] = "admin/mangekevin/changeStatus/$1/$2";
$route['admin/mangekevin/reasonD/(:any)'] = "admin/mangekevin/reasonD/$1";
$route['admin/mangekevin/rejected/(:any)'] = "admin/mangekevin/rejected/$1";
$route['admin/mangekevin/approved/(:any)'] = "admin/mangekevin/approved/$1";
$route['admin/mangekevin/fliterS/(:any)'] = "admin/mangekevin/fliterS/$1";

$route['admin/manageemail/(:any)'] = "admin/manageemail/$1";


// managerasieit
$route['admin/manageraiseit'] = "admin/manageraiseit/index";

$route['admin/manageraiseit/index/(:any)/(:any)'] = "admin/manageraiseit/index/$1/$2";
$route['admin/manageraiseit/status/(:any)/(:any)'] = "admin/manageraiseit/setStatus/$1/$2";
//$route['admin/manageraiseit/(:any)'] = "admin/manageraiseit/$1";


// managewinnerchest

$route['admin/mangwinnerchest/index'] = "admin/mangwinnerchest/index";
$route['admin/mangwinnerchest/add'] = "admin/mangwinnerchest/add";
$route['admin/mangwinnerchest/random/(:any)'] = "admin/mangwinnerchest/random/$1/$2";
$route['admin/mangwinnerchest/StoreType/(:any)'] = "admin/mangwinnerchest/StoreType/$1";
$route['admin/mangwinnerchest/(:any)'] = "admin/mangwinnerchest/$1";
$route['admin/mangwinnerchest/index/(:any)'] = "admin/mangwinnerchest/index/$1/$2";
$route['admin/mangwinnerchest/tresureuser/(:any)'] = "admin/mangwinnerchest/tresureuser/$1/$2";

$route['admin/(:any)'] = "admin/admin/$1";
$route['404_override'] = '';


/**frontend routes**/

//------------------**process cron routes start**---------------------//
$route['processcron'] = "processcron/index";
$route['(:any)/processcron'] = "processcron/$1";
$route['processcron/email_queue_process'] = "processcron/email_queue_process";

//------------------**process cron routes end**---------------------//

//------------------**process cron routes end**---------------------//
//$route['(:any)'] = "index/index/$1";
// route for login
$route['(:any)/login'] = "login/index/$1";
$route['login'] = "login/index/$1";
$route['signup/(:any)'] = "signup/$1";
$route['(:any)/signup/(:any)'] = "signup/$2/$1";

// routes for logout
$route['(:any)/logout'] = "login/logout/$1";
$route['logout'] = "login/logout/$1";

// account upgrade routes
$route['(:any)/upgrade'] = "upgradeaccount/index/$1";
$route['(:any)/upgrade/index'] = "upgradeaccount/index/$1";
$route['(:any)/upgrade/getcompliance/(:num)'] = "upgradeaccount/getcompliance/$2/$1";
// changes by Baig
$route['(:any)/upgrade-info'] = "upgradeaccount/upgradeInfo/$1";



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

// trends & stores common
$route['store-visit/(:any)'] = "store/storeVisit/$1";
$route['(:any)/store-visit/(:any)'] = "store/storeVisit/$2/$1";

$route['store-detail/(:any)'] = "store/storeDetail/$1";
$route['(:any)/store-detail/(:any)'] = "store/storeDetail/$2/$1";

$route['favourtie/(:any)'] = "store/favourtie/$1";
$route['(:any)/favourtie/(:any)'] = "store/favourtie/$2/$1";


// routes for pages
$route['disclosure-statement'] = "pages/index/disclosure-statement";
$route['(:any)/disclosure-statement'] = "pages/index/disclosure-statement/$1";

$route['privacy-policy'] = "pages/index/privacy-policy";
$route['(:any)/privacy-policy'] = "pages/index/privacy-policy/$1";

$route['refund-policy'] = "pages/index/refund-policy";
$route['(:any)/refund-policy'] = "pages/index/refund-policy/$1";

$route['terms-of-use'] = "pages/index/terms-of-use";
$route['(:any)/terms-of-use'] = "pages/index/terms-of-use/$1";

$route['about-karmora'] = "pages/index/about-karmora";
$route['(:any)/about-karmora'] = "pages/index/about-karmora/$1";

// reporting routes
$route['reporting'] = "reporting/index/$1";
//$route['reporting/kashBack'] = "reporting/kashBack/$1";
$route['(:any)/cash-back'] = "reporting/kashBack/$1";
//$route['reporting/community'] = "reporting/myCommunity/$1";
$route['(:any)/community'] = "reporting/myCommunity/$1";
//$route['reporting/goodKarmora'] = "reporting/goodKarmora/$1";
$route['(:any)/good-karmora'] = "reporting/goodKarmora/$1";

// routes for dashboard
//$route['dashboard'] = "dashboard/index/$1";
$route['(:any)/dashboard'] = "dashboard/index/$1";

// routes for user
$route['profile'] = "user/profile/$1";
$route['(:any)/profile'] = "user/profile/$1";
$route['(:any)/editprofile'] = "user/editProfile/$1";
$route['(:any)/profile/upload'] = "user/uploadPicture/$1";
// routes for member profile Ajax calls
$route['(:any)/profile/statesofcountry/(:any)'] = "user/getStatesOfCountry/$2/$1";
$route['(:any)/profile/citiesofstate/(:any)/(:any)'] = "user/getCitiesOfState/$2/$3/$1";
$route['(:any)/profile/zipcodesofcity/(:any)/(:any)/(:any)'] = "user/getZipCodesOfCity/$2/$3/$4/$1";

/***routes related to blog**/
//$route['post/index/(:any)'] = "post/index/$1";
$route['blog/view/(:any)'] = "blog/view/$1";
$route['(:any)/blog/view/(:any)'] = "blog/view/$2/$1";
$route['blog/index/(:any)'] = "blog/index/$1";
$route['(:any)/blog/index/(:any)'] = "blog/index/$2/$1";
$route['blog/(:any)'] = "blog/index/$1";
$route['(:any)/blog/(:any)'] = "blog/index/$2/$1";
$route['blog'] = "blog/index/all";
$route['(:any)/blog'] = "blog/index/all/$1";

// routes for forums
$route['forum'] = "forum/index";
$route['(:any)/forum'] = "forum/index/$1";
$route['forum/add'] = "forum/add";
$route['(:any)/forum/add'] = "forum/add/$1";
$route['forum/topic/(:any)'] = "forum/topic/$1";
$route['(:any)/forum/topic/(:any)'] = "forum/topic/$2/$1";
$route['(:any)/forum/detail/(:any)'] = "forum/detail/$2/$1";
$route['forum/detail/(:any)'] = "forum/detail/$1";
$route['(:any)/forum/index/(:any)/(:any)'] = "forum/index/$1/$2/$3";



// routes for paymypurchase
$route['paymypurchase'] = "paymypurchase/index";
$route['(:any)/paymypurchase'] = "paymypurchase/index/$1";
$route['paymypurchase/share'] = "paymypurchase/share";
$route['(:any)/paymypurchase/share'] = "paymypurchase/share/$1";
$route['paymypurchase/vote'] = "paymypurchase/vote";
$route['(:any)/paymypurchase/vote'] = "paymypurchase/vote/$1";
$route['paymypurchase/preview'] = "paymypurchase/preview";
$route['(:any)/paymypurchase/preview'] = "paymypurchase/preview/$1";
$route['(:any)/paymypurchase/karmora_likes/(:any)'] = "paymypurchase/karmora_likes/$1/$2";
//$route['paymypurchase/rule'] = "paymypurchase/rule";
$route['(:any)/paymypurchase/rule'] = "paymypurchase/rule/$1";
$route['paymypurchase/sharetowin'] = "paymypurchase/sharetowin";
$route['(:any)/paymypurchase/sharetowin'] = "paymypurchase/sharetowin/$1";
$route['paymypurchase/approved'] = "paymypurchase/approved";
$route['paymypurchase/participated'] = "paymypurchase/participated";
$route['(:any)/paymypurchase/approved'] = "paymypurchase/approved/$1";
$route['(:any)/paymypurchase/participated'] = "paymypurchase/participated/$1";
$route['(:any)/paymypurchase/winit_signup'] = "paymypurchase/winit_signup/$1";
$route['(:any)/paymypurchase/validate_shoper_first_form'] = "paymypurchase/validate_shoper_first_form/$1";

$route['pay4mypurchase-rules'] = "pages/index/pay4mypurchase-rules";
$route['(:any)/pay4mypurchase-rules'] = "pages/index/pay4mypurchase-rules/$1";

$route['(:any)/win'] = "win/index/$1";
$route['win'] = "win/index";
$route['(:any)/win/wincircle'] = "win/wincircle/$1";
$route['win/wincircle'] = "win/wincircle";


// routes for share_it

$route['(:any)/share'] = "share/index/$1";
$route['share'] = "share/index";
$route['share/preview'] = "share/preview";
$route['(:any)/share/preview'] = "share/preview/$1";
$route['share/unscribe'] = "share/unscribe";
$route['(:any)/share/unscribe'] = "share/unscribe/$1";
$route['share/yahoo_callback'] = "share/yahoo_callback";
$route['(:any)/share/yahoo_callback'] = "share/yahoo_callback/$1";
$route['share/hotmail_callback'] = "share/hotmail_callback";
$route['(:any)/share/hotmail_callback'] = "share/hotmail_callback/$1";
$route['share/gmail_callback'] = "share/gmail_callback";
$route['(:any)/share/gmail_callback'] = "share/gmail_callback/$1";
$route['share/gmail_callback/(:any)'] = "share/gmail_callback/$1";

// routes for whereiskavin
$route['whereiskevin'] = "whereiskevin/index";
$route['(:any)/whereiskevin'] = "whereiskevin/index/$1";
$route['whereiskevin/share'] = "whereiskevin/share";
$route['(:any)/whereiskevin/share'] = "whereiskevin/share/$1";
$route['(:any)/whereiskevin/vote'] = "whereiskevin/vote/$1";
$route['(:any)/whereiskevin/karmora_likes/(:any)'] = "whereiskevin/karmora_likes/$1/$2";
//$route['paymypurchase/rule'] = "paymypurchase/rule";
$route['(:any)/whereiskevin/rule'] = "whereiskevin/rule/$1";
$route['(:any)/whereiskevin/preview'] = "whereiskevin/preview/$1";
$route['whereiskevin/preview'] = "whereiskevin/preview";
$route['whereiskevin/sharetowin'] = "whereiskevin/sharetowin";
$route['(:any)/whereiskevin/sharetowin'] = "whereiskevin/sharetowin/$1";
$route['(:any)/whereiskevin/approved'] = "whereiskevin/approved/$1";
$route['(:any)/whereiskevin/winit_signup'] = "whereiskevin/winit_signup/$1";
$route['(:any)/whereiskevin/validate_shoper_first_form'] = "whereiskevin/validate_shoper_first_form/$1";



// routes for tresurechest
$route['tresurechest'] = "tresurechest/index";
$route['(:any)/tresurechest'] = "tresurechest/index/$1";

// routes for coupons
$route['coupons'] = "coupon/index";
$route['(:any)/coupons'] = "coupon/index/$1";
$route['coupons/index/(:any)/(:any)'] = "coupon/index/$2/$1";
$route['(:any)/coupons/index/(:any)/(:any)'] = "coupon/index/$1/$2/$3";


// routes for raiseit
$route['raiseit'] = "raiseit/index";
$route['(:any)/raiseit'] = "raiseit/index/$1";
$route['raiseit/city/(:any)'] = "raiseit/city/$1";
$route['(:any)/raiseit/city/(:any)'] = "raiseit/city/$2/$1";
$route['raiseit/zipcode/(:any)'] = "raiseit/zipcode/$1";
$route['(:any)/raiseit/zipcode/(:any)'] = "raiseit/zipcode/$2/$1";

//routes for makeit
$route['makeit'] = "makeit/showMakeit";
$route['(:any)/makeit'] = "makeit/showMakeit/$1";

// general routes {keep this section always at last}
$route['(:any)/test'] = "test/index/$1";
$route['(:any)'] = "index/index/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
