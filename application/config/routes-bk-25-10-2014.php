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
$route['admin/manageraiseit/delete/(:any)'] = "admin/manageraiseit/delete/$1";
$route['admin/manageraiseit/approved/(:any)'] = "admin/manageraiseit/approved/$1";

// smokingdeal
$route['admin/smokingdeal/(:any)'] = "admin/smokingdeal/$1";
$route['admin/smokingdeal/index/(:any)'] = "admin/smokingdeal/index/$1/$2";
$route['admin/smokingdeal/Albumstatus/(:any)/(:any)/(:any)/(:any)'] = "admin/smokingdeal/Albumstatus/$1/$2/$3/$4";

//routes for setting

$route['admin/setting/index'] = "admin/setting/index";
$route['admin/setting/save'] = "admin/setting/save";


// managewinnerchest

$route['admin/mangwinnerchest/index'] = "admin/mangwinnerchest/index";
$route['admin/mangwinnerchest/add'] = "admin/mangwinnerchest/add";
$route['admin/mangwinnerchest/random/(:any)'] = "admin/mangwinnerchest/random/$1/$2";
$route['admin/mangwinnerchest/StoreType/(:any)'] = "admin/mangwinnerchest/StoreType/$1";
$route['admin/mangwinnerchest/(:any)'] = "admin/mangwinnerchest/$1";
$route['admin/mangwinnerchest/index/(:any)'] = "admin/mangwinnerchest/index/$1/$2";
$route['admin/mangwinnerchest/tresureuser/(:any)'] = "admin/mangwinnerchest/tresureuser/$1/$2";


// managecoupons
$route['admin/managecoupons/(:any)'] = "admin/managecoupons/$1";
$route['admin/managecoupons'] = "admin/managecoupons/importCoupons";
$route['admin/managecoupons/index'] = "admin/managecoupons/index";
$route['admin/managecoupons/index/(:any)/(:any)'] = "admin/managecoupons/index/$1/$2";
$route['admin/managecoupons/allCoupons'] = "admin/managecoupons/allCoupons";
$route['admin/managecoupons/allCoupons/(:any)/(:any)'] = "admin/managecoupons/allCoupons/$1/$2";

// manageusers
//$route['admin/manageusers/(:any)'] = "admin/manageusers/$1";
$route['admin/manageusers/index'] = "admin/manageusers/index";
$route['admin/manageusers/index/(:any)/(:any)'] = "admin/manageusers/index/$1/$2";
$route['admin/UserDetails/(:any)'] = "admin/manageusers/UserDetails/$1";
$route['admin/manageusers/edit/(:any)'] = "admin/manageusers/UserEdit/$1";
$route['admin/manageusers/search'] = "admin/manageusers/searchUser";
$route['admin/manageusers/search/(:any)/(:any)'] = "admin/manageusers/searchUser/$1/$2";

// manage special deals emails
$route['admin/specialdeals/index'] = "admin/specialdeals/index";
$route['admin/specialdeals/compose'] = "admin/specialdeals/compose";
$route['admin/specialdeals/compose/(:any)'] = "admin/specialdeals/compose/$1/$2";
$route['admin/specialdeals/composeemails'] = "admin/specialdeals/composeEmail";

// process email queue
$route['admin/process_email_queue/(:any)'] = "admin/process_email_queue/$1";


$route['admin/(:any)'] = "admin/admin/$1";
$route['404_override'] = '';


/**frontend routes**/


/* Routes for fundrasing or charity  */
$route['(:any)/raiseit/editabout/(:any)'] = "raiseit/editabout/$2/$1";
$route['raiseit/editabout/(:any)'] = "raiseit";
$route['(:any)/raiseit/assigntarget/(:any)'] = "raiseit/assigntarget/$2/$1";
$route['raiseit/assigntarget/(:any)'] = "raiseit";

//routes for aboutit
$route['about-it'] = "aboutit/index";
$route['(:any)/about-it'] = "aboutit/index/$1";

//routes for shopit
$route['shopit'] = "shopit/index";
$route['(:any)/shopit'] = "shopit/index/$1";

//routes for frmakeit
$route['frmakeit'] = "frmakeit/showMakeit";
$route['(:any)/frmakeit'] = "frmakeit/showMakeit/$1";


