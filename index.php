<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
 
 // Change the following setting as needed.
// $host = "localhost";
// $db_name = 'solution_vt-18-2';
// $db_username = "solution_vt182";
// $db_password = "zbJ)68?]HjqF";
// $convert_to = "utf8_general_ci";

// try {
//  $conn = new PDO("mysql:host=$host;dbname=$db_name", $db_username, $db_password);
//  // set the PDO error mode to exception
//  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//  $sql = "SHOW TABLES";

//  print "Following SQL Statements have been executed. <br><br>";

//  foreach ($conn->query($sql) as $row) {
//   	 $table_name = $row['Tables_in_' . $db_name];
//   	 $sql = 'ALTER TABLE ' . $table_name . ' CONVERT TO CHARACTER SET utf8 COLLATE ' . $convert_to;
//   	 $output = $sql . '<br>';

//   	 print $output;
//   	 $conn->query($sql);
//  }

// }
// catch(PDOException $e)
// {
//  echo "Connection failed: " . $e->getMessage();
// }

//Overrides GetRelatedList : used to get related query
//TODO : Eliminate below hacking solution
include_once 'config.php';
include_once 'include/Webservices/Relation.php';

include_once 'vtlib/Vtiger/Module.php';
include_once 'includes/main/WebUI.php';

$webUI = new Vtiger_WebUI();
$webUI->process(new Vtiger_Request($_REQUEST, $_REQUEST));
