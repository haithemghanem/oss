<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once dirname(__FILE__) .'/ModTracker.php';
require_once 'data/VTEntityDelta.php';

class ModTrackerHandler extends VTEventHandler {

	function handleEvent($eventName, $data) {
		global $adb, $current_user;
		
		//this code create by haitham Ghanem 2018-03-03
		$currentUserMode = Users_Record_Model::getCurrentUserModel();
        $currentUserModel=$currentUserMode->getId();
        
       $currentUserMode = Users_Record_Model::getCurrentUserModel();
        $currentUserModel=$currentUserMode->getId();
        $useridmodifiedby=$currentUserMode->getId();
        $smownerid_id =$currentUserMode->getId();
        $source_ ="";
        
        
		$moduleName = $data->getModuleName();
		$isTrackingEnabled = ModTracker::isTrackingEnabledForModule($moduleName);

        $recordIdw = $data->getId();
		$selectcreatuser="SELECT smcreatorid , modifiedby , smownerid , source From vtiger_crmentity  WHERE crmid=?";
        $parmtere=array($recordIdw);
        $result=$adb->pquery($selectcreatuser,$parmtere);
       if($adb->num_rows($result) >= 1)
       {
           $currentUserModel=$adb->query_result($result,0,'smcreatorid');
           $useridmodifiedby=$adb->query_result($result,0,'modifiedby');
           $smownerid_id = $adb->query_result($result,0,'smownerid');
           $source_  = $adb->query_result($result,0,'source');
       }
       
		if(!$isTrackingEnabled) {
			return;
		}
		if($eventName == 'vtiger.entity.aftersave.final') {
			$recordId = $data->getId();
			$columnFields = $data->getData();
			$vtEntityDelta = new VTEntityDelta();
			$delta = $vtEntityDelta->getEntityDelta($moduleName, $recordId, true);

			$newerEntity = $vtEntityDelta->getNewEntity($moduleName, $recordId);
			$newerColumnFields = $newerEntity->getData();

			if(is_array($delta)) {
				$inserted = false;
				foreach($delta as $fieldName => $values) {
					if($fieldName != 'modifiedtime') {
						if(!$inserted) {
							$checkRecordPresentResult = $adb->pquery('SELECT * FROM vtiger_modtracker_basic WHERE crmid = ? AND status = ?', array($recordId, ModTracker::$CREATED));
							if(!$adb->num_rows($checkRecordPresentResult) && $data->isNew()) {
								$status = ModTracker::$CREATED;
							} else {
								$status = ModTracker::$UPDATED;
								$currentUserModel = $useridmodifiedby;
							}
							$this->id = $adb->getUniqueId('vtiger_modtracker_basic');
							$changedOn = $newerColumnFields['modifiedtime'];
							if($moduleName == 'Users') {
								$date_var = date("Y-m-d H:i:s");
								$changedOn =  $adb->formatDate($date_var,true);
							}
							$adb->pquery('INSERT INTO vtiger_modtracker_basic(id, crmid, module, whodid, changedon, status)
										VALUES(?,?,?,?,?,?)', Array($this->id, $recordId, $moduleName,
										$currentUserModel, $changedOn, $status));
							$inserted = true;
						}
						$adb->pquery('INSERT INTO vtiger_modtracker_detail(id,fieldname,prevalue,postvalue) VALUES(?,?,?,?)',
							Array($this->id, $fieldName, $values['oldValue'], $values['currentValue']));
					}
				}
			}
		}

		if($eventName == 'vtiger.entity.beforedelete') {
			$recordId = $data->getId();
			$columnFields = $data->getData();
			$id = $adb->getUniqueId('vtiger_modtracker_basic');
			$adb->pquery('INSERT INTO vtiger_modtracker_basic(id, crmid, module, whodid, changedon, status)
				VALUES(?,?,?,?,?,?)', Array($id, $recordId, $moduleName, $current_user->id, date('Y-m-d H:i:s',time()), ModTracker::$DELETED));
		}

		if($eventName == 'vtiger.entity.afterrestore') {
			$recordId = $data->getId();
			$columnFields = $data->getData();
			$id = $adb->getUniqueId('vtiger_modtracker_basic');
			$adb->pquery('INSERT INTO vtiger_modtracker_basic(id, crmid, module, whodid, changedon, status)
				VALUES(?,?,?,?,?,?)', Array($id, $recordId, $moduleName, $current_user->id, date('Y-m-d H:i:s',time()), ModTracker::$RESTORED));
		}
	}
}
?>