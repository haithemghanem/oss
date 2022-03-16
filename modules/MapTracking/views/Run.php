

<?php
/*
* Vtiger_Index_View
*Vtiger_Detail_View
Vtiger_View_Controller
Vtiger_List_View

*/

class MapTracking_Run_View extends Vtiger_Index_View {

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


		//$activationtracking=$currentUser->get('activationtracking');
		//$trackingpein=$currentUser->get('trackingperiods');
        $adb = PearDatabase::getInstance();
        $sql="SELECT activationtracking ,trackingperiods FROM vtiger_users WHERE id=? LIMIT 1";
		$sqlresult = $adb->pquery($sql,array($userid));

		$trackingpein= $adb->query_result($sqlresult, 0, 'trackingperiods');
		$activationtracking=$adb->query_result($sqlresult, 0, 'activationtracking');
         

		$trackingperiodsintger;
		switch ($trackingperiods){
          case '1 minutes' :  $trackingperiodsintger=  1000*60*1; break;
          case '5 minutes' :  $trackingperiodsintger=  1000*60*5; break;
          case '10 minutes' : $trackingperiodsintger= 1000*60*10; break;
          case '15 minutes' : $trackingperiodsintger= 1000*60*15; break;
          case '20 minutes' : $trackingperiodsintger= 1000*60*20; break;
          case '25 minutes' : $trackingperiodsintger= 1000*60*25; break;
          case '30 minutes' : $trackingperiodsintger= 1000*60*30; break;
          case '35 minutes' : $trackingperiodsintger= 1000*60*35; break;
          case '40 minutes' : $trackingperiodsintger= 1000*60*40; break;
          case '45 minutes' : $trackingperiodsintger= 1000*60*45; break;
          case '50 minutes' : $trackingperiodsintger= 1000*60*50; break;
          case '55 minutes' : $trackingperiodsintger= 1000*60*55; break;
          case '60 minutes' : $trackingperiodsintger= 1000*60*60; break;
          case '90 minutes' : $trackingperiodsintger= 1000*60*90; break;
        }
		//is_admin
		$trackingPeriods=self::trackingPeriods();
		$data=date('Y-m-d');
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('DATADAY',$data);
		$viewer->assign('ACTIVATIONTRACKING',$activationtracking);
        $viewer->assign('trackingperiodsintger',$trackingperiodsintger);
		$viewer->assign('TRACKINGPERIODSLIST',$trackingPeriods);
		$viewer->assign('TRACKINGPERIODS',$trackingpein);

		$viewer->view('RunTracking.tpl', $moduleName);
	}

	function trackingPeriods(){
       $db = PearDatabase::getInstance();
		$sql ="SELECT * FROM vtiger_trackingperiods ORDER BY  vtiger_trackingperiods.sortorderid";
		$result = $db->pquery($sql, array());
		$notracking = $db->num_rows($result);
		$tracking = array();
		if($notracking > 0) {
			for($i=0; $i<$notracking; ++$i) {
				$trackingId = $db->query_result($result, $i, 'trackingperiodsid');
				$fullname = $db->query_result($result, $i, 'trackingperiods');
				$tracking[$trackingId] = $fullname;
			}

		}
		return $tracking;
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