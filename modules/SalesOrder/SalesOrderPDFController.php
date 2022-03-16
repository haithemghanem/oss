<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
include_once 'include/InventoryPDFController.php';
include_once dirname(__FILE__). '/SalesOrderPDFHeaderViewer.php';
class Vtiger_SalesOrderPDFController extends Vtiger_InventoryPDFController{
	function buildHeaderModelTitle() {
		$singularModuleNameKey = 'SINGLE_'.$this->moduleName;
		$translatedSingularModuleLabel = getTranslatedString($singularModuleNameKey, $this->moduleName);
		if($translatedSingularModuleLabel == $singularModuleNameKey) {
			$translatedSingularModuleLabel = getTranslatedString($this->moduleName, $this->moduleName);
		}
		return sprintf("%s: %s", 'امر البيع', $this->focusColumnValue('salesorder_no'),'Sales Order');
	}

	function getHeaderViewer() {
		$headerViewer = new SalesOrderPDFHeaderViewer();
		$headerViewer->setModel($this->buildHeaderModel());
		return $headerViewer;
	}
	
	function buildHeaderModelColumnLeft() {
		$modelColumnLeft = parent::buildHeaderModelColumnLeft();
		return $modelColumnLeft;
	}
	
	function buildHeaderModelColumnCenter() {
        global $adb;
        $customerNameid=$this->focusColumnValue('account_id');
        $contactNameid=$this->focusColumnValue('contact_id');


         $Phone="";
		$Mobile="";
		$email="";
		 if(!empty($contactNameid)){
           
            $result = $adb->pquery("SELECT phone ,mobile,email FROM vtiger_contactdetails WHERE contactid=?", array($contactNameid));
		    $num_rows = $adb->num_rows($result);
            if($num_rows) {
			$resultrow = $adb->fetch_array($result);
              $Phone = $resultrow['phone'];
              $Mobile= $resultrow['mobile'];
              $email= $resultrow['email'];
		   }
         }else if(!empty($customerNameid)){

          $result = $adb->pquery("SELECT phone ,otherphone,email1 FROM vtiger_account WHERE accountid=?", array($customerNameid));
		   $num_rows = $adb->num_rows($result);
          if($num_rows) {
			$resultrow = $adb->fetch_array($result);
			  $Phone = $resultrow['phone'];
              $Mobile= $resultrow['otherphone'];
              $email= $resultrow['email1'];
		   }

         }else{

         }

		$subject = $this->focusColumnValue('subject');
		$customerName = $this->resolveReferenceLabel($this->focusColumnValue('account_id'), 'Accounts');
		$contactName = $this->resolveReferenceLabel($this->focusColumnValue('contact_id'), 'Contacts');
		$purchaseOrder = $this->focusColumnValue('vtiger_purchaseorder');
		$quoteName = $this->resolveReferenceLabel($this->focusColumnValue('quote_id'), 'Quotes');
		
		$subjectLabel = getTranslatedString('Subject', $this->moduleName);
        $quoteNameLabel = getTranslatedString('Quote Name', $this->moduleName);
		$customerNameLabel = 'Customer Name';
		$contactNameLabel = 'Contact Name';
		$purchaseOrderLabel = getTranslatedString('Purchase Order', $this->moduleName);

		$contactphone="contactphone";
		$contactmobil="contactmobil";
		$contactemail="contactemail";


		$modelColumn1 = array(
				$subjectLabel		=>	$subject,
				$customerNameLabel	=>	$customerName,
				$contactNameLabel	=>	$contactName,
				$purchaseOrderLabel =>  $purchaseOrder,
                $quoteNameLabel => $quoteName,
                $contactphone => $Phone,
				$contactmobil => $Mobile,
				$contactemail => $email,
			);
		return $modelColumn1;
	}

	function buildHeaderModelColumnRight() {
		$issueDateLabel = 'Issued Date';
		$validDateLabel = 'Valid Date';
		$billingAddressLabel = getTranslatedString('Billing Address', $this->moduleName);
		$shippingAddressLabel = getTranslatedString('Shipping Address', $this->moduleName);
        $Ysername="username";
        //$user =$this->resolveReferenceLabel($this->focusColumnValue('assigned_user_id'),'Users');
        //var_dump($user);
		$modelColumn2 = array(
				'dates' => array(
					$issueDateLabel  => $this->formatDate(date("Y-m-d")),
					$validDateLabel => $this->formatDate($this->focusColumnValue('duedate')),
				),
				$billingAddressLabel  => $this->buildHeaderBillingAddress(),
				$shippingAddressLabel => $this->buildHeaderShippingAddress(),
				$Ysername => $this->resolveReferenceLabel($this->focusColumnValue('assigned_user_id'),'Users'),
			);
		return $modelColumn2;
	}

	function getWatermarkContent() {
		return $this->focusColumnValue('sostatus');
	}
}
?>