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

class Vtiger_InvoicePDFController extends Vtiger_InventoryPDFController{

	function buildHeaderModelTitle() {
		$singularModuleNameKey = 'SINGLE_'.$this->moduleName;
		$translatedSingularModuleLabel = getTranslatedString($singularModuleNameKey, $this->moduleName);
		if($translatedSingularModuleLabel == $singularModuleNameKey) {
			$translatedSingularModuleLabel = getTranslatedString($this->moduleName, $this->moduleName);
		}

		$form_br=$this->focusColumnValue('cf_948');
		$from_l="";
		//Jeddah,Abha,Khamis Mushait,Mahail Asir,Riyadh,Dammam
		switch ($form_br) {
			case 'Jeddah':
				$from_l=5;
				break;
			case 'Abha':
				$from_l=1;
				break;
			case 'Khamis Mushait':
				$from_l=2;
				break;
			case 'Mahail Asir':
				$from_l=3;
				break;
			case 'Riyadh':
				$from_l=4;
				break;
			case 'Dammam':
				$from_l=6;
				break;
			default:
				$from_l=$form_br;
				break;
		}
		return sprintf("%s/%s",$from_l, $this->focusColumnValue('invoice_no'));
	}

	function buildHeaderModelColumnCenter() {

		global $adb;
		$Phone="";
		$Mobile="";
		$email="";

        $customerNameid=$this->focusColumnValue('account_id');
        $contactNameid=$this->focusColumnValue('contact_id');
        $recevidPhone = $this->focusColumnValue('cf_946');
        $recevName= $this->resolveReferenceLabel($this->focusColumnValue('cf_944'), 'Contacts');
        $Mobile = $this->focusColumnValue('customerno');
		$customerName = $this->resolveReferenceLabel($this->focusColumnValue('account_id'), 'Accounts');
		$contactName = $this->resolveReferenceLabel($this->focusColumnValue('contact_id'), 'Contacts');
		$purchaseOrder = $this->focusColumnValue('vtiger_purchaseorder');
		$salesOrder	= $this->resolveReferenceLabel($this->focusColumnValue('salesorder_id'));


       

        if(!empty($contactNameid)){
           
            $result = $adb->pquery("SELECT phone ,mobile,email FROM vtiger_contactdetails WHERE contactid=?", array($contactNameid));
		    $num_rows = $adb->num_rows($result);
            if($num_rows) {
			$resultrow = $adb->fetch_array($result);
              $Phone = $resultrow['phone'];
              //$Mobile= $resultrow['mobile'];
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

		$customerNameLabel ='Customer Name';
		$contactNameLabel = 'Contact Name';
		$purchaseOrderLabel = 'Purchase Order';
		$salesOrderLabel = 'Sales Order';

		$contactphone="contactphone";
		$contactmobil="contactmobil";
		$contactemail="contactemail";
		$receivedleble="recevedname";
		$recevidPhoneLebel="RecevdePhone";

		$modelColumnCenter = array(
				$customerNameLabel	=>	$customerName,
				$purchaseOrderLabel =>	$purchaseOrder,
				$contactNameLabel	=>	$contactName,
				$salesOrderLabel	=>	$salesOrder,
				$contactphone => $Phone,
				$contactmobil => $Mobile,
				$contactemail => $email,
				$receivedleble => $recevName,
				$recevidPhoneLebel =>$recevidPhone,

			);
		return $modelColumnCenter;
	}

	function buildHeaderModelColumnRight() {
		$issueDateLabel = 'Issued Date';
		$validDateLabel = 'Valid Date';
		$billingAddressLabel = 'Billing Address';

		$shippingAddressLabel = getTranslatedString('Shipping Address', $this->moduleName);
        $Ysername="username";
        $terms_conditions="terms_conditions";
		$modelColumnRight = array(
				'dates' => array(
					$issueDateLabel  => $this->formatDate(date("Y-m-d")),
					$validDateLabel => $this->formatDate($this->focusColumnValue('duedate')),
				),
				$billingAddressLabel  => $this->buildHeaderBillingAddress(),
				$shippingAddressLabel => $this->buildHeaderShippingAddress(),
				$Ysername => $this->resolveReferenceLabel($this->focusColumnValue('assigned_user_id'),'Users'),
				$terms_conditions => $this->focusColumnValue('terms_conditions'),
				'VendorNameL' => $this->resolveReferenceLabel($this->focusColumnValue('cf_954'), 'Vendors'),
				
			);
		return $modelColumnRight;
	}

	function getWatermarkContent() {
		//return $this->focusColumnValue('invoicestatus');
		return 'الأسطورة';
	}
}
?>
