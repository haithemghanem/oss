<?php
session_start();

chdir('../../');

if(!isset($_SESSION['authenticated_user_id']) || $_SESSION['authenticated_user_id'] == "") {
    echo json_encode(array('status' => -10, 'msg' => 'Invalid Login'));
    exit(0);
}

if(!isset($_GET['popid']) || $_GET['popid'] == '' || $_GET['popid'] == 'undefined'){
    echo json_encode(array('status' => 0, 'msg' => 'Invalid Params, ' . json_encode((array)$_GET)));
    exit(0);
}


require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $adb;

//use curr_uid to prevent user from showing popup for another users
$curr_uid = $_SESSION['authenticated_user_id'];

$result = $adb->query("SELECT p.id, p.pop_title, p.pop_text, p.pop_date, p.owner_id, u.user_name as owner_name
 , pu.user_id, pu.is_active, pu.next_run
FROM vtiger_users u inner join tblPopupNotify p on u.id = p.owner_id
inner join tblPopupNotify_Users pu on p.id = pu.popid
Where p.id = {$_GET['popid']} And pu.is_active = 1 And (pu.user_id = 0 OR pu.user_id = {$curr_uid})
");

if(!$result){
    echo json_encode(array('status' => 0, 'msg' => $adb->database->ErrorNo() . ': ' . $adb->database->ErrorMsg()));
    exit(0);
}
$count = $adb->num_rows($result);
if($count < 1){
    echo json_encode(array('status' => 0, 'msg' => "Popup not found: " . $_GET['popid']));
    exit(0);
}

$pop_title = $adb->query_result($result, 0, 'pop_title');
$pop_text = $adb->query_result($result, 0, 'pop_text');
$owner_name = $adb->query_result($result, 0, 'owner_name');

?>
<!DOCTYPE html>
<html>
<head>
    <title>PopUpNotify Comment Inbox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="/libraries/bootstrap/css/bootstrap.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/libraries/develop/modules.css" type="text/css" media="screen" />
    <link rel="stylesheet" media="screen" type="text/css" href="/libraries/jquery/datepicker/css/datepicker.css" />
    <link rel="stylesheet" href="/libraries/jquery/jquery-ui-1.12.1.custom/jquery-ui.css" type="text/css" />

    <style type="text/css">
        body{
            padding:0;
        }
        .dv-pop-card{
            border-radius:0;
        }
        fieldset {
            padding: 5px 10px;
            margin: 0;
            border: 1px groove #333;
        }
        legend {
            padding: 0 2px;
            margin-bottom: 0;
            font-size: 14px;
            line-height: 25px;
            color: #333333;
            border: 0 none;
            border-bottom: 0 none;
            width: auto;
        }
        #tx-nextrun{
            margin: 0 0 4px 0;        
        }
        #tx-nextrun:disabled{
            background-color:#999;
        }
    </style>

    <script type="text/javascript" src="/libraries/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="/libraries/jquery/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script type="text/javascript">
        $( function() {
            $("#chk-repeat")[0].checked=true;
            var dtObj = new Date();
            dtObj.setDate(dtObj.getDate() + 1);
            var d = dtObj.getDate();
            if(d <= 9) d = "0" + d;
            var m = (dtObj.getMonth() + 1);
            if(m <= 9) m = "0" + m;
            dtObj = d + '-' + m + '-' + dtObj.getFullYear();
            $("#tx-nextrun")[0].value = dtObj;
            $("#chk-repeat").checkboxradio();
            $("#tx-nextrun").datepicker({ dateFormat: "dd-mm-yy" });
            setRepeatInputs();
        } );
        function setRepeatInputs(){
            if($("#chk-repeat")[0].checked){
                $("#tx-nextrun").attr("disabled", false);
            }
            else{
                $("#tx-nextrun").attr("disabled", true);
            }
        }
    </script>
</head>
<body>
    <div class="dv-pop-card" id="dv-pop-show" >
        <div class="dv-col1" style="width: 100%;">
            <span class="entry-title">Popup ID: </span>
            <span class="entry-value" id="pop-entry-id"><? echo $_GET['popid'] ?></span>
            <br />
            <span class="entry-title">Creator: </span>
            <span class="entry-value"><? echo $owner_name ?></span>
            <br />
            <span class="entry-title">Title: </span>
            <span class="entry-value"><? echo $pop_title ?></span>
            <br />
            <span class="entry-title">Message: </span>
            <span class="entry-value"><? echo $pop_text ?></span>
            <hr />
            <span class="entry-title">Your comment: </span>
            <textarea class="entry-value" id="pop-entry-msg" rows="5" style="width:220px;" ></textarea>
            <hr />
            <fieldset>
                <legend>Repeat message: </legend>
                <label for="chk-repeat">Repeat message</label>
                <input type="checkbox" name="chk-repeat" id="chk-repeat" onclick="setRepeatInputs();" />
                <input type="textbox" id="tx-nextrun" readonly="readonly" style="cursor: text;" />
            </fieldset>

            <div style="display:none;">
                <span class="entry-title">Repeat after: </span>
                <input type="number" id="tx-repeat-val" name="tx-repeat-val" style="width:90px;" />
                <select id="tx-repeat-type" style="width:120px;" >
                    <option value="minute">minute</option>
                    <option value="hour">hour</option>
                    <option value="day" selected="true">day</option>
                    <option value="month">month</option>
                    <option value="year">year</option>
                </select>
                <br />
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>
</body>
</html>