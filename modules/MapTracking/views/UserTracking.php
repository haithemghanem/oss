

<?php
/*
* Vtiger_Index_View
*Vtiger_Detail_View
Vtiger_View_Controller
Vtiger_List_View

*/

class MapTracking_UserTracking_View extends Vtiger_Index_View {

   function checkPermission(Vtiger_Request $request) {
		//Return true as WebUI.php is already checking for module permission
		return true;
	}

	public function preProcessm(Vtiger_Request $request, $display = true) {
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		parent::preProcess($request, false);
		if($display) {
			$this->preProcessDisplay($request);
		}
	}

	
	
	protected function preProcessTplName(Vtiger_Request $request) {
		return 'MapTrackingViewPreProcess.tpl';
	}

	function process (Vtiger_Request $request) {
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();
		$viewer->assign('MODULE_NAME',$moduleName);

		$currentUser = Users_Record_Model::getCurrentUserModel();
		$userid=$currentUser->getId();
		$alluser =$currentUser->usersfullname();
		$activationtracking=$currentUser->get('activationtracking');
		
		$trackingperiods=$currentUser->get('trackingperiods');

		//is_admin
		$data=date('Y-m-d');
		$oldtin="01:14:03";
	     $dif=date('H:i:s', strtotime($oldtin) - time());
	     $difm=date('i', strtotime($oldtin) - time());
	     $strint ="old time=".$oldtin."-".date('H:i:s',time())."=".$dif." min=".$difm;
		
		$viewer->assign('ALLUSERS', $alluser);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('DATADAY',$data);
		$viewer->assign('ACTIVATIONTRACKING',$activationtracking);
		$viewer->assign('TRACKINGPERIODS',$trackingperiods);

		$viewer->view('DatailUserTracking.tpl', $moduleName);
	}

	
public function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		  $jsFileNames = array(
		  	 "modules.MapTracking.resources.MapTacking",
		  	);
		  $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		  $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}


}