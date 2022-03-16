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


if(!isset($_GET['popid']) || $_GET['popid'] == ''){
    echo json_encode(array('status' => 0, 'msg' => 'Invalid Params, ' . json_encode((array)$_GET)));
    exit(0);
}


require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $adb;

$curr_uid = $_SESSION['authenticated_user_id'];
$poid=$_GET['popid'];

//Get User IF Youe Greate POP Updata comment stst view

$SELECT="select * from tblPopupNotify WHERE owner_id=? AND id =?";
$paramter=array($curr_uid,$poid);
$result=$adb->pquery($SELECT,$paramter);
if($adb->num_rows($result) >= 1)
       {
           //UPDate Comment Stat
           $UPDATE="UPDATE tblPopup_Comment SET view_stat =1 WHERE popid=? ";
           $Parmt=array($poid);
           $resu=$adb->pquery($UPDATE,$Parmt);
       }

$result = $adb->query("Select C.id, C.user_id,U.first_name, U.last_name, cmnt_date, cmnt_text
    From vtiger_users U Inner join tblPopup_Comment C On U.id = C.user_id
    Where popid = {$_GET['popid']}
    And (
       ({$curr_uid} = (Select owner_id From tblPopupNotify Where id = {$_GET['popid']}))
        OR
       ((Select Count(user_id) From tblPopupNotify_Users pu Where popid = {$_GET['popid']} And user_id in (0, {$curr_uid}) ) > 0)
    )
    Order by cmnt_date DESC");


/*
//use owner_id to prevent a user from delete popup of other users
$result = $adb->query("Select C.id, C.user_id, U.user_name, cmnt_date, cmnt_text 
    From tblPopup_Comment C Inner join vtiger_users U On U.id = C.user_id 
    Where popid = {$_GET['popid']} And {$owner_id} = (Select owner_id From tblPopupNotify Where id = {$_GET['popid']}) 
    Order by cmnt_date DESC");
*/

if(!$result){
    echo json_encode(array('status' => 0, 'msg' => $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()));
    exit(0);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>PopUpNotify Comment Inbox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="/libraries/jquery/jquery-ui/css/custom-theme/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/libraries/bootstrap/css/bootstrap.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/libraries/develop/modules.css" type="text/css" media="screen" />
    <link rel="stylesheet" media="screen" type="text/css" href="/libraries/jquery/datepicker/css/datepicker.css" />

    <style type="text/css">
        .tbl-cmnts {
            border-top: 1px solid #989898;
            border-left: 1px solid #989898;
            margin: 0 auto;
        }
        .tbl-cmnts th {
            background-color:#eee;
        }
        .tbl-cmnts th, .tbl-cmnts td{
            border-right: 1px solid #989898;
            border-bottom: 1px solid #989898;
            padding: 7px 15px;
            white-space: nowrap;
        }
        .tbl-cmnts .cmnt-txt{
            white-space: pre-wrap;
        }
        body{
            padding:9px 21px;
        }
    </style>

    <script type="text/javascript" src="/libraries/jquery/jquery.min.js"></script>
</head>
<body>
    <table class="tbl-cmnts" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Date</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <?
    $result_count = $adb->num_rows($result);
    for($k=0; $k < $result_count; $k++){
        $cmnt_id = $adb->query_result($result,$k,'id');
        $first_name = $adb->query_result($result,$k,'first_name');
        $last_name = $adb->query_result($result,$k,'last_name');
        $user_name = $first_name.' '.$last_name;
        $cmnt_date = $adb->query_result($result,$k,'cmnt_date');
        $cmnt_text = $adb->query_result($result,$k,'cmnt_text');
        echo "<tr>
                <td>" . ($k+1) . "</td>
                <td>{$user_name}</td>
                <td>" . str_replace(' 00:00:00', '', $cmnt_date) . "</td>
                <td class='cmnt-txt'>{$cmnt_text}</td>
            </tr>";
    }
            ?>
        </tbody>
    </table>
</body>
</html>