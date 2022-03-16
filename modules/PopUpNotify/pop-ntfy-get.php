<?php
session_start();

chdir('../../');

if(!isset($_SESSION['authenticated_user_id']) || $_SESSION['authenticated_user_id'] == "") {
    echo json_encode(array('status' => -10, 'msg' => 'Invalid Login'));
    exit(0);
}

/*
if(!isset($_GET['popid']) || $_GET['popid'] == ''){
    echo json_encode(array('status' => 0, 'msg' => 'Debug, ' . date("Y-m-d") . ' : 000 : ' . date("Y-m-d H:i:s")));
    exit(0);
}
*/

require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $adb;

$curr_uid = $_SESSION['authenticated_user_id'];
$curr_date = date("Y-m-d");

$result = $adb->query("SELECT p.id, p.pop_title, p.pop_text, p.pop_date, p.owner_id, u.user_name as owner_name
 , pu.user_id, pu.is_active, pu.next_run
FROM vtiger_users u inner join tblPopupNotify p on u.id = p.owner_id
inner join tblPopupNotify_Users pu on p.id = pu.popid
Where pu.is_active = 1 
And (
  (
    pu.user_id = 0
    And
    0 = (Select Count(popid) From tblPopupNotify_Users pu2 Where pu2.popid = p.id And pu2.user_id = {$curr_uid})
  )
  OR
  (pu.user_id = {$curr_uid})
)
And (
  (p.pop_date is null And pu.next_run is null)
  OR
  (p.pop_date is null And pu.next_run <= '{$curr_date}')
  OR
  (p.pop_date <= '{$curr_date}' And pu.next_run is null)
  OR
  (p.pop_date <= '{$curr_date}' And pu.next_run <= '{$curr_date}')
)
");

/*
1. Show On Login            And     it hasn't shown
2. Show On Login            And     it has been shown before now and set to repeat
3. Show at specified time   And     it hasn't shown
4. Show at specified time   And     it has been shown before now and set to repeat
*/


if(!$result){
    echo json_encode(array('status' => 0, 'msg' => $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()));
    exit(0);
}
    $res_count = $adb->num_rows($result);
    $rows = array();
    for($k=0; $k < $res_count; $k++){
		$result->Move($k);
		$rowdata = $adb->change_key_case($result->FetchRow());
        $rows[] = $rowdata;
        //$user_name = $adb->query_result($result,$k,'user_name');
    }

echo json_encode(array('status' => 1, 'popupArr' => $rows));
exit(1);

?>
