<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is solution-time.
 * Portions created by haithamghanem are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

require_once 'modules/Emails/mail.php';

class Emails_EmailSheduler_View extends Vtiger_Footer_View {
   
	function __construct() {
		parent::__construct();
		$this->exposeMethod('EmailShedule');


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
    

    public function nexttime($basetiming, $interval) {
		return date('d-m-Y', strtotime($basetiming." ".$interval));
	}
	public function getEmail($email){
 		 $Email=trim($_tmp[$j],"]");
 		 $Email =trim($Email,"[");
         $Email =trim($Email,'&quot;');
	    return $Email;
	}

	public function EmailShedule(Vtiger_Request $request) {
	    
	     $adb = PearDatabase::getInstance();
         $moduleName = $request->getModule();
     
        $repeatInterval = Array();
        $newtime_email=date("H:i:s",strtotime(date("g:ia")));
         $today=date("Y-m-d");
        $data_full="//data: ".$today."//nn:".$newtime_email;
         
         $SELECT="SELECT ve.*,vcr.*,ved.*,vmb.whodid,vu.user_name,vu.first_name,vu.last_name FROM vtiger_emailNotifications ve,vtiger_crmentity vcr,vtiger_emaildetails ved,vtiger_modtracker_basic vmb,vtiger_users vu
       WHERE ve.ven_emailid=vcr.crmid  AND  ve.ven_emailid=.ved.emailid  AND vcr.smcreatorid=vu.id  AND ve.ven_emailid=vmb.crmid  AND ve.ven_delete =0";
                                                                                                                                                                       
      $SELECT="SELECT ve.*,vcr.*,ved.*,vmb.whodid,vu.user_name FROM vtiger_emailNotifications ve,vtiger_crmentity vcr,vtiger_emaildetails ved,vtiger_modtracker_basic vmb,vtiger_users vu
       WHERE ve.ven_emailid=vcr.crmid  AND  ve.ven_emailid=.ved.emailid   AND ve.ven_emailid=vmb.crmid  AND  ve.ven_stat_view = 0 AND ve.ven_delete =0  AND vu.id=vcr.smcreatorid AND ve.ven_timetosend=? AND  ve.ven_datatosend=?";
        
       $paramter=array($newtime_email,$today);
       $result=$adb->pquery($SELECT,$paramter);
       $stat =0;
       $tomail;
       $to_emaill;
       if($adb->num_rows($result) >= 1)
       {
           $haitham;
	      $roww = $adb->fetch_array($result);
	         $data_full1 .='to_email: '.$roww['to_email'].'/from_name:'.$roww['user_name'].'/from_email:'.$roww['from_email'].'/subject:'.$roww['label'].'/contents:'.$roww['description'].'/cc/'.$roww['cc_email'].'/bcc/'.$roww['bcc_email'].'/attachment/'.$roww[''].'/emailid/'.$roww['emailid'];
	        // $stat=send_mail('Emails',["hathemhamoud@gmail.com"],$roww['user_name'],["haithamghanem@crm.solutions-time.com"],$roww['label'],'test good',$roww['cc_email'],$roww['bcc_email'],'',$roww['emailid'],'',false);
	        
	          $_tmp = explode(",",$roww['to_email']);
 			for($j=0,$num=count($_tmp);$j<$num;$j++) {
 			    $haitham=trim($_tmp[$j],"]");
 			    $haitham =trim($haitham,"[");
             $haitham =trim($haitham,'&quot;'); //this parnmater = Email to Send 
 		     $stat=send_mail('Emails',$haitham,$roww['user_name'],self::getEmail($roww['from_email']),$roww['label'],$roww['description'],$roww['cc_email'],$roww['bcc_email'],'',$roww['emailid'],'',false);
 			}
 		
 			    $full_datatime=date('Y-m-d H:i:s');
	            $emailid= $roww['emailid'];
	            $stat_view=1;   
	            $updat="UPDATE `vtiger_emailNotifications` SET ven_stat_view =$stat_view , data_time='$full_datatime'  WHERE ven_emailid=$emailid AND ven_timetosend='$newtime_email' AND ven_datatosend='$today'";
	            $resu=$adb->pquery($updat);
	           
      }
       
		$viewer = $this->getViewer($request);
// 		$viewer->assign('MODULNAME',$data_full);
// 		$viewer->assign('CURENTUSER', "nn");
// 		$viewer->view('Emailscheduler.tpl', $moduleName);

        $result = array();
        $result['module'] =  $moduleName;
        $result['count'] =   "nn";
        $result['messages'] =$data_full;
  
        $response = new Vtiger_Response();
        $response->setEmitType(Vtiger_Response::$EMIT_JSON);
        $response->setResult($result);
        $response->emit();

      }

}