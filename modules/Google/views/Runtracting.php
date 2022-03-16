

<?php
/*
* Vtiger_Index_View
*Vtiger_Detail_View
Vtiger_View_Controller
*/

class Google_Runtracting_View extends Vtiger_Index_View {

	function process (Vtiger_Request $request) {
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();
		$viewer->assign('Module',$moduleName);
		//$viewer->assign('HOME_PAGE_WIDGETS', Home_Widget_Model::getAll());

		echo $viewer->view('RunTracking.tpl', $moduleName);
		// "Test Page:".$moduleName;
	}



}