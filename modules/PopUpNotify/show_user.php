<?php

session_start();

chdir('../../');

if(!isset($_SESSION['module_user_id']) || !isset($_SESSION['authenticated_user_id']) 
        || $_SESSION['module_user_id'] != $_SESSION['authenticated_user_id']){   // || $_SESSION['module_user_isadmin'] !== 1
    echo json_encode(array('status' => 0, 'msg' => 'No Permission'));
    exit(0);
}


require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $adb;


if(isset($_POST['popid'])){
    
    $pid=$_POST['popid'];
     $data ='<center>
     <div class="dv-col2 col-md-12">
      
      <div class="col-md-12">
            <button type="button" class="btn btn-default " title="Add User" onclick="AddUser_Click('. $pid .');"> ADD User </button>
            <button type="button" class="btn btn-default" title="Delete Selected Users" onclick="DelUser_Click('. $pid .');">Delete User</button>
            <button type="button" class="btn btn-default pull-right" title="Delete Selected Users" onclick="close_user();">Close</button>
       </div> ';
    $pop_users = $adb->pquery("Select p.popid, p.user_id, p.is_active, u.user_name From tblPopupNotify_Users p left join vtiger_users u on p.user_id = u.id Where popid = " . $pid);
    $pop_users_count = $adb->num_rows($pop_users);
    $str_opt = "";
    $is_allusers = false;
    for($k=0; $k < $pop_users_count; $k++){
        $user_id = $adb->query_result($pop_users,$k,'user_id');
        $user_name = $adb->query_result($pop_users,$k,'user_name');
        if($user_id == 0){
            $str_opt = '  <option value="0">All Users</option>';
            $is_allusers = true;
            break;
        }
        else
            $str_opt .= '  <option value="'. $user_id .'">'. (($user_name == null) ? $user_id : $user_name) .'</option>';
    }
		$data .= '<input type="checkbox" id="chkAllUsers'. $pid .'" class="chk-all-usr" onclick="return chkAllUsers_Click(this, '. $pid .');" '. ($is_allusers ? 'checked="true"' : '') .' />
		        <label for="chkAllUsers'. $pid .'">All Users</label><br/>';
	   $data .='<select id="cmbUsers'. $pid .'" class="cmb-users" multiple="true" '. ($is_allusers ? 'disabled="true"' : '') . ' >'
             . $str_opt . '</select>
        </div>
        <div style="clear:both;"></div>
    </div>
    </center>';
    
    //echo  "gggggo response";
    
    echo json_encode(array('status' => 1, 'msg' => $data ));
    exit(0);
    
}
else{
    echo json_encode(array('status' => 0, 'msg' => 'Invalid Params, ' . json_encode((array)$_POST)));
    exit(0);
}




?>