<?php

/**
 * The AuthorizeNet PHP SDK. Include this file in your project.
 *
 * @package AuthorizeNet
 */
require dirname(__FILE__) . '/lib/shared/AuthorizeNetRequest.php';
require dirname(__FILE__) . '/lib/shared/AuthorizeNetTypes.php';
require dirname(__FILE__) . '/lib/shared/AuthorizeNetXMLResponse.php';
require dirname(__FILE__) . '/lib/shared/AuthorizeNetResponse.php';
require dirname(__FILE__) . '/lib/AuthorizeNetAIM.php';
require dirname(__FILE__) . '/lib/AuthorizeNetARB.php';
require dirname(__FILE__) . '/lib/AuthorizeNetCIM.php';
require dirname(__FILE__) . '/lib/AuthorizeNetSIM.php';
require dirname(__FILE__) . '/lib/AuthorizeNetDPM.php';
require dirname(__FILE__) . '/lib/AuthorizeNetTD.php';
require dirname(__FILE__) . '/lib/AuthorizeNetCP.php';

if (class_exists("SoapClient")) {
    require dirname(__FILE__) . '/lib/AuthorizeNetSOAP.php';
}

/**
 * Exception class for AuthorizeNet PHP SDK.
 *
 * @package AuthorizeNet
 */
class authorizenet /*AuthorizeNetException*/ extends Exception {
    
}

/* $g_loginname = "4DXtz7532"; // Keep this secure.
  $g_transactionkey = "997M66434MGbxaeF"; // Keep this secure.
  $g_apihost = "apitest.authorize.net";
  $g_apipath = "/xml/v1/request.api"; */

/* Live Credentials */
define('API_LOGIN_NAME', '4fqtRK3W7fM');
define('API_TRANSACTION_KEY', '56ZQ558A6AyDc3vZ');
define("AUTHORIZENET_SANDBOX",false);       // Set to false to test against production
define("TEST_REQUEST", "FALSE");           // You may want to set to true if testing against production


/* Test Credentials */
/*
define('API_LOGIN_NAME', '3wX3X2gs2b');
define('API_TRANSACTION_KEY', '7b932Y6fM4W5Wmn3');
*/