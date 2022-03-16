<?php

/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is solution-time.
 * Portions created by haithamghanem are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
//ActivityUser //ActivitySheduler

	
class Emails_ActivityUser_View extends Vtiger_Footer_View {
   
	function __construct() {
		parent::__construct();
		$this->exposeMethod('ActivityUser');
	}

	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();

		if (!Users_Privileges_Model::isPermitted($moduleName, 'Save')) {
			throw new AppException(vtranslate($moduleName).' '.vtranslate('LBL_NOT_ACCESSIBLE'));
		}
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->getMode();
		if(!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}
	
	}
	public function mktime($fulldateString) {
		$datepart = split('-',$fulldateString );
		return mktime($datepart[2],$datepart[1],$datepart[0]);
	}
    
	
	
	public function ActivityUser(Vtiger_Request $request){
        $adb = PearDatabase::getInstance();
        $moduleName = $request->getModule();
        
        $current_u = Users_Record_Model::getCurrentUserModel();
        //$user_curent=$current_user->getId();
        //$user_curent=$request->get("current_user_id");
        $currentUserMode = Users_Record_Model::getCurrentUserModel();
        $user_curent=$currentUserMode->getId();
        $currentUserModel=$currentUserMode->getId();
        
		$result = $adb->pquery('SELECT time_zone FROM `vtiger_users` WHERE id=?', array($user_curent));
		$row = $adb->fetch_array($result);
        $curentuser_timezone=$row['time_zone'];
        $default_timezone=date_default_timezone_get();
        //$timepicker1mm = self::converToTz($date_email111,$curentuser_timezone,$default_timezone);
	
         $show_array=array();
         $today=date("Y-m-d");
         
         $select_activity="SELECT vtiger_activity.status,vtiger_activity.recurringtype, (CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END)as statut, vtiger_activity.activitytype, vtiger_activity.subject, vtiger_seactivityrel.crmid, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_crmentity.smownerid, vtiger_activity.activityid, vtiger_activity.visibility FROM vtiger_activity INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid LEFT JOIN vtiger_seactivityrel ON vtiger_activity.activityid = vtiger_seactivityrel.activityid INNER JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid WHERE vtiger_crmentity.deleted=0 AND ((DATE('2017-10-03') = vtiger_activity.date_start AND vtiger_activity.recurringtype  not like '--None--')
OR (DATE('2017-10-03') >= vtiger_activity.date_start AND DATE('2017-10-03')<= vtiger_activity.due_date) AND vtiger_activity.recurringtype like '--None--' )
AND ( vtiger_activity.activitytype <> 'Emails') AND vtiger_activity.activityid > 0 ORDER BY modifiedtime DESC LIMIT 0,35";


 

 $SELECT="SELECT vtiger_activity.status,vtiger_activity.recurringtype, (CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END)as statut, vtiger_activity.activitytype, vtiger_activity.subject, vtiger_seactivityrel.crmid, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_crmentity.smownerid,vtiger_modtracker_basic.module,
vtiger_activity.activityid,vtiger_crmentity.description,
vtiger_activity.visibility FROM vtiger_activity INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_modtracker_basic ON vtiger_modtracker_basic.crmid=vtiger_crmentity.crmid  LEFT JOIN vtiger_seactivityrel ON vtiger_activity.activityid = vtiger_seactivityrel.activityid INNER JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_invitees ON  vtiger_activity.activityid=vtiger_invitees.activityid WHERE vtiger_crmentity.deleted=0 
AND ( vtiger_activity.activitytype <> 'Emails') AND vtiger_activity.activityid > 0 
AND ((('$today' = vtiger_activity.date_start AND vtiger_activity.recurringtype  not like '--None--')
OR ( '$today' >= vtiger_activity.date_start AND '$today' <= vtiger_activity.due_date) AND vtiger_activity.recurringtype like '--None--')) AND ( vtiger_crmentity.smcreatorid=$currentUserModel OR vtiger_crmentity.smownerid=$currentUserModel OR vtiger_crmentity.modifiedby=$currentUserModel OR vtiger_invitees.inviteeid=$currentUserModel)
ORDER BY modifiedtime DESC LIMIT 0,30
  ";
  
  
  
 $SELECT1="SELECT vtiger_activity.status,vtiger_activity.recurringtype, (CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END)as statut, vtiger_activity.activitytype, vtiger_activity.subject, vtiger_seactivityrel.crmid, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_crmentity.smownerid,vtiger_modtracker_basic.module,
