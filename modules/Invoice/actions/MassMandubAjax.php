<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Invoice_MassMandubAjax_Action extends Vtiger_Mass_Action {

	function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserPriviligesModel->hasModuleActionPermission($moduleModel->getId(), 'Save')) {
			throw new AppException(vtranslate($moduleName, $moduleName).' '.vtranslate('LBL_NOT_ACCESSIBLE'));
		}
	}

	/**
	 * Function that saves Invoice records
	 * @param Vtiger_Request $request
	 */
	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();

		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$recordIds =  $this->getRecordsListFromRequest($request);
      
       $recordID;
		foreach ($recordIds as $key => $value) {
			if(!empty($recordID)){
				$recordID .=',';
			}
			$recordID .= $value;
		}
		
		$mandubField = $request->get('fields');
        $db = PearDatabase::getInstance();
        $update=true;

       if(!empty($mandubField)){
             $query= "UPDATE vtiger_invoicecf SET cf_1010=$mandubField WHERE invoiceid IN($recordID)";
             $update = $db->pquery($query, array());
       }

		$response = new Vtiger_Response();
        
		if(!empty($mandubField)) {
			
			$response->setResult(array('id' => $mandubField, 'statusdetails' => array('statusmessage' => "Sucessfully" , 'status'=>'Sucess' )));
		} else {
			//{"success":true,"result":false}
			$response->setResult(false);
			
		}
		return $response;
	}
}
