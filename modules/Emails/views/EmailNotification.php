<?php

/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is solution-time.
 * Portions created by haithamghanem are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/


	
class Emails_EmailNotification_View extends Vtiger_Footer_View {
   
	function __construct() {
		parent::__construct();
		$this->exposeMethod('EmailNotification');
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
    
	
	
	public function EmailNotification(Vtiger_Request $request){
        $adb = PearDatabase::getInstance();
        $moduleName = $request->getModule();
        
        $currentUserMode = Users_Record_Model::getCurrentUserModel();
        $user_curent=$currentUserMode->getId();
        
        //$user_curent=$request->get("current_user_id");
        
        $currentUserMode = Users_Record_Model::getCurrentUserModel();
        
        $currentUserModel=$currentUserMode->getId();
        $date_email111=date("g:ia d-m-Y");
        
        
		 $result = $adb->pquery('SELECT time_zone FROM `vtiger_users` WHERE id=?', array($user_curent));
		  $row = $adb->fetch_array($result);
          $curentuser_timezone=$row['time_zone'];
         $default_timezone=date_default_timezone_get();
          
         $time_zone_hh='def :'.$default_timezone.'//curent_user :'.$curentuser_timezone;
       
         $timepicker1mm = self::converToTz($date_email111,$curentuser_timezone,$default_timezone);
	
	     $nnnnnnnnnn='server_timezome'.$date_email111.'user'.$timepicker1mm;
	     
	     
         
         
         
         $date_email111=date("g:ia d-m-Y");
         
         //self::converToTzdate($date_email1,$curentuser_timezone,$default_timezone)
         $date_email1=date("d-m-Y");
         $date_email=self::mktime($date_email1);
         
         $time_email1=date("g:ia");
         $time_email=self::converToTz($time_email1,$curentuser_timezone,$default_timezone);
        
         $show_array=array();
         $today=date("Y-m-d");
         
         
       $SELECT="SELECT ve.*,vcr.*,ved.*,vmb.whodid,vu.user_name,vu.first_name,vu.last_name FROM vtiger_emailNotifications ve,vtiger_crmentity vcr,vtiger_emaildetails ved,vtiger_modtracker_basic vmb,vtiger_users vu
       WHERE ve.ven_emailid=vcr.crmid  AND  ve.ven_emailid=.ved.emailid  AND vcr.smcreatorid=vu.id  AND ve.ven_emailid=vmb.crmid  AND ve.ven_delete =0 AND  ve.ven_datatosend=? AND vcr.smcreatorid= ?";
          // AND vmb.whodid=? AND  ve.ven_datatosend=?
        
       $paramter=array($today,$currentUserModel);
       //$SELECT="SELECT * FROM `vtiger_emailNotifications`";
       //$paramter=array();
       $result=$adb->pquery($SELECT,$paramter);
       $stat =0;
       $count=0;
       $tomail;
       $to_emaill;
       $rooor=array();
       if($adb->num_rows($result) >= 1)
       {
	     while($roww = $adb->fetch_array($result))
	     {  
	         $count=$count+1;
	         
	         $timee=$roww['ven_timetosend'];  $tateee=$roww['ven_timetosend']; 
	         $daatttt=$roww['ven_datatosend'];
	         $dtatandtime=$daatttt.' '.$timee;
	         $dtatandti1e=$timee.' '.$daatttt;
	         $nameusersend=$roww['first_name'].' '.$roww['last_name'];
	         $titalmessages=$roww['label'];
	         //$Time= Vtiger_Util_Helper::formatDateTimeIntoDayString($dtatandtime);
	         $Time=Vtiger_Util_Helper::formatDateDiffInStrings($dtatandti1e);
	         //$show_array[]=$roww[''];
	         $show_array['time']=$timee;
	         $show_array['tateee']=$tateee;
	         $show_array['dtatandtime']=$dtatandtime;
	         
	        
					        
				$data_full .=' <a href="index.php?module=Calendar&view=Detail&record='.$roww['ven_emailid'].'">
                                 <div class="col-md-12" style="width: 500px; padding: 0px;">
                                    <div class="col-md-11 pull-right">
                                        <div class="col-md-12">
                                            
                                            <div class="col-md-6"><span> '.$nameusersend.' </span> </div>
                                            <div class="col-md-5" class="time" ><span> '.$Time.' </span> </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <span class="message">
                                              '.$titalmessages.'
                                            </span>
                                        </div>
                                        
                                     </div>
                                     <div class="col-md-1 pull-right">
                                        <i class="fa fa-envelope-o"></i>
                                     </div>
                                </div> 
                              </a>
                            </li>';
	    
	   
	     }
	     
       }else
       {
           $data_full .=' <a>
                                 <div class="col-md-12" style="width: 500px; padding: 0px;">
                                    <div class="col-md-11 pull-right">
                                        <div class="col-md-12">
                                            
                                            <div class="col-md-6"><span> ... </span> </div>
                                            <div class="col-md-5" class="time" ><span> ..... </span> </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <span class="message">
                                             NO Email Sheduler
                                            </span>
                                        </div>
                                        
                                     </div>
                                     <div class="col-md-1 pull-right">
                                        <i class="fa fa-envelope-o"></i>
                                     </div>
                                </div> 
                              </a>
                            </li>';
					        
       }
       
       
       $TIME='5:00pm 19-07-2017';
		 $time_vew= Vtiger_Util_Helper::formatDateTimeIntoDayString($TIME);
		 
         $DATA_vewmmm= Vtiger_Util_Helper::formatDateDiffInStrings($date_email111);
         
        $dddddtimevew=$time_email1.'////'.$time_email;
        
        $viewer = $this->getViewer($request);
        
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