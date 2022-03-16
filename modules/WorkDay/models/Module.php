<?php
class WorkDay_Module_Model extends Vtiger_Module_Model {




public function isSummaryViewSupported() {
		return false;
}
	
	
/*
* Function to get supported utility actions for a module
*/
	public function getUtilityActionsNames() {
		return array('Import', 'Export', 'DuplicatesHandling');
	}

}
?>

