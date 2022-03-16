<?php

//

class Invoice_GetlistPrice_View extends Vtiger_Detail_View {

	function checkPermission(Vtiger_Request $request) {
		return true;
	}

	function preProcess(Vtiger_Request $request) {
		return true;
	}

	function postProcess(Vtiger_Request $request) {
		return true;
	}

	function process(Vtiger_Request $request) {
		$db = PearDatabase::getInstance();
		$serviceid=$request->get('serviceid');
		$contactsid = $request->get('contactsid');
		$res = array();
		$res['sucess']=false;
		$res['price']=0;
		if(!empty($serviceid)  && !empty($contactsid)){
		    
		 $sql2="SELECT  FORMAT(vtiger_inventoryproductrel.listprice,2) as listprice FROM vtiger_inventoryproductrel 
         INNER JOIN vtiger_invoicecf  on  vtiger_invoicecf.invoiceid = vtiger_inventoryproductrel.id 
         WHERE vtiger_inventoryproductrel.productid =?  and vtiger_inventoryproductrel.listprice > 0 and vtiger_invoicecf.cf_944=? ORDER BY vtiger_inventoryproductrel.lineitem_id DESC LIMIT 1";
			
            $result2 = $db->pquery($sql2, array($serviceid ,$contactsid ));
            if($db->num_rows($result2) > 0){
            	$price=$db->query_result($result2, 0, 'listprice');
            	if(!empty($price)){
            	$res['sucess']=true;
            	$res['price']=$price;
             }
            
         }
		    
// 		 $sql="SELECT cf_960 FROM vtiger_contactscf WHERE contactid=? LIMIT 1";
//          $result = $db->pquery($sql, array($contactsid));
//         if($db->num_rows($result) > 0){
//         	$pricebookid=$db->query_result($result, 0, 'cf_960');
//         	$sql2="SELECT FORMAT(listprice,2) as listprice FROM vtiger_pricebookproductrel WHERE pricebookid=? AND productid=?  LIMIT 1";
//             $result2 = $db->pquery($sql2, array($pricebookid ,$serviceid));
//             if($db->num_rows($result2) > 0){

//             	$price=$db->query_result($result2, 0, 'listprice');
//             	$res['sucess']=true;
//             	$res['price']=$price ;
//             }
//         }
    }
		echo json_encode($res);
		
	}
}

?>