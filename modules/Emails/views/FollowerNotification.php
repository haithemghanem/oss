<?php
//FollowerNotification.php


class Emails_FollowerNotification_View extends Vtiger_Footer_View {
   
	function __construct() {
		parent::__construct();
		$this->exposeMethod('FollowerNotification');
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
	
    function FollowerNotification(Vtiger_Request $request){
    
         $adb = PearDatabase::getInstance();
        $moduleName = $request->getModule();
        
        $currentUserMode = Users_Record_Model::getCurrentUserModel();
        $user_curent=$currentUserMode->getId();
        $count=0;
        $data_full="";
        //vtiger_calendar_user_field  Calendar
        //$value=['MARKETING' => 'fa-users',
								// 		'SALES' => 'fa-dot-circle-o',
								// 		'SUPPORT' => 'fa-life-ring',
								// 		'INVENTORY' => 'vicon-inventory',
								// 		'PROJECT' => 'fa-briefcase' ];
										
										
        //SELECT `recordid`, `userid`, `starred` FROM `vtiger_calendar_user_field` WHERE 1
        
        $SELECT="SELECT vcuf.* , vcr.* ,vmb.id as vbmid,vmb.crmid as vmbcrmid ,vmb.module,vmb.whodid ,vmb.changedon,vmb.status,vmd.fieldname ,vmd.prevalue ,vmd.postvalue FROM  vtiger_calendar_user_field vcuf, vtiger_crmentity vcr 
        LEFT JOIN vtiger_modtracker_basic vmb  ON  vmb.crmid=vcr.crmid 
        LEFT JOIN vtiger_modtracker_detail vmd ON  vmd.id=vmb.id
        WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?  GROUP BY vmb.crmid ORDER BY  vcr.modifiedtime DESC , vmb.changedon DESC  limit 30";
        
        
        
        
        
        $activity ="SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.status,
			vtiger_activity.eventstatus, vtiger_activity.activitytype,vtiger_activity.date_start,
			vtiger_activity.due_date,vtiger_activity.time_start, vtiger_activity.time_end,
			vtiger_contactdetails.contactid,
			vtiger_contactdetails.firstname,vtiger_contactdetails.lastname, vtiger_crmentity.modifiedtime,
			vtiger_crmentity.createdtime, vtiger_crmentity.description
			from vtiger_activity
				inner join vtiger_seactivityrel on vtiger_seactivityrel.activityid=vtiger_activity.activityid
				inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_activity.activityid
				left join vtiger_cntactivityrel on vtiger_cntactivityrel.activityid= vtiger_activity.activityid
				left join vtiger_contactdetails on vtiger_contactdetails.contactid= vtiger_cntactivityrel.contactid
                                left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid
				left join vtiger_users on vtiger_users.id=vtiger_crmentity.smownerid
				where  vtiger_crmentity.deleted = 0 ";
        
        

       
       
        
      
        
				
				
		$SELECT="SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_calendar_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=? 
		
		";
        
        $SELECT.="UNION ALL  
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_project_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        $SELECT.="UNION ALL  
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_quotes_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        $SELECT.=" UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_invoice_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_helpdesk_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_faq_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_emails_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_documents_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_contacts_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
         $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_campaigns_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_assets_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_salesorder_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_servicecontracts_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
         $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_services_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_projectmilestone_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_potentials_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_leads_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_accounts_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_vendors_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_purchaseorder_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_products_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_pricebooks_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        $SELECT.="UNION ALL 
        (SELECT vcuf.* , vcr.label,vcr.description,vcr.setype ,vcr.crmid ,vcr.modifiedtime FROM  vtiger_projecttask_user_field vcuf, vtiger_crmentity vcr  WHERE vcuf.recordid =vcr.crmid AND  vcuf.starred=1 AND vcr.deleted=0 AND vcuf.userid=?) ";
        
        
         $SELECT.=" ORDER BY modifiedtime DESC ";
        
        
        
        //ORDER BY vcr.modifiedtime DESC";
        $paramter=array($user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent,$user_curent);
        //$paramter=array($user_curent,$user_curent);
        //$paramter=array();
        $result=$adb->pquery($SELECT,$paramter);
        $hg=$adb->num_rows($result);
        
        //array_merge
        if($adb->num_rows($result) >= 1)
       {
	     while($roww = $adb->fetch_array($result))
	     { 
	         
	         $count = $count+1;
	         if($roww['label'] =="" && $roww['description'] =="" || $roww['label'] ==null && $roww['description'] ==null){
	             $lebal ="Go to record";
	         }
	         else if($roww['label'] =="" && $roww['description'] !="" || $roww['label'] == null && $roww['description'] !=null){
	             $lebal =$roww['description'];
	         }
	         else{
	             $lebal=$roww['label'];
	         }
	         
	         $ty=$roww['setype'];
	         $setype =$value[$ty];
	         $link='index.php?module='.$ty.'&view=Detail&record='.$roww['crmid'];
	         $Time=Vtiger_Util_Helper::formatDateDiffInStrings($roww['modifiedtime']);
	         
	         
	       //  $data_fullm.='
        //                   <li>
        //                       <a  href="'.$link.'">
        //                          <div class="col-md-12" style="width: 500px; padding: 0px;">
        //                             <div class="col-md-11 pull-right">
        //                                 <div class="col-md-12">
                                            
        //                                     <div class="col-md-2"><span></span>'.vtranslate($ty,$ty).' </div>
        //                                     <div class="col-md-2">  </div>
        //                                     <div class="col-md-6"><span>'.$Time.'</span> </div>
        //                                     <div class="col-md-2"><span></span> </div>
                                            
        //                                 </div>
                                        
        //                                 <div class="col-md-12">
        //                                     <span class="message">
        //                                      <b>'.$lebal.' </b> ';
                                             
        //                                      if($roww['vbmid'] !=null)
        //                                      {
        //                                      $DaTime=Vtiger_Util_Helper::formatDateDiffInStrings($roww['changedon']);
                                                 
        //                                      $data_fullm.=' <div class="col-md-12">
                                                 
        //                                         <div class="col-md-6">   Colmun Update : '.$roww['fieldname'].' </div>
        //                                         <div class="col-md-6">Data Time : '.$DaTime.' </div>
                                                 
                                                
                                               
                                                
        //                                         </div>';
                                                 
        //                                      }
                                             
        //                  $data_fullm.='  </span>
        //                                 </div>
                                        
        //                               </div>
        //                              <div class="col-md-1 pull-right">
        //                                 <i class="fa fa-star active"></i>
        //                           </div>
        //                         </div> 
        //                       </a>
        //                     </li>
        //                     ';
 
	         
	         $data_full.='
                           <li>
                              <a  href="'.$link.'">
                                 <div class="col-md-12" style="width: 500px; padding: 0px;">
                                    <div class="col-md-11 pull-right">
                                        <div class="col-md-12">
                                            
                                            <div class="col-md-4"><span></span>'.vtranslate($ty,$ty).' </div>
                                            <div class="col-md-2">  </div>
                                            <div class="col-md-6"><span>'.$Time.'</span> </div>
                                            
                                            
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <span class="message">
                                             '.$lebal.'
                                            </span>
                                        </div>
                                        
                                       </div>
                                     <div class="col-md-1 pull-right">
                                        <i class="fa fa-star active"></i>
                                  </div>
                                </div> 
                                 <hr>
                              </a>
                             
                            </li>
                            
                            ';
	         
 
	         }
       }else
       {
           $data_full.='
                          <li>
                              <a>
                                 <div class="col-md-12" style="width: 500px; padding: 0px;">
                                    <div class="col-md-11 pull-right">
                                        <div class="col-md-12">
                                            
                                            <div class="col-md-3"><span></span> </div>
                                            <div class="col-md-3"><span>...</span> </div>
                                            <div class="col-md-3"><span></span>  </div>
                                            <div class="col-md-3">  </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <span class="message">
                                             Not Have Any Followings
                                            </span>
                                        </div>
                                        
                                       </div>
                                     <div class="col-md-1 pull-right">
                                        <i class="fa fa-star active"></i>
                                  </div>
                                </div> 
                              </a>
                            </li>
                            ';
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
    
    
    }
    
?>