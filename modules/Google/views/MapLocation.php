<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Google_MapLocation_View extends Vtiger_Detail_View {

	function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');

		$recordPermission = Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $recordId);
		if(!$recordPermission) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
		}

		return true;
	}

	/**
	 * must be overriden
	 * @param Vtiger_Request $request
	 * @return boolean 
	 */
	function preProcess(Vtiger_Request $request) {
		return true;
	}

	/**
	 * must be overriden
	 * @param Vtiger_Request $request
	 * @return boolean 
	 */
	function postProcess(Vtiger_Request $request) {
		return true;
	}

	/**
	 * called when the request is recieved.
	 * if viewtype : detail then show location
	 * TODO : if viewtype : list then show the optimal route.
	 * @param Vtiger_Request $request 
	 */
	function process(Vtiger_Request $request) {
		switch ($request->get('viewtype')) {
			case 'detail':$this->showLocation($request);
				break;

			case 'savelocation':$this->savelocation($request);
				break;
			default:break;
		}
	}


	function savelocation(Vtiger_Request $request){
		$db = PearDatabase::getInstance();
        $user = Users_Record_Model::getCurrentUserModel();
        $userId = $user->getId();
        $recordid=$request->get('record');
        $source_modul=$request->get('source_module');
        $Let=$request->get('let');
        $Lng=$request->get('lng');
        $Lebel="error";
        $res = array();
        $sql="SELECT * FROM maplocation WHERE idmap=? LIMIT 1";
         $result = $db->pquery($sql, array($recordid));
        if($db->num_rows($result) > 0){
           $update="UPDATE maplocation SET let=?,lng=?,userid=? WHERE 1 idmap=?";
           $result2 = $db->pquery($update, array($Let,$Lng,$userId,$recordid));
           $sql2="SELECT label FROM vtiger_crmentity WHERE crmid=? LIMIT 1";
	           $result3 = $db->pquery($sql2, array($recordid));
	           if($db->num_rows($result3) > 0){
	           	 $Lebel=$db->query_result($result3, 0, 'label');
	           }
        }else{
        	 $insert="INSERT INTO maplocation(idmap, model, title, let, lng, userid) VALUES (?,?,?,?,?,?)";
        	 $result2 = $db->pquery($insert, array($recordid,$source_modul,"",$Let,$Lng,$userId));

        	   $sql2="SELECT label FROM vtiger_crmentity WHERE crmid=? LIMIT 1";
	           $result3 = $db->pquery($sql2, array($recordid));
	           if($db->num_rows($result3) > 0){
	           	 $Lebel=$db->query_result($result3, 0, 'label');
	           }
         }
         $res['Lebel']=$Lebel;
       echo json_encode($res);
	}

	/**
	 * display the template.
	 * @param Vtiger_Request $request 
	 */
	function showLocation(Vtiger_Request $request) {
		$db = PearDatabase::getInstance();
        $recordid=$request->get('record');
        $source_modul=$request->get('source_module');
        $Lebel=getTranslatedString('undefined');
        //$lat ="21.48632343805013";
		//$lng ="39.19441674804693";
		$lat;
		$lng;
          

        $sql="SELECT let,lng FROM maplocation WHERE idmap=? LIMIT 1";
         $resul = $db->pquery($sql, array($recordid));
        if($db->num_rows($resul) > 0){
            $lat=$db->query_result($resul, 0, 'let');
            $lng=$db->query_result($resul, 0, 'lng');
        	
           
           $sql2="SELECT label FROM vtiger_crmentity WHERE crmid=? LIMIT 1";
           $result2 = $db->pquery($sql2, array($recordid));
           if($db->num_rows($result2) > 0){
           	 $Lebel=$db->query_result($result2, 0, 'label');
           }
        }
        
		

		//SELECT * FROM `maplocation` WHERE 1
		//SELECT `idmap`, `model`, `title`, `let`, `lng`, `userid` FROM `maplocation` WHERE 1

		// record and source_module values to be passed to populate the values in the template,
		// required to get the respective records address based on the module type.
		//$lat =21.48632343805013;
		//$lng =39.19441674804693;
		

        $viewer = $this->getViewer($request);
		$viewer->assign('LAT', $lat);
		$viewer->assign('LNG', $lng);
		$viewer->assign('Lebel', $Lebel);
		$viewer->assign('RECORD', $request->get('record'));
		$viewer->assign('SOURCE_MODULE', $request->get('source_module'));
		$viewer->view('maplocaltions.tpl', $request->getModule());
	}

}