vtiger_activity.activityid,vtiger_crmentity.description,vtiger_groups.groupid,vtiger_users2group.userid as uermmm,
vtiger_activity.visibility FROM vtiger_activity INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_modtracker_basic ON vtiger_modtracker_basic.crmid=vtiger_crmentity.crmid  LEFT JOIN vtiger_seactivityrel ON vtiger_activity.activityid = vtiger_seactivityrel.activityid  LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  LEFT JOIN vtiger_users2group on vtiger_users2group.groupid=vtiger_groups.groupid  LEFT JOIN vtiger_invitees ON  vtiger_activity.activityid=vtiger_invitees.activityid WHERE vtiger_crmentity.deleted=0 
AND ( vtiger_activity.activitytype <> 'Emails') AND vtiger_activity.activityid > 0 
AND ((('$today' = vtiger_activity.date_start AND vtiger_activity.recurringtype  not like '--None--')
OR ( '$today' >= vtiger_activity.date_start AND '$today' <= vtiger_activity.due_date) AND vtiger_activity.recurringtype like '--None--')) AND ( vtiger_crmentity.smcreatorid=$currentUserModel OR vtiger_crmentity.smownerid=$currentUserModel OR vtiger_crmentity.modifiedby=$currentUserModel OR vtiger_invitees.inviteeid=$currentUserModel OR (vtiger_crmentity.smownerid=(SELECT vtiger_groups.groupid FROM vtiger_groups WHERE vtiger_groups.groupid=(SELECT vtiger_users2group.groupid FROM vtiger_users2group WHERE vtiger_users2group.userid=$currentUserModel)) AND vtiger_users2group.userid=$currentUserModel))
ORDER BY modifiedtime DESC LIMIT 0,30
 ";
 
 $SELECT2="
 SELECT vtiger_activity.status,vtiger_activity.recurringtype, (CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END)as statut, vtiger_activity.activitytype, vtiger_activity.subject, vtiger_seactivityrel.crmid, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_crmentity.smownerid,vtiger_modtracker_basic.module,
vtiger_activity.activityid,vtiger_crmentity.description,vtiger_groups.groupid,vtiger_users2group.userid as uermmm,
vtiger_activity.visibility FROM vtiger_activity INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_modtracker_basic ON vtiger_modtracker_basic.crmid=vtiger_crmentity.crmid  LEFT JOIN vtiger_seactivityrel ON vtiger_activity.activityid = vtiger_seactivityrel.activityid  LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  LEFT JOIN vtiger_users2group on vtiger_users2group.groupid=vtiger_groups.groupid  LEFT JOIN vtiger_invitees ON  vtiger_activity.activityid=vtiger_invitees.activityid WHERE vtiger_crmentity.deleted=0 
AND ( vtiger_activity.activitytype <> 'Emails') AND vtiger_activity.activityid > 0 
AND ((('$today' = vtiger_activity.date_start AND vtiger_activity.recurringtype  not like '--None--')
OR ( '$today' >= vtiger_activity.date_start AND '$today' <= vtiger_activity.due_date) AND vtiger_activity.recurringtype like '--None--')) AND (
 ((vtiger_crmentity.smcreatorid=$currentUserModel OR vtiger_crmentity.smcreatorid=$currentUserModel OR vtiger_crmentity.modifiedby=$currentUserModel) AND ( 
 vtiger_crmentity.smownerid=(SELECT vtiger_groups.groupid FROM vtiger_groups WHERE vtiger_groups.groupid=(
     SELECT vtiger_users2group.groupid FROM vtiger_users2group WHERE vtiger_users2group.userid=$currentUserModel)) AND vtiger_users2group.userid =$currentUserModel)) OR vtiger_invitees.inviteeid=$currentUserModel OR vtiger_users2group.userid ='' OR
(vtiger_crmentity.smownerid=(SELECT vtiger_groups.groupid FROM vtiger_groups WHERE vtiger_groups.groupid=(SELECT vtiger_users2group.groupid FROM vtiger_users2group WHERE vtiger_users2group.userid=$currentUserModel)) AND vtiger_users2group.userid =$currentUserModel AND (vtiger_crmentity.smcreatorid !=$currentUserModel AND vtiger_crmentity.modifiedby !=$currentUserModel) OR vtiger_users2group.userid ='' ))
GROUP BY vtiger_crmentity.crmid ORDER BY modifiedtime DESC  LIMIT 0,30
 ";
