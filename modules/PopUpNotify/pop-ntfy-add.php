<?php
session_start();

chdir('../../');

if(!isset($_SESSION['module_user_id']) || !isset($_SESSION['authenticated_user_id']) 
        || $_SESSION['module_user_id'] != $_SESSION['authenticated_user_id']){   // || $_SESSION['module_user_isadmin'] !== 1
    echo json_encode(array('status' => 0, 'msg' => 'No Permission'));
    exit(0);
}

if(!isset($_POST['popid']) || !isset($_POST['pop_title']) || !isset($_POST['pop_text']) || !isset($_POST['pop_date']) || !isset($_POST['reactivate_child'])){
    echo json_encode(array('status' => 0, 'msg' => 'Invalid Params, ' . json_encode((array)$_POST)));
    exit(0);
}
    /*
    echo json_encode(array('status' => 0, 'msg' => 'PPPP, ' . $_POST['reactivate_child']));
    exit(0);
    */


require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $adb;

$owner_id = $_SESSION['authenticated_user_id'];
$pop_date = trim($_POST['pop_date']);
if($pop_date === 'NULL' || $pop_date === '')
    $pop_date = "NULL";
else{
    $pop_date=date("Y-m-d H:i:s");
    $pop_date = "'" . $pop_date . "'";
   
    
}
//date("Y-m-d H:i:s", strtotime($pop_date));
if($_POST['popid']==="0"){  //New Popup
    $result = $adb->query("Insert Into tblPopupNotify (owner_id, pop_title, pop_text, pop_date) 
        Values ({$owner_id}, '{$_POST['pop_title']}', '{$_POST['pop_text']}', {$pop_date})");
    
}
else{   //Update popup

    //check if date is changed then update the date and is_active for child records in tblPopupNotify_Users
    if($_POST['reactivate_child']==="1"){
        $result = $adb->query("Update tblPopupNotify_Users Set is_active = 1, next_run=null
                        Where popid = {$_POST['popid']} 
                        And {$owner_id} = (Select owner_id From tblPopupNotify Where id = {$_POST['popid']})");
        if(!$result){
            echo json_encode(array('status' => 0, 'msg' => "Q101: " . $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()));
            exit(0);
        }
    }
    $result = $adb->query("Update tblPopupNotify Set 
                            pop_title = '{$_POST['pop_title']}', pop_text = '{$_POST['pop_text']}', pop_date = {$pop_date}
                            Where id = {$_POST['popid']} And owner_id = {$owner_id}");
}
if(!$result){
    echo json_encode(array('status' => 0, 'msg' => $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()));
    exit(0);
}
else{
    echo json_encode(array('status' => 1, 'msg' => 'OK'));
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