<?
session_start();

//chdir('../../');


require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $adb;

$curr_userid = $_SESSION['authenticated_user_id'];
 //$curr_userid=7;

$select="select pop.*,com.user_id ,COUNT(com.user_id) as usecoun from tblPopupNotify pop ,tblPopup_Comment com WHERE  owner_id =? AND  pop.id=popid AND view_stat !=1  GROUP BY  com.user_id ORDER by id DESC";

$result = $adb->pquery($select, array($curr_userid));
$count = $adb->num_rows($result);
$data="";
$COMMENT="";
while($roww = $adb->fetch_array($result))
	     {
	         
	         $user_id=$roww['user_id'];
	         $ass_selusers = $adb->pquery("Select id,first_name ,last_name From vtiger_users WHERE id='".$user_id."'");
              $first_name = $adb->query_result($ass_selusers,0,'first_name');
               $last_name = $adb->query_result($ass_selusers,0,'last_name');
              $Name_user=$first_name .' '.$last_name;
              
              $countcomm=$roww['usecoun'];
              if ($countcomm==1){
                  $COMMENT ="<p dir='rtl' > تعليق واحد من <b>".$Name_user." </b></p>";
              }
              else if ($countcomm==1){
                  $COMMENT  =" <p dir='rtl'> تعليقين من قبل  <b> ".$Name_user." </b> <p>";
              }
              else{
              $COMMENT  =" <p dir='rtl' > (".$countcomm." ) من التعليقات من قبل  <b> ".$Name_user ."</b> </p>";
              }
              $data .=' <li>
                              <a href="index.php?module=PopUpNotify&view=List">
                                 <div class="col-md-12" style="width: 500px; padding: 0px;">
                                        <div class="col-md-1 pull-left">
                                        <i class="fa fa-comment  active"></i>
                                  </div>
                                        <div class="col-md-10">
                                            <span class="message">
                                             '.$COMMENT.'
                                            </span>
                                        </div>
                                        
                                       </div>
                                     
                                </div> 
                              </a>
                            </li>';
              
	         
	     }
  echo json_encode(array('status' => 1,'count'=>$count, 'mess' =>$data));
    exit(0);
    

?>