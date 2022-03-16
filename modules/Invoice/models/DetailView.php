<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Invoice_DetailView_Model extends Inventory_DetailView_Model {

	public function getDetailViewLinks($linkParams) {
		$currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		
		$linkModelList = parent::getDetailViewLinks($linkParams);
		$recordModel = $this->getRecord();

		//$recordModel = Vtiger_Record_Model::getInstanceById($recordModel->getId(), $this->getModuleName());
        //$pdfFileName = $recordModel->getPDFFileName();
        //Invoice
        $moduleModel = $this->getModule();
        $moduleName = $moduleModel->getName();
		$recordId = $recordModel->getId();

		$rcordid = $recordModel->getId();
		
		
		$basicActionLink = array(
				'linktype' => 'DETAILVIEW',
				'linklabel' => vtranslate('View PDF'),
				'linkurl' => "javascript:Vtiger_Header_Js.previewFilepdf(event,".$rcordid." ,'Invoice');",
				'linkicon' => ''
			);

		//$linkModelList['DETAILVIEW'][] =Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
		 if(Users_Privileges_Model::isPermitted($moduleName, 'PrintInv', $recordId)) {
		$basicActionLink2 = array(
				'linktype' => 'DETAILVIEWBASIC',
				'linklabel' => vtranslate('طباعة العقد'),
				'linkurl' => "javascript:window.open('?module=Invoice&view=ContractPrint&recordid=".$rcordid."','_blank')",
				'linkicon' => ''
			);
			
			$linkModelList['DETAILVIEWBASIC'][] =Vtiger_Link_Model::getInstanceFromValues($basicActionLink2);
		 }
		

		
		
		if(Users_Privileges_Model::isPermitted($moduleName, 'PrintInv', $recordId)) {
		$basicActionLink3 = array(
				'linktype' => 'DETAILVIEWBASIC',
				'linklabel' => vtranslate('طباعة العقد A4'),
				'linkurl' => "javascript:window.open('?module=Invoice&view=ContractPrintA4&recordid=".$rcordid."','_blank')",
				'linkicon' => ''
			);

		    $linkModelList['DETAILVIEWBASIC'][] =Vtiger_Link_Model::getInstanceFromValues($basicActionLink3);
		}
		



		$purchaseOrderModuleModel = Vtiger_Module_Model::getInstance('PurchaseOrder');
		if ($currentUserModel->hasModuleActionPermission($purchaseOrderModuleModel->getId(), 'CreateView')) {
			$basicActionLink = array(
				'linktype' => 'DETAILVIEW',
				'linklabel' => vtranslate('LBL_GENERATE') . ' ' . vtranslate($purchaseOrderModuleModel->getSingularLabelKey(), 'PurchaseOrder'),
				'linkurl' => $recordModel->getCreatePurchaseOrderUrl(),
				'linkicon' => ''
			);
			$linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
		}
		return $linkModelList;
	}
}