//new routes for compaign

$route['compaign/addcompain'] = "compaign/addcompain";
$route['(:any)/compaign/addcompain'] = "compaign/addcompain/$1";

$route['compaign/adddabout'] = "compaign/adddabout";
$route['(:any)/compaign/adddabout'] = "compaign/adddabout/$1";

$route['compaign/addemail'] = "compaign/addemail";
$route['(:any)/compaign/addemail'] = "compaign/addemail/$1";

$route['compaign/compainamount/(:any)'] = "compaign/compainamount/$1";
$route['(:any)/compaign/compainamount/(:any)'] = "compaign/compainamount/$2/$1";

$route['compaign/publishraiseit'] = "compaign/publishraiseit";
$route['(:any)/compaign/publishraiseit'] = "compaign/publishraiseit/$1";

$route['compaign/AmbassadorEmail'] = "compaign/AmbassadorEmail";
$route['(:any)/compaign/AmbassadorEmail'] = "compaign/AmbassadorEmail/$1";

$route['compaign/shopperEmail'] = "compaign/shopperEmail";
$route['(:any)/compaign/shopperEmail'] = "compaign/shopperEmail/$1";

$route['compaign/shoppertoshooperEmail'] = "compaign/shoppertoshooperEmail";
$route['(:any)/compaign/shoppertoshooperEmail'] = "compaign/shoppertoshooperEmail/$1";

$route['compaign/previewEmails/(:any)'] = "compaign/previewEmails/$1";
$route['(:any)/compaign/previewEmails/(:any)'] = "compaign/previewEmails/$2/$1";

$route['compaign/previewraise'] = "compaign/previewraise";
$route['(:any)/compaign/previewraise'] = "compaign/previewraise/$1";

$route['compaign/saveall'] = "compaign/saveall";
$route['(:any)/compaign/saveall'] = "compaign/saveall/$1";

$route['(:any)/compaign/closed/(:any)'] = "compaign/closed/$1/$2";
$route['(:any)/compaign/histroy'] = "compaign/histroy/$1";

$route['compaign/preview'] = "compaign/preview";
$route['(:any)/compaign/preview'] = "compaign/preview/$1";

$route['compaign/previewdescripion'] = "compaign/previewdescripion";
$route['(:any)/compaign/previewdescripion'] = "compaign/previewdescripion/$1";

$route['compaign/ambassadorPerview'] = "compaign/ambassadorPerview";
$route['(:any)/compaign/ambassadorPerview'] = "compaign/ambassadorPerview/$1";


$route['compaign/shopperPerview'] = "compaign/shopperPerview";
$route['(:any)/compaign/shopperPerview'] = "compaign/shopperPerview/$1";

$route['compaign/shopper2Shopper'] = "compaign/shopper2Shopper";
$route['(:any)/compaign/shopper2Shopper'] = "compaign/shopper2Shopper/$1";


//routes for about
$route['about'] = "about/index";
$route['(:any)/about'] = "about/index/$1";
$route['(:any)/about/newC'] = "about/newC/$1";
$route['(:any)/about/compain/(:any)'] = "about/compain/$1/$2";
$route['(:any)/about/closed/(:any)'] = "about/closed/$1/$2";
$route['(:any)/about/histroy'] = "about/histroy/$1";


//routes for about email
$route['about/abouteamil'] = "about/abouteamil";
$route['(:any)/about/abouteamil'] = "about/abouteamil/$1";
$route['about/preview'] = "about/preview";
$route['(:any)/about/preview'] = "about/preview/$1";



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
$route['(:any)/signup/fundrasing_signup'] = "signup/fundrasing_signup/$1";
$route['signup/affliate/(:any)'] = "signup/affliate/$1";
$route['(:any)/signup/affliate'] = "signup/affliate/$2/$1";
$route['signup/usersearch'] = "signup/usersearch";
$route['signup/usersearch/(:any)'] = "signup/usersearch/$1";

// routes for logout
$route['(:any)/logout'] = "login/logout/$1";
$route['logout'] = "login/logout/$1";

// Routes for forgetpassword
$route['recoverpassword'] = "forgetpassword/index";
$route['resetPassword/(:any)/(:any)'] = "forgetpassword/resetPassword/$1/$2";

