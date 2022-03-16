<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/**
 * Inventory Modules Edit View Record Structure Model
 */
class Inventory_EditRecordStructure_Model extends Vtiger_EditRecordStructure_Model {

	/**
	 * Function to get the values in stuctured format
	 * @return <array> - values in structure array('block'=>array(fieldinfo));
	 */
	public function getStructure() {
		if(!empty($this->structuredValues)) {
			return $this->structuredValues;
		}
		$values = array();
		$recordModel = $this->getRecord();
		$recordExists = !empty($recordModel);
        $recordId = $recordModel->getId();
		$moduleModel = $this->getModule();
		$blockModelList = $moduleModel->getBlocks();
		foreach($blockModelList as $blockLabel=>$blockModel) {
			$fieldModelList = $blockModel->getFields();
			if (!empty ($fieldModelList)) {
				$values[$blockLabel] = array();
				foreach($fieldModelList as $fieldName=>$fieldModel) {
					if($fieldModel->isEditable()) {
						if($recordExists) {
							$fieldValue = $recordModel->get($fieldName,null);
                            if($fieldName == 'terms_conditions' && $fieldValue == '' && !$recordModel->getId()) {
								$fieldValue = $recordModel->getInventoryTermsAndConditions();
							}
							if($fieldName == 'invoicedate' && $fieldValue == '' && !$recordModel->getId()) {
								$fieldValue = date("Y-m-d");
							}if($fieldName == 'cf_954' && $fieldValue == '' && !$recordModel->getId()) {
								$fieldValue = self::getcarries('vtiger_invoicecf.cf_954');   
							}if($fieldName == 'cf_950' && $fieldValue == '' && !$recordModel->getId()) {
								$fieldValue = self::getcarries('vtiger_invoicecf.cf_950');
							}
							if($fieldName == 'cf_958' && $fieldValue == '' && !$recordModel->getId()) {
								$fieldValue =self::getcarries('vtiger_invoicecf.cf_958');
							}if($fieldName == 'cf_948' && $fieldValue == '' && !$recordModel->getId()){
								$fieldValue =self::getcarries('vtiger_invoicecf.cf_948');
							}
							else if($fieldValue == '') {
                                $defaultValue = $fieldModel->getDefaultFieldValue();
                                if(!empty($defaultValue) && !$recordId)
									$fieldValue = $defaultValue;
							}
							$fieldModel->set('fieldvalue', $fieldValue);
						}
						$values[$blockLabel][$fieldName] = $fieldModel;
					}
				}
			}
		}
		$this->structuredValues = $values;
		return $values;
	}
	
	
	
	function getcarries($valr){

		global $adb , $current_user;
		$valu='';
		$sql = 'SELECT '.$valr.' as vale FROM vtiger_invoicecf , vtiger_crmentity WHERE vtiger_invoicecf.invoiceid = vtiger_crmentity.crmid  and vtiger_crmentity.smownerid = '.$current_user->id.'  AND vtiger_crmentity.deleted = 0  ORDER BY invoiceid DESC LIMIT 1';
		$result = $adb->pquery($sql,array());
		 if($adb->num_rows($result) > 0)
		    {
		    	$valu = $adb->query_result($result, 0, 'vale' );
		    }
		    
		return  $valu;
	}
}
