<?php

/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is solution-time.
 * Portions created by haithamghanem are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
 //ActivitySheduler

 require_once 'modules/Emails/mail.php';
class Emails_ActivitySheduler_View extends Vtiger_Footer_View {
   
    //private static 
    
    private static $EmailUser;
    private static $NameUser;
    private static $PhoneMobile;
    private static $PhoneWork;
    
    private static $EmailContant;
    private static $NameContant;
    
    
    
	function __construct() {
		parent::__construct();
		$this->exposeMethod('ActivitySheduler');
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
	public function Getemailsender($useridcreate)
	{
	    $adb = PearDatabase::getInstance();
	    $SELECT="SELECT (CASE WHEN (email1 not like '') THEN vtiger_users.email1 ELSE vtiger_users.email2 END)as email,first_name,last_name,phone_mobile,phone_work FROM `vtiger_users` WHERE   status='Active' AND   id=? ";
	    $paramter=array($useridcreate);
        $result=$adb->pquery($SELECT,$paramter);
	    
	    if($adb->num_rows($result) >= 1)
       {
	     while($roww = $adb->fetch_array($result))
	     {
	      
	      self::$EmailUser=$roww['email'];
          self::$NameUser=$roww['first_name'].' '.$roww['last_name'];
          self::$PhoneMobile=$roww['phone_mobile'];
          self::$PhoneWork=$roww['phone_work'];
          
	     }
	     
       }
       else
       {
           
       }
	    
	}
	
	/**
	 * 
	 */
	 public function Getcontant($contactid)
	 {
	     $adb = PearDatabase::getInstance();
	     $SELECT="SELECT salutation,firstname,lastname,(CASE WHEN (email not like '') THEN vtiger_contactdetails.email ELSE vtiger_contactdetails.secondaryemail END)as email FROM `vtiger_contactdetails` WHERE contactid=?";
	     $paramter=array($contactid);
	     $result=$adb->pquery($SELECT,$paramter);
	    if($adb->num_rows($result) >= 1)
         {
	     while($roww = $adb->fetch_array($result))
	     {
	         self::$EmailContant=$roww['email'];
             self::$NameContant =$roww['salutation'].''.$roww['firstname'].''.$roww['lastname'];
	      
	     }
	     
       }
       else
       {
           
       }
	     
	 }
	 
	 public function Getcontant1($contactid)
	 {
	     $adb = PearDatabase::getInstance();
	     $SELECT="SELECT salutation,firstname,lastname,(CASE WHEN (email not like '') THEN vtiger_contactdetails.email ELSE vtiger_contactdetails.secondaryemail END)as email FROM `vtiger_contactdetails` WHERE contactid=?";
	     $paramter=array($contactid);
	     $result=$adb->pquery($SELECT,$paramter);
	    if($adb->num_rows($result) >= 1)
         {
	     while($roww = $adb->fetch_array($result))
	     {
	         self::$EmailContant=$roww['email'];
             self::$NameContant =$roww['salutation'].''.$roww['firstname'].''.$roww['lastname'];
	      
	     }
	     
       }
       else
       {
           
       }
	     
	 }
	 /**
	  * this function mack heder meassges
	  */
	  public function Headermessages($Title,$contnat){
	      $adb = PearDatabase::getInstance();
	      $adb1 = PearDatabase::getInstance();
	      $SELECT="SELECT address,city,country,phone,website FROM `vtiger_organizationdetails`";
	      $paramter=array();
	      $website; $address;
	      $result=$adb->pquery($SELECT,$paramter);
	      $roww = $adb->fetch_array($result);
	      
	      $contanthedder ='<div contenteditable="true" class="cke_editable cke_editable_themed cke_contents_ltr cke_show_borders scayt-enabled" spellcheck="false"><b style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 14px;"><span style="font-size: 12pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(54, 95, 145);">
	      '.self::$NameContant.' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;YOU Have&nbsp; <br></span></b>&nbsp;
	      Activity :'.$Title.'<b style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 14px;"><span style="font-size: 12pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(54, 95, 145);">
	      &nbsp;<br><br></span></b>
	      &nbsp;Content :  '.$contnat.'<b style="color: rgb(34, 34, 34); font-family: arial, sans-serif; font-size: 14px;"><span style="font-size: 12pt; font-family: &quot;Times New Roman&quot;, serif; color: rgb(54, 95, 145);">&nbsp;<br></span></b><br><p class="MsoNormal" style="margin:0px;color:rgb(34,34,34);font-family:arial, sans-serif;font-size:14px;background-color:rgb(255,255,255);"><b>
	      <span style="font-size:12pt;font-family:"Times New Roman", serif;color:rgb(54,95,145);">Best Regards<br></span></b><span style="color:rgb(54,95,145);font-family:"Times New Roman", serif;font-size:12pt;">________________</span></p><p class="MsoNormal" style="margin:0px;color:rgb(34,34,34);font-family:arial, sans-serif;font-size:14px;background-color:rgb(255,255,255);"><b><span style="font-size:12pt;font-family:"Times New Roman", serif;color:rgb(54,95,145);">
	      '.self::$NameUser.'</span></b></p><p class="MsoNormal" style="margin:0px;color:rgb(34,34,34);font-family:arial, sans-serif;font-size:14px;background-color:rgb(255,255,255);"><span style="font-size:12pt;font-family:Cambria, serif;color:rgb(0,32,96);">
	      Mobile :'.self::$PhoneMobile.'  <br>   PhoneWork: '.self::$PhoneWork.' </span></p><p class="MsoNormal" style="margin:0px;color:rgb(34,34,34);font-family:arial, sans-serif;font-size:14px;background-color:rgb(255,255,255);"><span style="font-size:12pt;font-family:Cambria, serif;color:rgb(0,32,96);">
	      Email:&nbsp;&nbsp;&nbsp;<a data-cke-saved-href="'.$EmailUser.'" href="'.$EmailUser.'" style="color:rgb(17,85,204);"><span style="color:#0000FF;">
	      '.self::$EmailUser.'</span></a></span></p><p class="MsoNormal" style="margin:0px;color:rgb(34,34,34);font-family:arial, sans-serif;font-size:14px;background-color:rgb(255,255,255);"><span style="font-family:Cambria, serif;color:rgb(0,32,96);">
	      Website : </span><span style="font-size:12pt;font-family:Cambria, serif;color:rgb(54,95,145);">:</span><span style="font-size:12pt;font-family:Cambria, serif;color:rgb(0,32,96);">
	      &nbsp;<a data-cke-saved-href="'.$roww['website'].'" href="http://'.$roww['website'].'" style="color:rgb(17,85,204);"><span style="color:rgb(5,99,193);">
	      '.$roww['website'].'</span></a>&nbsp;<br>
	      Adress: '.$roww['country'].' <br>
	      '.$roww['city'].'     '.$roww['address'].' 
	      </span></p></div>';
	      
	      return $contanthedder;
	  }
    
	
	
	public function ActivitySheduler(Vtiger_Request $request){
        $adb = PearDatabase::getInstance();
        $adb1 = PearDatabase::getInstance();
        $moduleName = $request->getModule();
        $user_curent=$request->get("current_user_id");
        $currentUserMode = Users_Record_Model::getCurrentUserModel();
        $currentUserModel=$currentUserMode->getId();
		$result = $adb->pquery('SELECT time_zone FROM `vtiger_users` WHERE id=?', array($user_curent));
		$row = $adb->fetch_array($result);
        $curentuser_timezone=$row['time_zone'];
        $default_timezone=date_default_timezone_get();
        $timepicker1mm = self::converToTz($date_email111,$curentuser_timezone,$default_timezone);
	
         $show_array=array();
         $today=date("Y-m-d");
         $time=date("H:i");
         
    $SELECTUSERUSER="
    SELECT vtiger_activity.activityid, (CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END)as statut, vtiger_activity.activitytype, vtiger_activity.subject, vtiger_seactivityrel.crmid, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end,vtiger_activity.duration_hours, vtiger_crmentity.smownerid,vtiger_modtracker_basic.module,
vtiger_crmentity.description,vtiger_users.first_name,vtiger_users.last_name,vtiger_users.email1,
vtiger_activity.visibility,vtiger_activity_reminder.reminder_time,vtiger_crmentity.smcreatorid
FROM vtiger_activity INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_modtracker_basic ON vtiger_modtracker_basic.crmid=vtiger_crmentity.crmid  LEFT JOIN vtiger_seactivityrel ON vtiger_activity.activityid = vtiger_seactivityrel.activityid  LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid   LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid= vtiger_users.id LEFT JOIN  vtiger_cntactivityrel ON vtiger_cntactivityrel.activityid=vtiger_activity.activityid 

LEFT JOIN vtiger_activity_reminder ON vtiger_activity_reminder.activity_id=vtiger_activity.activityid  WHERE vtiger_crmentity.deleted=0 
AND ( vtiger_activity.activitytype <> 'Emails') AND vtiger_activity.activityid > 0 
AND (((('$today' = vtiger_activity.date_start AND vtiger_activity.recurringtype  not like '--None--' )))) AND vtiger_activity.sendnotification=1 AND ((vtiger_activity.recurringtype  not like '--None--' and vtiger_activity_reminder.recurringid = 0) OR  vtiger_activity.recurringtype like '--None--' OR  vtiger_activity.recurringtype like '') and (vtiger_crmentity.smownerid=vtiger_users.id)
ORDER BY modifiedtime DESC LIMIT 0,30
    ";   
         
         
  $paramter=array();
       $result=$adb->pquery($SELECTUSERUSER,$paramter);
       $stat =0;$count=0;
       
       if($adb->num_rows($result) >= 1)
       {
	     while($roww = $adb->fetch_array($result))
	     {
	         $rmaindertime=$roww['reminder_time'];
	        if($rmaindertime =='' || $rmaindertime ==null)
	         {$rmaindertime=0;}
	         
	         $count=$count+1;
	         $remadertime=Date("H:i",$rmaindertime);
	         $timestrat=$roww['time_start'];
	         $durationhour=$roww['duration_hours'];
	         $compaertime=Date("H:i",(strtotime($timestrat) + strtotime($remadertime)));
	  
	         if($compaertime == $time ){
	             self::$EmailContant=$roww['email1'];
                 self::$NameContant =$roww['firstname'].''.$roww['lastname'];
                 $useridcreate=$roww['smcreatorid'];
	             self::Getemailsender($useridcreate);
	             
	              
              if(self::$EmailContant !=null && self::$EmailContant !='')
              {
                 $titla=$roww['subject'];
                 $contnat=$roww['description'].'<br>  Data Start:    '.$roww['date_start'];
                 $Activty=$roww['activitytype'];
                 $Messages=self::Headermessages($Activty,$contnat);
                  
                 $stat=send_mail('Emails',self::$EmailContant,self::$NameUser,self::$EmailUser,$titla,$Messages,'','','',$useridcreate,'',false);
        
                self::$NameUser=null;
                self::$EmailUser =null;
                self::$PhoneMobile =null;
                self::$PhoneWork=null;
                self::$EmailContant=null;
                self::$NameContant =null;
                
                
                $activity_id=$roww['activityid'];
                $Updata="UPDATE vtiger_activity SET sendnotification=2 WHERE activityid=$activity_id";
                 $resu=$adb1->pquery($Updata);
                 
              }
              
	         }
	     }
       }
         
$SElECTGROUPACTIOVTY="  
  SELECT vtiger_activity.activityid, (CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END)as statut, vtiger_activity.activitytype, vtiger_activity.subject, vtiger_seactivityrel.crmid, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end,vtiger_activity.duration_hours, vtiger_crmentity.smownerid,vtiger_modtracker_basic.module,
vtiger_crmentity.description,vtiger_users.first_name,vtiger_users.last_name,vtiger_users.email1,
vtiger_activity.visibility,vtiger_activity_reminder.reminder_time,vtiger_crmentity.smcreatorid
FROM vtiger_activity INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_modtracker_basic ON vtiger_modtracker_basic.crmid=vtiger_crmentity.crmid  LEFT JOIN vtiger_seactivityrel ON vtiger_activity.activityid = vtiger_seactivityrel.activityid  LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid LEFT JOIN vtiger_users2group ON  vtiger_groups.groupid=vtiger_users2group.groupid  LEFT JOIN vtiger_users ON vtiger_users2group.userid= vtiger_users.id LEFT JOIN  vtiger_cntactivityrel ON vtiger_cntactivityrel.activityid=vtiger_activity.activityid 

LEFT JOIN vtiger_activity_reminder ON vtiger_activity_reminder.activity_id=vtiger_activity.activityid  WHERE vtiger_crmentity.deleted=0 
AND ( vtiger_activity.activitytype <> 'Emails') AND vtiger_activity.activityid > 0 
AND (((('$today' = vtiger_activity.date_start AND vtiger_activity.recurringtype  not like '--None--' )))) AND vtiger_activity.sendnotification=1 AND ((vtiger_activity.recurringtype  not like '--None--' and vtiger_activity_reminder.recurringid = 0) OR  vtiger_activity.recurringtype like '--None--' OR  vtiger_activity.recurringtype like '') AND (vtiger_groups.groupid=vtiger_crmentity.smownerid)
ORDER BY modifiedtime DESC LIMIT 0,30
  "; 
  
  $paramter=array();
       $result=$adb->pquery($SElECTGROUPACTIOVTY,$paramter);
       $stat =0;$count=0;
       $data_full.="";
       if($adb->num_rows($result) >= 1)
       {
	     while($roww = $adb->fetch_array($result))
	     {
	         $rmaindertime=$roww['reminder_time'];
	        if($rmaindertime =='' || $rmaindertime ==null)
	         {$rmaindertime=0;}
	         
	         $count=$count+1;
	         $remadertime=Date("H:i",$rmaindertime);
	         $timestrat=$roww['time_start'];
	         $durationhour=$roww['duration_hours'];
	         $compaertime=Date("H:i",(strtotime($timestrat) + strtotime($remadertime)));
	         
	         if($compaertime == $time ){
	             self::$EmailContant=$roww['email1'];
                 self::$NameContant =$roww['firstname'].''.$roww['lastname'];
                 $useridcreate=$roww['smcreatorid'];
	             self::Getemailsender($useridcreate);
	            
              if(self::$EmailContant !=null && self::$EmailContant !='')
              {
                 $titla=$roww['subject'];
                 $contnat=$roww['description'].'<br>  Data Start:    '.$roww['date_start'];
                 $Activty=$roww['activitytype'];
                 $Messages=self::Headermessages($Activty,$contnat);
                  
                 $stat=send_mail('Emails',self::$EmailContant,self::$NameUser,self::$EmailUser,$titla,$Messages,'','','',$useridcreate,'',false);
        
                self::$NameUser=null;
                self::$EmailUser =null;
                self::$PhoneMobile =null;
                self::$PhoneWork=null;
                self::$EmailContant=null;
                self::$NameContant =null;
                
                
                $activity_id=$roww['activityid'];
                $Updata="UPDATE vtiger_activity SET sendnotification=2 WHERE activityid=$activity_id";
                $resu=$adb1->pquery($Updata);
                 
              }
              
	         }
	     }
       }
         

  $SELECTACTIVTY="
  SELECT vtiger_activity.activityid, (CASE WHEN (vtiger_activity.status not like '') THEN vtiger_activity.status ELSE vtiger_activity.eventstatus END)as statut, vtiger_activity.activitytype, vtiger_activity.subject, vtiger_seactivityrel.crmid, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end,vtiger_activity.duration_hours, vtiger_crmentity.smownerid,vtiger_modtracker_basic.module,
vtiger_crmentity.description,
vtiger_activity.visibility,vtiger_contactdetails.contactid,vtiger_contactdetails.email,vtiger_activity_reminder.reminder_time
FROM vtiger_activity INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid INNER JOIN vtiger_modtracker_basic ON vtiger_modtracker_basic.crmid=vtiger_crmentity.crmid  LEFT JOIN vtiger_seactivityrel ON vtiger_activity.activityid = vtiger_seactivityrel.activityid INNER JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid  INNER JOIN  vtiger_cntactivityrel ON vtiger_cntactivityrel.activityid=vtiger_activity.activityid INNER JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid=vtiger_cntactivityrel.contactid LEFT JOIN vtiger_activity_reminder ON vtiger_activity_reminder.activity_id=vtiger_activity.activityid  WHERE vtiger_crmentity.deleted=0 
AND ( vtiger_activity.activitytype <> 'Emails') AND vtiger_activity.activityid > 0 
AND (((('$today' = vtiger_activity.date_start AND vtiger_activity.recurringtype  not like '--None--' )
OR ( '$today' >= vtiger_activity.date_start AND '$today' <= vtiger_activity.due_date) AND vtiger_activity.recurringtype like '--None--'))) AND vtiger_activity.sendnotification=1 AND ((vtiger_activity.recurringtype  not like '--None--' and vtiger_activity_reminder.recurringid = 0) OR  vtiger_activity.recurringtype like '--None--' OR  vtiger_activity.recurringtype like '')
ORDER BY modifiedtime DESC LIMIT 0,30
  ";
  

       $paramter=array();
       $result=$adb->pquery($SELECTACTIVTY,$paramter);
       $stat =0;$count=0;
       $data_full.="";
       if($adb->num_rows($result) >= 1)
       {
	     while($roww = $adb->fetch_array($result))
	     {
	         $rmaindertime=$roww['reminder_time'];
	        if($rmaindertime =='' || $rmaindertime ==null)
	         {$rmaindertime=0;}
	         
	         $count=$count+1;
	         $remadertime=Date("H:i",$rmaindertime);
	         $timestrat=$roww['time_start'];
	         $durationhour=$roww['duration_hours'];
	         $compaertime=Date("H:i",(strtotime($timestrat) + strtotime($remadertime)));
	      
	         if($compaertime == $time ){
	             $useridcreate=$roww['smownerid'];  $contactid=$roww['contactid'];
	             self::Getcontant($contactid);self::Getemailsender($useridcreate);
	      
              if(self::$EmailContant !=null && self::$EmailContant !='')
              {
                  
                 $titla=$roww['subject'];
                 $contnat=$roww['description'].'<br>  Data Start:    '.$roww['date_start'];
                 $Activty=$roww['activitytype'];
                 $Messages=self::Headermessages($Activty,$contnat);
                  
                 $stat=send_mail('Emails',self::$EmailContant,self::$NameUser,self::$EmailUser,$titla,$Messages,'','','',$useridcreate,'',false);
        
                self::$NameUser=null;
                self::$EmailUser =null;
                self::$PhoneMobile =null;
                self::$PhoneWork=null;
                self::$EmailContant=null;
                self::$NameContant =null;
                
                
                $activity_id=$roww['activityid'];
                $Updata="UPDATE vtiger_activity SET sendnotification=2 WHERE activityid=$activity_id";
                $resu=$adb1->pquery($Updata);
                 
              }
             
	            
	         }else if($compaertime < $time){
	             $defrint=$time-$compaertime;
	            
	             
	         }else if($compaertime > $time){
	             $defrint=$compaertime-$time;
	           
	         }else{
	            
	         }
	         
	         
	        
	    }
	     
       }else
       {
           $data_full .='NO Record';
       }
         
        
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