// route to unset session
$route['sessionunset'] = "index/sessionUnset";
$route['(:any)/sessionunset'] = "index/sessionUnset/$1";

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


//offers routes
$route['special-offer/(:any)'] = "store/specialDeals/$1";
$route['(:any)/special-offer/(:any)'] = "store/specialDeals/$2/$1";

// trends & stores common
$route['store-visit/(:any)'] = "store/storeVisit/$1";
$route['(:any)/store-visit/(:any)'] = "store/storeVisit/$2/$1";

// coupons handshake
$route['coupon-visit/(:any)'] = "store/couponVisit/$1";
$route['(:any)/coupon-visit/(:any)'] = "store/couponVisit/$2/$1";

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

$route['about-karmora-fundraising'] = "pages/index/about-karmora-fundraising";
$route['(:any)/about-karmora-fundraising'] = "pages/index/about-karmora-fundraising/$1";

$route['how-to-post-a-karmora-commercial-on-facebook'] = "pages/index/how-to-post-a-karmora-commercial-on-facebook";
$route['(:any)/how-to-post-a-karmora-commercial-on-facebook'] = "pages/index/how-to-post-a-karmora-commercial-on-facebook/$1";

$route['how-to-tweet-a-karmora-commercial-on-twitter'] = "pages/index/how-to-tweet-a-karmora-commercial-on-twitter";
$route['(:any)/how-to-tweet-a-karmora-commercial-on-twitter'] = "pages/index/how-to-tweet-a-karmora-commercial-on-twitter/$1";

$route['how-to-pin-a-karmora-commercial-on-pinterest'] = "pages/index/how-to-pin-a-karmora-commercial-on-pinterest";
$route['(:any)/how-to-pin-a-karmora-commercial-on-pinterest'] = "pages/index/how-to-pin-a-karmora-commercial-on-pinterest/$1";

// reporting routes
$route['reporting'] = "reporting/index/$1";
//$route['reporting/kashBack'] = "reporting/kashBack/$1";
$route['(:any)/cash-back'] = "reporting/kashBack/$1";
//$route['reporting/community'] = "reporting/myCommunity/$1";
$route['(:any)/community'] = "reporting/myCommunity/$1";
//$route['reporting/goodKarmora'] = "reporting/goodKarmora/$1";
$route['(:any)/good-karmora'] = "reporting/goodKarmora/$1";
$route['(:any)/summary'] = "reporting/cashOut/$1";
$route['(:any)/compaign'] = "compaign/index/$1";
$route['(:any)/compaign/(:any)'] = "compaign/index/$1/$2";
// routes for dashboard
//$route['dashboard'] = "dashboard/index/$1";
$route['(:any)/dashboard'] = "dashboard/index/$1";

// route for assign target
$route['(:any)/reporting/assigntarget/(:any)/(:any)/(:any)'] = "reporting/assigntarget/$1/$2/$3/$4";

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
$route['forum'] = "forum/index/1/7";
$route['(:any)/forum'] = "forum/index/1/7/$1";
$route['forum/add'] = "forum/add";
$route['(:any)/forum/add'] = "forum/add/$1";
$route['forum/topic/(:any)'] = "forum/topic/$1";
$route['(:any)/forum/topic/(:any)'] = "forum/topic/$2/$1";
$route['(:any)/forum/detail/(:any)'] = "forum/detail/$2/$1";
$route['forum/detail/(:any)'] = "forum/detail/$1";
$route['forum/index/(:any)/(:any)'] = "forum/index/$1/$2";
$route['(:any)/forum/index/(:any)/(:any)'] = "forum/index/$2/$3/$1";

$route['forum/karmorafaq/(:any)'] = "forum/karmorafaq/$1/1/10";
$route['(:any)/forum/karmorafaq/(:any)/(:any)/(:any)'] = "forum/karmorafaq/$2/$3/$4/$1";
$route['(:any)/forum/karmorafaq/(:any)'] = "forum/karmorafaq/$2/1/10/$1";
$route['forum/karmorafaq/(:any)/(:any)/(:any)'] = "forum/karmorafaq/$1/$2/$3";

// routes for marketing
$route['(:any)/marketing'] = "marketing/index/$1";

