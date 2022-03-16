<?php
session_start();

chdir('../../');

if(!isset($_SESSION['module_user_id']) || !isset($_SESSION['authenticated_user_id']) 
        || $_SESSION['module_user_id'] != $_SESSION['authenticated_user_id']){   // || $_SESSION['module_user_isadmin'] !== 1
    echo json_encode(array('status' => 0, 'msg' => 'No Permission'));
    exit(0);
}

if(!isset($_POST['popid']) || !isset($_POST['userid'])){
    echo json_encode(array('status' => 0, 'msg' => 'Invalid Params, ' . json_encode((array)$_POST)));
    exit(0);
}


require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $adb;

if($_POST['userid']==="0"){
    $result = $adb->query("Delete From tblPopupNotify_Users Where popid = {$_POST['popid']}");
    if(!$result){
        echo json_encode(array('status' => 0, 'msg' => $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()));
        exit(0);
    }
}

$result = $adb->query("Insert Into tblPopupNotify_Users (popid, user_id, is_active) Values ({$_POST['popid']}, {$_POST['userid']}, 1)");
if(!$result){
    echo json_encode(array('status' => 0, 'msg' => $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()));
    exit(0);
}
else{
    echo json_encode(array('status' => 1, 'msg' => 'Insert OK'));
    exit(0);
}


/*
echo "database->ErrorMsg(): {$adb->database->ErrorMsg()} <br/><br/>";
echo "database->ErrorNo(): {$adb->database->ErrorNo()} <br/><br/>";
echo "result: <br/><br/>";
echo '<pre>';
var_dump($result);
echo '</pre>';
*/


?>