<?php


class Vtiger_History_View extends Vtiger_Index_View {



   public function checkPermission(Vtiger_Request $request) {

		$moduleName = $request->getModule();
		$moduleModel = Reports_Module_Model::getInstance($moduleName);

		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserPriviligesModel->hasModulePermission($moduleModel->getId())) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
		}
	}


	public function process(Vtiger_Request $request) {
		$LIMIT = 100;

		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$historyType = $request->get('historyType');
		$userId = $request->get('type');
           
		$page = $request->get('page');
		if(empty($page)) {
			$page = 1;
		}
		$linkId = $request->get('linkid');

		$modifiedTimestart = $request->get('start');
		$modifiedTimeend = $request->get('end');
		//Date conversion from user to database format
		if(!empty($modifiedTimestart) &&  !empty($modifiedTimeend) ) {
			$startDate = Vtiger_Date_UIType::getDBInsertedValue($modifiedTimestart);
			$dates['start'] = getValidDBInsertDateTimeValue($startDate . ' 00:00:00');
			$endDate = Vtiger_Date_UIType::getDBInsertedValue($modifiedTimeend);
			$dates['end'] = getValidDBInsertDateTimeValue($endDate . ' 23:59:59');
		}
		$pagingModel = new Vtiger_Paging_Model();
		$pagingModel->set('page', $page);
		$pagingModel->set('limit', $LIMIT);
        

		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$history = $moduleModel->getHistory($pagingModel, $historyType,$userId, $dates);
		//$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$modCommentsModel = Vtiger_Module_Model::getInstance('ModComments'); 
		
         
         //var_dump($modifiedTimestart);
         //exit();

		$viewer->assign('CURRENT_USER', $currentUser);
		$viewer->assign('USERIDD', $userId);
		$viewer->assign('HISTORYTYPE', $historyType);
		$viewer->assign('MODIFIEDSTART', $modifiedTimestart);
		$viewer->assign('MODIFIEDEND',  $modifiedTimeend);
		
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('HISTORIES', $history);
		$viewer->assign('PAGE', $page);
		$viewer->assign('HISTORY_TYPE', $historyType); 
		$viewer->assign('NEXTPAGE', ($pagingModel->get('historycount') < $LIMIT)? 0 : $page+1);
		$viewer->assign('COMMENTS_MODULE_MODEL', $modCommentsModel);

		$userCurrencyInfo = getCurrencySymbolandCRate($currentUser->get('currency_id'));
		$viewer->assign('USER_CURRENCY_SYMBOL', $userCurrencyInfo['symbol']);
		
		$content = $request->get('content');
		if(!empty($content)) {
			$viewer->view('dashboards/HistoryContents2.tpl', $moduleName);
		} else {
			$accessibleUsers = $currentUser->getAccessibleUsers();
			$viewer->assign('ACCESSIBLE_USERS', $accessibleUsers);
		    $newview = $viewer->view('dashboards/HistoryContents2.tpl', $moduleName);
		

		}
		
	}

}
