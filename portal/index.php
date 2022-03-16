<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.2
 * ("License.txt"); You may not use this file except in compliance with the License
 * The Original Code is: Vtiger CRM Open Source
 * The Initial Developer of the Original Code is Vtiger.
 * Portions created by Vtiger are Copyright (C) Vtiger.
 * All Rights Reserved.
 ************************************************************************************/

version_compare(PHP_VERSION, '5.5.0') <= 0 ? error_reporting(E_WARNING & ~E_NOTICE & ~E_DEPRECATED) : error_reporting(E_WARNING & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT); // PRODUCTION
ini_set('display_errors','on'); version_compare(PHP_VERSION, '5.5.0') <= 0 ? error_reporting(E_WARNING & ~E_NOTICE & ~E_DEPRECATED) : error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);   // DEBUGGING


include_once dirname(__FILE__).'/classes/Portal/Loader.php';
if (!file_exists(PORTAL_APP_DIR . '/config.php')) {
    header ("Content-type: text/plain");
    echo "Please make copy of config.sample.php as config.php and update.";
    exit;
}

/* Class check force inclusion and activate required runtime config */
if (!class_exists('Portal_Config')) {
	header ("Content-type: text/plain");
    echo "Portal class loader not working as expected.";
    exit;
}

$portalMainController = new Portal_Main_Controller();
$portalMainController->dispatch(Portal_Request::parseFormOrJSONRequest());
