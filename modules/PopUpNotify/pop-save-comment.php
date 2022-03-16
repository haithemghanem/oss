<?php
session_start();

chdir('../../');

/*
if(!isset($_SESSION['module_user_id']) || !isset($_SESSION['authenticated_user_id']) 
        || $_SESSION['module_user_id'] != $_SESSION['authenticated_user_id']){   // || $_SESSION['module_user_isadmin'] !== 1
    echo json_encode(array('status' => 0, 'msg' => 'No Permission'));
    exit(0);
}
*/

if(!isset($_SESSION['authenticated_user_id']) || $_SESSION['authenticated_user_id'] == "") {
    echo json_encode(array('status' => 0, 'msg' => 'Invalid Login'));
    exit(0);
}


if(!isset($_POST['popid']) || $_POST['popid'] == '' || !isset($_POST['cmnt-txt']) || $_POST['cmnt-txt'] == '' 
    || !isset($_POST['rept-date']) || $_POST['rept-date'] == ''){
    echo json_encode(array('status' => 0, 'msg' => 'Invalid Params, ' . json_encode((array)$_POST)));
    exit(0);
}


require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $adb;

$curr_uid = $_SESSION['authenticated_user_id'];

$dt = $_POST['rept-date'];
$dtNow = date("Y-m-d H:i:s");
$is_active = 1;
if($dt == "dt-null"){
    $dt = $dtNow;  //set to current date to know the last date of showing this popup
    $is_active = 0;
}

//this query will not work if popup set for [All Users] because tblPopupNotify_Users->user_id will be 0
//$qstr = "Update tblPopupNotify_Users set is_active = {$is_active} , next_run = '{$dt}' Where popid = {$_POST['popid']} And user_id = {$curr_uid}";

$qstr = "Delete From tblPopupNotify_Users Where popid = {$_POST['popid']} And user_id = {$curr_uid}";
$result = $adb->query($qstr);
if(!$result){
    echo json_encode(array('status' => 0, 'msg' => 'DB ERR 101: ' . $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()
                , query => $qstr));
    exit(0);
}

$qstr = "Insert Into tblPopupNotify_Users (popid, user_id, is_active, next_run) Values ({$_POST['popid']}, {$curr_uid}, {$is_active}, '{$dt}')";
$result = $adb->query($qstr);
if(!$result){
    echo json_encode(array('status' => 0, 'msg' => 'DB ERR 102: ' . $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()
                , query => $qstr));
    exit(0);
}

$cmnt = $_POST["cmnt-txt"];
$stat=0;
$result = $adb->query("Insert Into tblPopup_Comment (popid, user_id, cmnt_date, cmnt_text ,view_stat) Values
    ({$_POST['popid']}, {$curr_uid}, '{$dtNow}', '{$cmnt}' ,{$stat})");
if(!$result){
    echo json_encode(array('status' => 0, 'msg' => 'DB ERR 103: ' . $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()));
    exit(0);
}


else{
    echo json_encode(array('status' => 1, 'msg' => 'OK'));
    exit(0);
}



?>