#f9ffe0
    $statmnue=0;
  //vtiger_modtracker_basic.whodid=?
       $paramter=array($currentUserModel);
       $result=$adb->pquery($SELECT1);
       $stat =0;$count=0;
       if($adb->num_rows($result) >= 1)
       {
           $statmnue=2;
	     while($roww = $adb->fetch_array($result))
	     {  
	         $DATATime=$roww['date_start']." ".$roww['time_start'] ;
	         
	         $DataTimeView= Vtiger_Util_Helper::formatDateDiffInStrings($DATATime);
	         //$count=$count+1;
					        $data_fullkk .='<li>
                              <a href="index.php?module=Calendar&view=Detail&record='.$roww['activityid'].'">
                                 <div class="col-md-12" style="width: 500px; padding: 0px;">
                                    <div class="col-md-11 pull-right">
                                        <div class="col-md-12">
                                            
                                            <div class="col-md-3"><span> '.$roww['subject'].' </span> </div>
                                            <div class="col-md-3" class="time" ><span> '.$DataTimeView.' </span> </div>
                                            <div class="col-md-3"><span>'.$roww['statut'].'</span>  </div>
                                            <div class="col-md-3"> '.$roww['activitytype'].' </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <span class="message">
                                              '.$roww['description'].'
                                            </span>
                                        </div>
                                        
                                     </div>
                                     <div class="col-md-1 pull-right">
                                        <i class="fa fa-bell-o"></i>
                                     </div>
                                </div> 
                              </a>
                            </li>';
	    }
	     
       }
        $paramter1=array($currentUserModel);
       $result2=$adb->pquery($SELECT2);
       if($adb->num_rows($result2) >= 1)
       {
            $statmnue=2;
	     while($roww = $adb->fetch_array($result2))
	     {  
	         $DATATime=$roww['date_start']." ".$roww['time_start'] ;
	         
	         $DataTimeView= Vtiger_Util_Helper::formatDateDiffInStrings($DATATime);
	         $count=$count+1;
	         //<img src="layouts/vlayout/skins/images/'.$roww['module'].'.png" alt="'.$roww['module'].'" title="'.$roww['module'].'" width="16px">
	       
					        
					        
					   $data_full .='<li>
                              <a href="index.php?module=Calendar&view=Detail&record='.$roww['activityid'].'">
                                 <div class="col-md-12" style="width: 500px; padding: 0px;">
                                    <div class="col-md-11 pull-right">
                                        <div class="col-md-12">
                                            
                                            <div class="col-md-3"><span> '.$roww['subject'].' </span> </div>
                                            <div class="col-md-3" class="time" ><span> '.$DataTimeView.' </span> </div>
                                            <div class="col-md-3"><span>'.$roww['statut'].'</span>  </div>
                                            <div class="col-md-3"> '.$roww['activitytype'].' </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <span class="message">
                                              '.$roww['description'].'
                                            </span>
                                        </div>
                                        
                                     </div>
                                     <div class="col-md-1 pull-right">
                                        <i class="fa fa-bell-o"></i>
                                     </div>
                                </div> 
                              </a>
                            </li>';
	    }
	     
       }
       
       if($statmnue==0)
       {
           $data_full .=' <li>
                              <a>
                                 <div class="col-md-12" style="width: 500px; padding: 0px;">
                                    <div class="col-md-11 pull-right">
                                        <div class="col-md-12">
                                            
                                            <div class="col-md-3"><span>...</span> </div>
                                            <div class="col-md-3"><span>...</span> </div>
                                            <div class="col-md-3"><span>...</span>  </div>
                                            <div class="col-md-3"> ... </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <span class="message">
                                             NO Nofictions NO Nofictions
                                            </span>
                                        </div>
                                        
                                       </div>
                                     <div class="col-md-1 pull-right">
                                        <i class="fa fa-bell-o"></i>
                                  </div>
                                </div> 
                              </a>
                            </li>
					        
					        ';
					        
       }
       
        
         
          $dom = new DOMDocument("1.0");
          $node = $dom->createElement("Activity"); //Create new element node
          $parnode = $dom->appendChild($node); //make the node show up
 
          $node = $dom->createElement("ActivityNofitaion");  
          $newnode = $parnode->appendChild($node);   
          
          $newnode->setAttribute("allmessages",$data_full);  

           $data_full= $dom->saveXML();
            $viewer = $this->getViewer($request);
            
 		    // $viewer->assign('dataActivty', $SELECT);
 		     // $viewer->view('ActivityUser.tpl', $moduleName);
		
		   $result = array();
        $result['module'] =  $moduleName;
        $result['count'] =   $count;
        $result['messages'] =$data_full;
  
        $response = new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);
        $response->setResult($result);
        $response->emit();
	   
       
	}
	public function converToTz($time,$toTz,$fromTz)
	{	
		// timezone by php friendly values
		$date = new DateTime($time, new DateTimeZone($fromTz));
		$date->setTimezone(new DateTimeZone($toTz));
		$time= $date->format('g:ia');
		return $time;
	}
	
	public function converToTzdate($time,$toTz,$fromTz)
	{	
		// timezone by php friendly values
		$date = new DateTime($time, new DateTimeZone($fromTz));
		$date->setTimezone(new DateTimeZone($toTz));
		$time= $date->format('d-m-Y');
		return $time;
	}
	
	
	
	
	
	
}