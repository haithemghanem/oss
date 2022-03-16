<?php

class Contacts_GetNumePhone_View extends Vtiger_BasicAjax_Action {

    public function process(Vtiger_Request $request) {

        $adb = PearDatabase::getInstance();
        $moduleName = $request->getModule();
        $result = array();
        $record = $request->get('record');
        $Phonenum;
        $bookprice=0;
          
         $sql="SELECT vtiger_contactdetails.mobile , vtiger_contactscf.cf_972 as 'city' , vtiger_contactscf.cf_960  as 'bookprice', vtiger_contactscf.cf_974 as 'address', vtiger_contactscf.cf_980 as 'idnumber' FROM vtiger_contactdetails LEFT JOIN  vtiger_contactscf ON  vtiger_contactdetails.contactid = vtiger_contactscf.contactid WHERE vtiger_contactdetails.contactid=? LIMIT 1";
         
         $sql="SELECT vtiger_contactdetails.mobile , vtiger_contactscf.cf_972 as 'city' , vtiger_invoicecf.invoiceid  as 'bookprice', vtiger_contactscf.cf_974 as 'address', vtiger_contactscf.cf_980 as 'idnumber' FROM vtiger_contactdetails 
              LEFT JOIN vtiger_invoicecf on vtiger_invoicecf.cf_944 = vtiger_contactdetails.contactid
              LEFT JOIN  vtiger_contactscf ON  vtiger_contactdetails.contactid = vtiger_contactscf.contactid WHERE vtiger_contactdetails.contactid=? LIMIT 1";
              
         $resultsql = $adb->pquery($sql, array($record));
        if($adb->num_rows($resultsql) > 0){
             $Phonenum=$adb->query_result($resultsql, 0, 'mobile');
             $city=$adb->query_result($resultsql, 0, 'city');
             $address=$adb->query_result($resultsql, 0, 'address');
             $idnumber=$adb->query_result($resultsql, 0, 'idnumber');
             $bookprice=$adb->query_result($resultsql, 0, 'bookprice');
             if($bookprice == "" || $bookprice==null){
                $bookprice =0;
             }
             
             $result['success']=true;
             $result['phone']=$Phonenum;
             $result['city']=getTranslatedString($city,'vtiger');
             $result['address']=$address;
             $result['idnumber']=$idnumber;
             $result['bookprice']=$bookprice;
            
            
          }else{
            $result['success']=fales;
            $result['phone']=$Phonenum;

          }

        
        echo json_encode($result);
        // $response = new Vtiger_Response;
        // $response->setResult($result);
        // $response->emit();
    }
    
}

?>