// routes for pay4mypurchase
$route['Pay4MyPurchase'] = "paymypurchase/index";
$route['(:any)/Pay4MyPurchase'] = "paymypurchase/index/$1";
$route['Pay4MyPurchase/share'] = "paymypurchase/share";
$route['(:any)/Pay4MyPurchase/share'] = "paymypurchase/share/$1";
$route['Pay4MyPurchase/vote'] = "paymypurchase/vote";
$route['(:any)/Pay4MyPurchase/vote'] = "paymypurchase/vote/$1";
$route['Pay4MyPurchase/preview'] = "paymypurchase/preview";
$route['(:any)/Pay4MyPurchase/preview'] = "paymypurchase/preview/$1";
$route['(:any)/Pay4MyPurchase/karmora_likes/(:any)'] = "paymypurchase/karmora_likes/$1/$2";
//$route['Pay4MyPurchase/rule'] = "paymypurchase/rule";
$route['(:any)/Pay4MyPurchase/rule'] = "paymypurchase/rule/$1";
$route['Pay4MyPurchase/sharetowin'] = "paymypurchase/sharetowin";
$route['(:any)/Pay4MyPurchase/sharetowin'] = "paymypurchase/sharetowin/$1";
$route['Pay4MyPurchase/approved'] = "paymypurchase/approved";
$route['Pay4MyPurchase/participated'] = "paymypurchase/participated";
$route['(:any)/Pay4MyPurchase/approved'] = "paymypurchase/approved/$1";
$route['(:any)/Pay4MyPurchase/participated'] = "paymypurchase/participated/$1";
$route['(:any)/Pay4MyPurchase/winit_signup'] = "paymypurchase/winit_signup/$1";
$route['(:any)/Pay4MyPurchase/validate_shoper_first_form'] = "paymypurchase/validate_shoper_first_form/$1";

$route['pay4mypurchase-rules'] = "pages/index/pay4mypurchase-rules";
$route['(:any)/pay4mypurchase-rules'] = "pages/index/pay4mypurchase-rules/$1";

$route['(:any)/win'] = "win/index/$1";
$route['win'] = "win/index";
$route['(:any)/win/wincircle'] = "win/wincircle/$1";
$route['win/wincircle'] = "win/wincircle";

// routes for whereiskavin
$route['WhereIsKarmoraKevin'] = "whereiskevin/index";
$route['(:any)/WhereIsKarmoraKevin'] = "whereiskevin/index/$1";
$route['WhereIsKarmoraKevin/share'] = "whereiskevin/share";
$route['(:any)/WhereIsKarmoraKevin/share'] = "whereiskevin/share/$1";
$route['(:any)/WhereIsKarmoraKevin/vote'] = "whereiskevin/vote/$1";
$route['(:any)/WhereIsKarmoraKevin/karmora_likes/(:any)'] = "whereiskevin/karmora_likes/$1/$2";
//$route['paymypurchase/rule'] = "paymypurchase/rule";
$route['(:any)/WhereIsKarmoraKevin/rule'] = "whereiskevin/rule/$1";
$route['(:any)/WhereIsKarmoraKevin/preview'] = "whereiskevin/preview/$1";
$route['WhereIsKarmoraKevin/preview'] = "whereiskevin/preview";
$route['WhereIsKarmoraKevin/sharetowin'] = "whereiskevin/sharetowin";
$route['(:any)/WhereIsKarmoraKevin/sharetowin'] = "whereiskevin/sharetowin/$1";
$route['(:any)/WhereIsKarmoraKevin/approved'] = "whereiskevin/approved/$1";
$route['(:any)/WhereIsKarmoraKevin/winit_signup'] = "whereiskevin/winit_signup/$1";
$route['(:any)/WhereIsKarmoraKevin/validate_shoper_first_form'] = "whereiskevin/validate_shoper_first_form/$1";
$route['WhereIsKarmoraKevin/album'] = "whereiskevin/album";
$route['(:any)/WhereIsKarmoraKevin/album'] = "whereiskevin/album/$1";
$route['WhereIsKarmoraKevin/saveimage/(:any)'] = "whereiskevin/saveimage/$1";
$route['(:any)/WhereIsKarmoraKevin/saveimage/(:any)'] = "whereiskevin/saveimage/$2/$1";


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


