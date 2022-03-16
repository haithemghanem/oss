<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Emails_MassSaveAjax_View extends Vtiger_Footer_View {
	function __construct() {
		parent::__construct();
		$this->exposeMethod('massSave');
	}

	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();

		if (!Users_Privileges_Model::isPermitted($moduleName, 'Save')) {
			throw new AppException(vtranslate($moduleName, $moduleName).' '.vtranslate('LBL_NOT_ACCESSIBLE'));
		}
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->getMode();
		if(!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	/**
	 * Function Sends/Saves mass emails
	 * @param <Vtiger_Request> $request
	 */
	public function massSave(Vtiger_Request $request) {
		global $upload_badext;
		$adb = PearDatabase::getInstance();

		$moduleName = $request->getModule();
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$recordIds = $this->getRecordsListFromRequest($request);
		$documentIds = $request->get('documentids');
		$signature = $request->get('signature');
		// This is either SENT or SAVED
		$flag = $request->get('flag');

		$result = Vtiger_Util_Helper::transformUploadedFiles($_FILES, true);
		$_FILES = $result['file'];

		$recordId = $request->get('record');

		if(!empty($recordId)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($recordId,$moduleName);
			$recordModel->set('mode', 'edit');
		}else{
			$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
			$recordModel->set('mode', '');
		}

		$parentEmailId = $request->get('parent_id',null);
		$attachmentsWithParentEmail = array();
		if(!empty($parentEmailId) && !empty ($recordId)) {
			$parentEmailModel = Vtiger_Record_Model::getInstanceById($parentEmailId);
			$attachmentsWithParentEmail = $parentEmailModel->getAttachmentDetails();
		}
		$existingAttachments = $request->get('attachments',array());
		if(empty($recordId)) {
			if(is_array($existingAttachments)) {
				foreach ($existingAttachments as $index =>  $existingAttachInfo) {
					$existingAttachInfo['tmp_name'] = $existingAttachInfo['name'];
					$existingAttachments[$index] = $existingAttachInfo;
					if(array_key_exists('docid',$existingAttachInfo)) {
						$documentIds[] = $existingAttachInfo['docid'];
						unset($existingAttachments[$index]);
					}

				}
			}
		}else{
			//If it is edit view unset the exising attachments
			//remove the exising attachments if it is in edit view

			$attachmentsToUnlink = array();
			$documentsToUnlink = array();


			foreach($attachmentsWithParentEmail as $i => $attachInfo) {
				$found = false;
				foreach ($existingAttachments as $index =>  $existingAttachInfo) {
					if($attachInfo['fileid'] == $existingAttachInfo['fileid']) {
						$found = true;
						break;
					}
				}
				//Means attachment is deleted
				if(!$found) {
					if(array_key_exists('docid',$attachInfo)) {
						$documentsToUnlink[] = $attachInfo['docid'];
					}else{
						$attachmentsToUnlink[] = $attachInfo;
					}
				}
				unset($attachmentsWithParentEmail[$i]);
			}
			//Make the attachments as empty for edit view since all the attachments will already be there
			$existingAttachments = array();
			if(!empty($documentsToUnlink)) {
				$recordModel->deleteDocumentLink($documentsToUnlink);
			}

			if(!empty($attachmentsToUnlink)){
				$recordModel->deleteAttachment($attachmentsToUnlink);
			}

		}

		// This will be used for sending mails to each individual
		$toMailInfo = $request->get('toemailinfo');

		$to = $request->get('to');
		if(is_array($to)) {
			$to = implode(',',$to);
		}

		$content = $request->getRaw('description');
		$processedContent = Emails_Mailer_Model::getProcessedContent($content); // To remove script tags
		$mailerInstance = Emails_Mailer_Model::getInstance();
		$processedContentWithURLS = decode_html($mailerInstance->convertToValidURL($processedContent));
		$recordModel->set('description', $processedContentWithURLS);
		$recordModel->set('subject', $request->get('subject'));
		$recordModel->set('toMailNamesList',$request->get('toMailNamesList'));
		$recordModel->set('saved_toid', $to);
		$recordModel->set('ccmail', $request->get('cc'));
		$recordModel->set('bccmail', $request->get('bcc'));
		$recordModel->set('assigned_user_id', $currentUserModel->getId());
		$recordModel->set('email_flag', $flag);
		$recordModel->set('documentids', $documentIds);
		$recordModel->set('signature',$signature);

		$recordModel->set('toemailinfo', $toMailInfo);
		foreach($toMailInfo as $recordId=>$emailValueList) {
			if($recordModel->getEntityType($recordId) == 'Users'){
				$parentIds .= $recordId.'@-1|';
			}else{
				$parentIds .= $recordId.'@1|';
			}
		}
		$recordModel->set('parent_id', $parentIds);

		//save_module still depends on the $_REQUEST, need to clean it up
		$_REQUEST['parent_id'] = $parentIds;

		$success = false;
		$viewer = $this->getViewer($request);
		if ($recordModel->checkUploadSize($documentIds)) {
			$recordModel->save();
			
			// is sheduleemail send 
		if($request->get('Scheduleemail')=='on')
		{
		 $emailid=$recordModel->getId(); // forntkey from emaildetail
		 
		 $timepicker=date('g:ia');
		 $datapickerid =date('d-m-Y');
		 $selectcount=1;
		 
		 $datastartpicker=date('d-m-Y');
		 
		if($request->get('timepickerid') !=null)
		$timepicker=$request->get('timepickerid'); //time to save
		
		if($request->get('selectcount') !=null)
		$selectcount=$request->get('selectcount'); // select count repat   as 1,2,3...,7
		
		
		$selectedapirior=$request->get('selectedapirior'); // select interval as 1:day ,2:Week ,3:month ,4:year;
		
		if($request->get('datapickerid') !=null)
		$datapickerid=$request->get('datapickerid'); // untail data 
		
	    if($request->get('$datastartpicker') !=null)
		$datastartpicker=$request->get('$datastartpicker'); // sata start send email
		
		
		// on select datapickerid = 2 =week we gef all day 
	     $curentuser= $currentUserModel->getId();
 		 $result = $adb->pquery('SELECT time_zone FROM `vtiger_users` WHERE id=?', array($curentuser));
         $row = $adb->fetch_array($result);
         $curentuser_timezone=$row['time_zone'];
         $default_timezone=date_default_timezone_get();
		 //converToTzdate($datastartpicker,$curentuser_timezone,$default_timezone);
		$theweek = array();
	

	
		$full_datatime=$datastartpicker.''.$timepicker; //start datatime
		$Datatimeconver=self::converToTzdateTime($full_datatime,$default_timezone,$curentuser_timezone); //start datatime
		
		//$Datatimeconver=$full_datatime;
		//date end 
		$full_enddatatime=$datapickerid.''.$timepicker;
		$fenddatatime=self::converToTzdateTime($full_enddatatime,$default_timezone,$curentuser_timezone); //End datatime
		
		//$fenddatatime=$full_enddatatime;
		
		$datapickerid=Date("d-m-Y",strtotime($fenddatatime));//data end 
		
		$timepicker=Date("g:ia",strtotime($fenddatatime));//start datatime
		$datastartpicker=Date("d-m-Y",strtotime($Datatimeconver));//start datatime
		
		
		
		
		$sun_flag=null;
		$mon_flag=null;
		$tue_flag=null;
		$wed_flag=null;
		$thu_flag=null;
		$fri_flag=null;
		$sat_flag=null;
		if($request->get('sun_flag') !=null)
	    $theweek[]=$sun_flag=$request->get('sun_flag');
		      
		if($request->get('mon_flag')!=null )
		   $theweek[]=$mon_flag=$request->get('mon_flag');
		      
		if($request->get('tue_flag')!=null)
		   $theweek[]=$tue_flag=$request->get('tue_flag');
		         
		if($request->get('wed_flag')!=null)
		   $theweek[]=$wed_flag=$request->get('wed_flag');
		         
		if($request->get('thu_flag')!=null)
		   $theweek[]=$thu_flag=$request->get('thu_flag');
		        
		if($request->get('fri_flag') !=null)
		   $theweek[]=$fri_flag=$request->get('fri_flag');
		         
		 if($request->get('sat_flag') !=null)
		   $theweek[]=$sat_flag=$request->get('sat_flag');
		// end 
		
		  $emailstat=0;
		  
		  $queryinser="INSERT INTO vtiger_messemailscheduler (vmms_emailid, vmms_timetosend, vmms_untaildata, vmms_repet, vmms_interval, vmms_emailstat, sun_flag, mon_flag, tue_flag, wed_flag, thu_flag, fri_flag, set_flag)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
		  $parmatersemal=array($emailid,$timepicker,$datapickerid,$selectcount,$selectedapirior,$emailstat,$sun_flag,$mon_flag,$tue_flag,$wed_fla,$thu_flag,$fri_flag,$sat_flag);
		  $result = $adb->pquery($queryinser,$parmatersemal);
		  
		  
		  
		  
		  //this partion
		  $repeatInterval=array();
		  
		  $type=$selectedapirior;
          $frequency=$selectcount;
          $star_time=$datastartpicker;
          $starting = self::mktime($datastartpicker);
		  $limiting = self::mktime($datapickerid);
          
          $repeatInterval[] =$star_time;
          
          if($type == 1) {	
			$count = 0;
			while(true) {
				++$count;
				$interval = ($count * $frequency);
				if(self::mktime(self::nexttime($star_time, "+$interval days")) > $limiting) {
					break;
				}
				$repeatInterval[] = self::nexttime($star_time, "+$interval days");
			}
		}else if($type == 2){ //week
            $count = 0;$weekcount = 7;
				while(true) {
					++$count;
					$interval = (($count * $weekcount) * $frequency);
					$interweek = $interval+1;
					if(self::mktime(self::nexttime($star_time, "+$interval days")) > $limiting) {
						break;
					}
					$repeatInterval[] = self::nexttime($star_time, "+$interval days");
                     // this enter avery day in week 
					for($i = $interweek; $i <= ($interval+6) ; $i++)
					{
                     $new_timing = strtotime(self::nexttime($star_time, "+$i days"));
					 $new_dayofweek = date('l', $new_timing);

                     if(in_array($new_dayofweek, $theweek))
                      $repeatInterval[] = self::nexttime($star_time, "+$i days");
					}
		       }
		}
		else if($type == 3) {
			$count = 0;
			$avg_monthcount = 30; // TODO: We need to handle month increments precisely!
			while(true) {
				++$count;
				$interval =($count * $avg_monthcount) * $frequency;
				if(self::mktime(self::nexttime($star_time, "+$interval days")) > $limiting) {
					break;
				}
				$repeatInterval[] = self::nexttime($star_time, "+$interval days");
			}
		} else if($type == 4) {
			$count = 0;
			$avg_monthcount = 360;
				while(true) {
					++$count;
					$interval = ($count * $avg_monthcount) * $frequency;
					if(self::mktime(self::nexttime($star_time, "+$interval days")) > $limiting) {
						break;
				}
				$repeatInterval[] = self::nexttime($star_time, "+$interval days");
			}
		}
		
	
          
       
        // $timepicker1 = converToTz($timepicker,$default_timezone,$curentuser_timezone);
        
		$ven_delete=0; //this record no delete 
		$statview=0;
		foreach($repeatInterval as $datasend){
		$emaittl=date("Y-m-d",strtotime($datasend));
		$sqlinswer="INSERT INTO `vtiger_emailNotifications`(`ven_emailid`, `ven_timetosend`, `ven_datatosend`, `ven_stat_view`, `ven_delete`,data_time)VALUES (?,?,?,?,?,?)";
		$parmater=array($emailid,date("H:i:00",strtotime($timepicker)),$emaittl,$statview,$ven_delete,$emaittl);
		$resulte = $adb->pquery($sqlinswer,$parmater);
		 }
		  // updat 
		  if($flag == 'SAVE') {
		      $stat=3;
		      $updat="UPDATE  `vtiger_modtracker_basic` SET status=$stat  where  crmid=$emailid";
		      $adb->pquery($updat);
		  }
		}
		 
			
			

			// To add entry in ModTracker for email relation
			$emailRecordId = $recordModel->getId();
			foreach ($toMailInfo as $recordId => $emailValueList) {
				$relatedModule = $recordModel->getEntityType($recordId);
				if (!empty($relatedModule) && $relatedModule != 'Users') {
					$relatedModuleModel = Vtiger_Module_Model::getInstance($relatedModule);
					$relationModel = Vtiger_Relation_Model::getInstance($relatedModuleModel, $recordModel->getModule());
					if ($relationModel) {
						$relationModel->addRelation($recordId, $emailRecordId);
					}
				}
			}
			// End

			//To Handle existing attachments
			$current_user = Users_Record_Model::getCurrentUserModel();
			$ownerId = $recordModel->get('assigned_user_id');
			$date_var = date("Y-m-d H:i:s");
			if(is_array($existingAttachments)) {
				foreach ($existingAttachments as $index =>  $existingAttachInfo) {
					$file_name = $existingAttachInfo['attachment'];
					$path = $existingAttachInfo['path'];
					$fileId = $existingAttachInfo['fileid'];

					$oldFileName = $file_name;
					//SEND PDF mail will not be having file id
					if(!empty ($fileId)) {
						$oldFileName = $existingAttachInfo['fileid'].'_'.$file_name;
					}
					$oldFilePath = $path.'/'.$oldFileName;

					$binFile = sanitizeUploadFileName($file_name, $upload_badext);

					$current_id = $adb->getUniqueID("vtiger_crmentity");

					$filename = ltrim(basename(" " . $binFile)); //allowed filename like UTF-8 characters
					$filetype = $existingAttachInfo['type'];
					$filesize = $existingAttachInfo['size'];

					//get the file path inwhich folder we want to upload the file
					$upload_file_path = decideFilePath();
					$newFilePath = $upload_file_path . $current_id . "_" . $binFile;

					copy($oldFilePath, $newFilePath);

					$sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?, ?, ?, ?, ?, ?, ?)";
					$params1 = array($current_id, $current_user->getId(), $ownerId, $moduleName . " Attachment", $recordModel->get('description'), $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
					$adb->pquery($sql1, $params1);

					$sql2 = "insert into vtiger_attachments(attachmentsid, name, description, type, path) values(?, ?, ?, ?, ?)";
					$params2 = array($current_id, $filename, $recordModel->get('description'), $filetype, $upload_file_path);
					$result = $adb->pquery($sql2, $params2);

					$sql3 = 'insert into vtiger_seattachmentsrel values(?,?)';
					$adb->pquery($sql3, array($recordModel->getId(), $current_id));
				}
			}
			$success = true;
			if($flag == 'SENT') {
				$status = $recordModel->send();
				if ($status === true) {
					// This is needed to set vtiger_email_track table as it is used in email reporting
					$recordModel->setAccessCountValue();
				} else {
					$success = false;
					$message = $status;
				}
			}

		} else {
			$message = vtranslate('LBL_MAX_UPLOAD_SIZE', $moduleName).' '.vtranslate('LBL_EXCEEDED', $moduleName);
		}
		$viewer->assign('SUCCESS', $success);
		$viewer->assign('MESSAGE', $message);
		$viewer->assign('FLAG', $flag);
		$viewer->assign('MODULE',$moduleName);
		$loadRelatedList = $request->get('related_load');
		if(!empty($loadRelatedList)){
			$viewer->assign('RELATED_LOAD',true);
		}
		$viewer->view('SendEmailResult.tpl', $moduleName);
	}

	/**
	 * Function returns the record Ids selected in the current filter
	 * @param Vtiger_Request $request
	 * @return integer
	 */
	public function getRecordsListFromRequest(Vtiger_Request $request) {
		$cvId = $request->get('viewname');
		$selectedIds = $request->get('selected_ids');
		$excludedIds = $request->get('excluded_ids');

		if(!empty($selectedIds) && $selectedIds != 'all') {
			if(!empty($selectedIds) && count($selectedIds) > 0) {
				return $selectedIds;
			}
		}

		if($selectedIds == 'all'){
			$sourceRecord = $request->get('sourceRecord');
			$sourceModule = $request->get('sourceModule');
			if ($sourceRecord && $sourceModule) {
				$sourceRecordModel = Vtiger_Record_Model::getInstanceById($sourceRecord, $sourceModule);
				return $sourceRecordModel->getSelectedIdsList($request->get('parentModule'), $excludedIds);
			}

			$customViewModel = CustomView_Record_Model::getInstanceById($cvId);
			if($customViewModel) {
				$searchKey = $request->get('search_key');
				$searchValue = $request->get('search_value');
				$operator = $request->get('operator');
				if(!empty($operator)) {
					$customViewModel->set('operator', $operator);
					$customViewModel->set('search_key', $searchKey);
					$customViewModel->set('search_value', $searchValue);
				}
				return $customViewModel->getRecordIds($excludedIds);
			}
		}
		return array();
	}

	public function validateRequest(Vtiger_Request $request) {
		$request->validateWriteAccess();
	}
	 public function mktime($fulldateString) {
		$datepart = split('-',$fulldateString );
		return mktime($datepart[2],$datepart[1],$datepart[0]);
	}
    

    public function nexttime($basetiming, $interval) {
		return date('d-m-Y', strtotime($basetiming." ".$interval));
	}
	
	public function converToTz($time,$toTz,$fromTz)
	{	
		// timezone by php friendly values
		$date = new DateTime($time, new DateTimeZone($fromTz));
		$date->setTimezone(new DateTimeZone($toTz));
		$time= $date->format('g:ia');
		return $time;
	}
	public function converToTzdateTime($time,$toTz,$fromTz)
	{	
		// timezone by php friendly values
		$date = new DateTime($time, new DateTimeZone($fromTz));
		$date->setTimezone(new DateTimeZone($toTz));
		$time= $date->format('d-m-Y g:ia');
		return $time;
	}
}