// routes for tresurechest
$route['treasurechest'] = "tresurechest/index";
$route['(:any)/treasurechest'] = "tresurechest/index/$1";

// routes for tresurechest
$route['cashmeout/ajexresponce'] = "cashmeout/ajexresponce";
$route['(:any)/cashmeout/ajexresponce'] = "cashmeout/ajexresponce/$1";
$route['cashmeout'] = "cashmeout/index";
$route['(:any)/cashmeout'] = "cashmeout/index/$1";


// routes for coupons
$route['coupons'] = "coupon/index";
$route['(:any)/coupons'] = "coupon/index/$1";
$route['coupons/index/(:any)/(:any)'] = "coupon/index/$1/$2";
$route['(:any)/coupons/index/(:any)/(:any)'] = "coupon/index/$2/$3/$1";
$route['coupons/(:any)'] = "coupon/jumpTostore/$2/$1";
$route['(:any)/coupons/(:any)'] = "coupon/jumpTostore/$1/$2";
$route['coupons/(:any)/(:any)/(:any)'] = "coupon/jumpTostore/$2/$1/$3/$4";
$route['(:any)/coupons/(:any)/(:any)/(:any)'] = "coupon/jumpTostore/$1/$2/$3/$4";


// routes for favourite coupons
$route['coupon/favourtiec/(:any)'] = "coupon/favourtiec/$1";
$route['(:any)/coupon/favourtiec/(:any)'] = "coupon/favourtiec/$2/$1";

// routes for favourite 
$route['myfavorites'] = "myfavorites";
$route['(:any)/myfavorites'] = "myfavorites/index/$1";
$route['myfavorites/index/(:any)/(:any)'] = "myfavorites/index/$2/$1";
$route['(:any)/myfavorites/index/(:any)/(:any)'] = "myfavorites/index/$1/$2/$3";

// routes for raiseit
$route['raise-it'] = "raiseit/index";
$route['(:any)/raise-it'] = "raiseit/index/$1";
$route['raiseit/city/(:any)'] = "raiseit/city/$1";
$route['(:any)/raise-it/city/(:any)'] = "raiseit/city/$2/$1";
$route['raiseit/zipcode/(:any)'] = "raiseit/zipcode/$1";
$route['(:any)/raiseit/zipcode/(:any)'] = "raiseit/zipcode/$2/$1";

//routes for makeit
$route['make-it'] = "makeit/showMakeit";
$route['(:any)/make-it'] = "makeit/showMakeit/$1";
//routes for contact us
$route['contact-us'] = "contactus/index";
$route['(:any)/contact-us'] = "contactus/index/$1";

//routes for karmora videos
//$route['video'] = 'karmoravideos/index';
//$route['(:any)/video'] = 'karmoravideos/index/$1';
$route['video'] = 'karmoravideos/index';
$route['(:any)/video'] = 'karmoravideos/index/$1';
$route['video/(:any)'] = 'karmoravideos/play/$1';
$route['(:any)/video/(:any)'] = 'karmoravideos/play/$2/$1';

// routes for gift today
$route['(:any)/gift-today'] = 'gifttoday/index/$1';

// call backs for pay 4 my purchase
$route['Pay4MyPurchase/sharetowin/yahoo_callback'] = "paymypurchase/yahoo_callback";
$route['(:any)/Pay4MyPurchase/sharetowin/yahoo_callback'] = "paymypurchase/yahoo_callback/$1";
$route['Pay4MyPurchase/sharetowin/hotmail_callback'] = "paymypurchase/hotmail_callback";
$route['(:any)/Pay4MyPurchase/sharetowin/hotmail_callback'] = "paymypurchase/hotmail_callback/$1";
$route['Pay4MyPurchase/sharetowin/gmail_callback'] = "paymypurchase/gmail_callback";
$route['(:any)/Pay4MyPurchase/sharetowin/gmail_callback'] = "paymypurchase/gmail_callback/$1";
$route['Pay4MyPurchase/sharetowin/gmail_callback/(:any)'] = "paymypurchase/gmail_callback/$1";



// general routes {keep this section always at last}
$route['(:any)/test'] = "test/index/$1";
$route['(:any)'] = "index/index/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
