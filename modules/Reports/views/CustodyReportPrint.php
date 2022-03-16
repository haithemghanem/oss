<?php
//CustodyReportPrint
class Reports_CustodyReportPrint_View extends Vtiger_View_Controller {

    public function checkPermission(Vtiger_Request $request) {
        $moduleName = $request->getModule();
        $moduleModel = Reports_Module_Model::getInstance($moduleName);

        $currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if(!$currentUserPriviligesModel->hasModulePermission($moduleModel->getId())) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
    }

    function preProcess(Vtiger_Request $request) {
        return false;
    }

   
    function postProcess(Vtiger_Request $request) {
        return false;
    }

    function process(Vtiger_request $request) {

        
        global $adb;
        $inval = "";
        $CodeBro="";
        
        
        // echo "goood";
        // exit;
        
        $frombranch = $request->get('frombranch');
        $date = $request->get('date');
        $dateto = $request->get('dateto');
        $datalebel="";
        
        $datasql="";
        if ( $date  != '' &&  $dateto !='0'){
             $datasql = "  AND (vtiger_invoice.invoicedate BETWEEN '$date' AND '$dateto')  ";
             $datalebel =$date." ___ ".$dateto;
            
        echo  "<br>";
        
        }else if ($date  !='' && $dateto =='0'){
             $datasql = " AND  vtiger_invoice.invoicedate ='$date'  ";
             $datalebel = $date;
        }
        
        if($frombranch=="Jeddah"){
            $CodeBro ="1204001";
        }elseif($frombranch=="Khamis Mushait"){
            $CodeBro ="1204002";
        }elseif($frombranch=="Abha"){
            $CodeBro ="1204003";
        }elseif($frombranch=="Mahail Asir"){
            $CodeBro ="1204004";
        }elseif($frombranch=="jawal alttayir Jeddah"){
            $CodeBro ="1204005";
        }elseif($frombranch=="jawal alttayir KM"){
            $CodeBro ="1204006";
        }
        



        $data='<table dir="rtl" width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData">
                       <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData">';
                $data .='<thead>
                <tr class="padding-1">
                <th>#</th>
                <th>رقم الفاتورة</th>
                <th>اسم العميل</th>
               
                <th>التاريخ</th>
               
                
                
                <th>قيمة العهدة</th>
                <th>الإجمالي قبل الضريبة</th>
                <th>الضريبة</th>
              
                

                </tr>
                </thead> <tbody>'; 

     
        $Sql="
         SELECT vtiger_invoice.invoiceid, vtiger_invoice.discount_amount as 'invoice_discount_amount', vtiger_invoice.total ,  vtiger_invoicecf.cf_958 as numcapan, vtiger_invoice.pre_tax_total AS 'Invoice_Pre_Tax_Total',vtiger_invoice.deliveryvalue , vtiger_invoice.storagevalue , vtiger_invoicecf.cf_987 AS 'sendername', vtiger_invoicecf.cf_950 AS 'Invoice_To_branch', vtiger_invoicecf.cf_948 AS 'Invoice_From_branch', (CASE WHEN vtiger_invoice.contactid NOT LIKE '' THEN (CASE WHEN trim(CONCAT(vtiger_contactdetailsInvoice.firstname,' ',vtiger_contactdetailsInvoice.lastname)) NOT LIKE '' THEN trim(CONCAT(vtiger_contactdetailsInvoice.firstname,' ',vtiger_contactdetailsInvoice.lastname)) ELSE '' END) ELSE '' END) AS 'Invoice_Contact_Name', (CASE WHEN vtiger_invoicecf.cf_944 NOT LIKE '' THEN (CASE WHEN trim(CONCAT(vtiger_contactdetailsRelInvoice945.firstname,' ')) NOT LIKE '' THEN trim(CONCAT(vtiger_contactdetailsRelInvoice945.firstname,' ')) ELSE '' END) ELSE '' END) AS 'Invoice_Received_Name', vtiger_invoice.invoicedate AS 'Invoice_Invoice_Date', vtiger_invoice.invoice_no AS 'Invoice_Invoice_No', CASE WHEN (vtiger_productsInvoice.productname NOT LIKE '') THEN vtiger_productsInvoice.productname ELSE vtiger_serviceInvoice.servicename END AS 'Invoice_Item_Name', vtiger_inventoryproductreltmpInvoice.quantity AS 'Invoice_Quantity', CASE WHEN vtiger_currency_infoInvoice.id = vtiger_usersInvoice.currency_id THEN vtiger_inventoryproductreltmpInvoice.listprice/vtiger_currency_infoInvoice.conversion_rate ELSE vtiger_inventoryproductreltmpInvoice.listprice/vtiger_invoice.conversion_rate END AS 'Invoice_List_Price', vtiger_inventoryproductreltmpInvoice.comment AS 'Invoice_Item_Comment', vtiger_invoice.subject AS 'Invoice_Subject',
                vtiger_invoice.subtotal AS 'Invoice_Sub_Total',
                vtiger_invoice.received AS 'Invoice_Received', 
                vtiger_invoice.balance AS 'Invoice_Balance',

            (CASE WHEN vtiger_invoicecf.cf_954 NOT LIKE '' THEN (CASE WHEN trim(vtiger_vendorRelInvoice955.vendorname) NOT LIKE '' THEN trim(vtiger_vendorRelInvoice955.vendorname) ELSE '' END) ELSE '' END) AS 'Invoice_Name_Carrier', vtiger_invoicecf.cf_958 AS 'Invoice_Expedition_Number', vtiger_invoicecf.cf_956 AS 'Invoice_Date_Transfer', vtiger_inventoryproductreltmpInvoice.tax1 AS 'Invoice_VAT', vtiger_invoice.s_h_percent AS 'Invoice_S&H_Percent', vtiger_inventoryproductreltmpInvoice.tax3 AS 'Invoice_Service', vtiger_crmentity.crmid AS 'Invoice_LBL_ACTION' ,
            GROUP_CONCAT(concat( FORMAT(vtiger_inventoryproductreltmpInvoice.quantity,0),':',vtiger_serviceInvoice.servicename ) SEPARATOR ' +') AS 'descrip item',
            COUNT(vtiger_serviceInvoice.servicename) AS 'countitem' ,
            Sum(vtiger_inventoryproductreltmpInvoice.tax1) as totoletax1,

            SUM(vtiger_inventoryproductreltmpInvoice.quantity) AS 'Sum Qutity'

            from vtiger_invoice inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_invoice.invoiceid left join vtiger_currency_info as vtiger_currency_infoInvoice on vtiger_currency_infoInvoice.id = vtiger_invoice.currency_id left join vtiger_inventoryproductrel as vtiger_inventoryproductreltmpInvoice on vtiger_invoice.invoiceid = vtiger_inventoryproductreltmpInvoice.id left join vtiger_products as vtiger_productsInvoice on vtiger_productsInvoice.productid = vtiger_inventoryproductreltmpInvoice.productid left join vtiger_service as vtiger_serviceInvoice on vtiger_serviceInvoice.serviceid = vtiger_inventoryproductreltmpInvoice.productid left join vtiger_invoicecf on vtiger_invoice.invoiceid = vtiger_invoicecf.invoiceid left join vtiger_users as vtiger_usersInvoice on vtiger_usersInvoice.id = vtiger_crmentity.smownerid left join vtiger_groups on vtiger_groups.groupid = vtiger_crmentity.smownerid left join vtiger_users on vtiger_users.id = vtiger_crmentity.smownerid left join vtiger_contactdetails as vtiger_contactdetailsInvoice on vtiger_contactdetailsInvoice.contactid = vtiger_invoice.contactid left join vtiger_contactdetails as vtiger_contactdetailsRelInvoice945 on vtiger_contactdetailsRelInvoice945.contactid = vtiger_invoicecf.cf_944 left join vtiger_vendor as vtiger_vendorRelInvoice955 on vtiger_vendorRelInvoice955.vendorid = vtiger_invoicecf.cf_954 
            WHERE vtiger_invoice.invoiceid > 0 AND vtiger_crmentity.deleted=0 ";
            
            
            if(!empty($frombranch) &&  $frombranch =="Jeddah"){
                 $Sql.=" AND ( vtiger_invoicecf.cf_948 IN ('$frombranch')  OR   vtiger_invoicecf.cf_950 IN ('$frombranch')  OR (vtiger_invoicecf.cf_948 IN ('Mahail Asir')  AND   vtiger_invoicecf.cf_950 IN ('Riyadh')) )";
            }elseif(!empty($frombranch) &&  $frombranch =="Mahail Asir"){
                 $Sql.=" AND (vtiger_invoicecf.cf_948 IN ('$frombranch')  OR   vtiger_invoicecf.cf_950 IN ('$frombranch' ) ) ";
                 //$Sql.=" AND vtiger_invoicecf.cf_950 NOT IN ('Riyadh') ";
                 
            }else
            {
                if(!empty($frombranch)){
                 $Sql.=" AND ( vtiger_invoicecf.cf_948 IN ('$frombranch')  OR   vtiger_invoicecf.cf_950 IN ('$frombranch') )";
             }
            }
            
            if(!empty($frombranch)){
                //$Sql.=" AND ( vtiger_invoicecf.cf_948 IN ('$frombranch')  OR   vtiger_invoicecf.cf_950 IN ('$frombranch') )";
             }

           if(!empty($inval)){
             // $Sql.=" AND  vtiger_invoicecf.cf_950 IN ($inval) ";
           }
           
           if(!empty($datasql)){
                $Sql.=$datasql;

           }

           $Sql.=" GROUP BY vtiger_invoice.invoice_no order by vtiger_invoice.invoice_no   LIMIT 0, 50000 ";

          //echo $Sql;
          //exit(); //DESC
        
         $sumquantity=0;
         
         
         $sumothercoust=0;
         $sumgrandtotal=0;
         $Invoice_Receivedtotal=0;
         $Invoice_Balance_sub =0;
         $Q_count_totoal=0;
         $coustreqird_totoal=0;
         $paramter=array();
         $sequ=1;
         
         $sumcoust = 0;
         $sumtax=0;
         $custody_amount_total=0;
         
         $result=$adb->pquery($Sql,$paramter);
          if($adb->num_rows($result) > 0)
            {
                
              while($roww = $adb->fetch_array($result))
               { 
                   
                   
                 $id_inv = $roww['invoiceid'];

                //echo json_encode($roww);
                //$Carriersid =$roww['invoice_name_carrier']; 
                $invoic_no = $roww['invoice_invoice_no'];
                $recver = $roww['invoice_received_name'];
                $sender = $roww['sendername'];
                $typedecrip = $roww['descrip item'];
                $datainv = $roww['invoice_invoice_date'];
                $numcapan = $roww['numcapan'];

                $quanty = $roww['sum qutity'];
                 $sumquantity = $sumquantity+$quanty;

                $coust  = $roww['invoice_sub_total']; 
                
                
                $Invoice_Received = $roww['invoice_received'];
                $Invoice_Receivedtotal = $Invoice_Receivedtotal + $Invoice_Received ;
                $Invoice_Balance = $roww['invoice_balance'];
                $Invoice_Balance_sub += $Invoice_Balance;
                $invoice_discount_amount = $roww['invoice_discount_amount'];

                //$tax   = 0.05 * $roww['invoice_sub_total'];
                $taxpro = ($roww['totoletax1'] / $roww['countitem']) / 100;
                $tax   = $taxpro * ($roww['invoice_sub_total']-$invoice_discount_amount);
                //$tax   = ($Invoice_Received + $Invoice_Balance) -$roww['invoice_pre_tax_total'] ;
                
               

                $othercoust=$roww['invoice_s&h_percent']; 
                $sumothercoust =$sumothercoust+$othercoust;

                $grandtotal=($tax + $coust ) - $invoice_discount_amount;
                
                $sumgrandtotal =$sumgrandtotal+$grandtotal;
                

                $from_branch =$roww['invoice_from_branch'];
                $invoice_to_branch = $roww['invoice_to_branch'];
                
                $custody_amount =0;
                
                $arrbro = array('Riyadh','Dawasir Valley'); //'jawal alttayir Jeddah','jawal alttayir KM'
                
                if($frombranch=="Jeddah"){
                 if($from_branch == "Mahail Asir"  && $invoice_to_branch== "Riyadh" ){
                     $custody_amount =  $Invoice_Balance;
                 }elseif(in_array($from_branch, $arrbro) || in_array($invoice_to_branch, $arrbro)){
                     $custody_amount = $grandtotal;
                 }elseif($from_branch == "Jeddah"){
                     $custody_amount =  $Invoice_Received;
                 }elseif($invoice_to_branch == "Jeddah"){
                     $custody_amount =  $Invoice_Balance;
                 }
                 
                }elseif($frombranch=="Khamis Mushait"){
                  
                  if($from_branch =="Riyadh" || $invoice_to_branch =="Riyadh"){
                     $custody_amount = $grandtotal;
                     
                 }elseif($from_branch == "Khamis Mushait"){
                     $custody_amount =  $Invoice_Received;
                 }elseif($invoice_to_branch == "Khamis Mushait"){
                     $custody_amount =  $Invoice_Balance;
                 }
                  
                }elseif($frombranch=="Abha"){
                    if($from_branch =="Riyadh" || $invoice_to_branch =="Riyadh"){
                     $custody_amount = $grandtotal;
                     
                 }elseif($from_branch == "Abha"){
                     $custody_amount =  $Invoice_Received;
                 }elseif($invoice_to_branch == "Abha"){
                     $custody_amount =  $Invoice_Balance;
                 }
                    
                 
                }elseif($frombranch=="Mahail Asir"){
                    
                    if($from_branch == "Mahail Asir" && $invoice_to_branch=="Riyadh"){
                       $custody_amount = $Invoice_Received;
                    }elseif($from_branch == "Riyadh" && $invoice_to_branch =="Mahail Asir"){
                        $custody_amount = $grandtotal;
                    }
                    elseif($from_branch == "Mahail Asir"){
                        $custody_amount =  $Invoice_Received;
                    }elseif($invoice_to_branch == "Mahail Asir"){
                        $custody_amount =  $Invoice_Balance;
                    }
                    
                }elseif($frombranch=="jawal alttayir Jeddah"){
                    
                    if($from_branch == "jawal alttayir Jeddah" && $invoice_to_branch =="Tabuk"){
                        $custody_amount = $grandtotal;
                    }elseif($from_branch == "Tabuk" && $invoice_to_branch =="jawal alttayir Jeddah"){
                         $custody_amount = $grandtotal;
                    }elseif($from_branch == "jawal alttayir Jeddah"){
                        $custody_amount =  $Invoice_Received;
                    }elseif($invoice_to_branch == "jawal alttayir Jeddah"){
                        $custody_amount =  $Invoice_Balance;
                    }
                    
                }elseif($frombranch=="jawal alttayir KM"){
                    
                    if($from_branch =="Riyadh" || $invoice_to_branch =="Riyadh"){
                       $custody_amount = $grandtotal;
                    }elseif($from_branch == "jawal alttayir KM"){
                        $custody_amount =  $Invoice_Received;
                    }elseif($invoice_to_branch == "jawal alttayir KM"){
                        $custody_amount =  $Invoice_Balance;
                    }
                }else{
                    $custody_amount =0;
                }
                    
                 
                
                
                if($custody_amount >= 1){
                  $custody_amount_total = $custody_amount_total + $custody_amount;
                  $sumcoust =$sumcoust + ($coust-$invoice_discount_amount);
                  $invoice_discount_amount_total +=$invoice_discount_amount;
                  $sumtax =$sumtax+$tax; 
                  
                 $data.='<tr class="padding-1">
                 <td><a href="index.php?module=Invoice&view=Detail&record='.$id_inv.'&app=INVENTORY" target="_blank">'.$sequ.' </a></td>
                 <td>'.$invoic_no.'</td>
                 <td>'.$recver.'</td>
                 
                 <td>'.$datainv.'</td>
                 
                 
                 
                 <td>'.number_format($custody_amount,2).'</td>
                 <td>'.number_format($coust - $invoice_discount_amount,2).'</td>
                 <td>'.number_format($tax,2).'</td>
                
                 
                 
                 </tr>
                   ';
                    $sequ=$sequ+1; 
                }
                

                                
                                  
               }

               $data.='<tr class="padding-1">
                
                 <td colspan="4">الاجمالي </td>
                 <td class="wrwarp" >'.number_format($sumcoust + $sumtax,2).'</td>
                 <td class="wrwarp" >'.number_format($sumcoust,2).'</td>
                 <td class="wrwarp" >'.number_format($sumtax,2).'</td>
                 
                 
                 </tr>
                 
                 

                 
                   ';

                

            }else{

                $data ="<br> <br> <p style='text-align:center'> لايوجد سجلات , تاكد من الشروط التي وضعتها </p>";
            }

           $data.=' </tbody></table>';



        ?>




<!DOCTYPE>
<html>
    <head>
        <link rel="SHORTCUT ICON" href="layouts/v7/skins/images/favicon.ico">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>تقرير العهد-<?php  echo vtranslate($frombranch,'Invoice') ?>-<?php  echo $datalebel; ?></title>
        
        <style type="text/css" media="print,screen">

          

               .printReport ,.reportPrintHeader{
                direction: rtl;
               }
               .reportPrintHeader .left{
                float: right;

               }
               .reportPrintHeader .right{
                float: left;
               }
               
                .printReport{
                    width:100%;
                    border:1px solid #000000;
                    border-collapse:collapse;
                }
                .printReport tbody td{
                    border:1px dotted #000000;
                    text-align:right;
                }
                .printReport thead th{
                    border-bottom:2px solid #000000;
                    border-left:1px solid #000000;
                    border-top:1px solid #000000;
                    border-right:1px solid #000000;
                }
                thead {
                    display:table-header-group;
                }
                tbody {
                    display:table-row-group;
                }
                .count{
                    width:10px;
                }
                
                .wrwarp_old{
                    overflow-wrap: break-word;
                    max-width:20px !important;
                }
                tr.padding-1 th{
                     padding:4px 1px;
                }
                
                tr.padding-1 td{
                    padding:4px 1px;
                }
                
        </style>
    </head>
    <body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" style="text-align:center;" onLoad="" >
        <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
            <tr class="reportPrintHeader">
                <td  class="left"  valign="top" style="border:0px solid #000000;">
                     <h4>  الاسطورة للنقل </h4>
                    <font  color="#666666"><div id="report_info">
                    </div></font>
                </td>
                
                <td  class=""  style="border:0px solid #000000;padding-right: 18%;" valign="top">
                    <h4 style="color:#CCCCCC"> الرقم الضريبي :300523053400003  </h4>
                </td>
                
                <td  class="right"  style="border:0px solid #000000;padding-left: 18%;" valign="top">
                    <h4 style="color:#CCCCCC">تقرير العهد</h4>
                </td>
            </tr>
            <tr><td colspan="3">
                <div style="text-align: right">
                    <table dir="rtl" width="100%" border="0" cellpadding="5" cellspacing="0" align="center" style="text-align: right">
                        <thead>
                            <tr>
                          
                               
                                 <th>الفرع</th>
                                 <th>الكود</th>
                                 <th> التاريخ </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           
                            
                            <td><?php  echo vtranslate($frombranch,'Invoice') ?></td>
                            <td><?php echo $CodeBro ; ?></td>
                            <td><?php  echo $datalebel; ?></td>
                        <tr>
                    </tbody>
                    </table>



                <div>
            </td></tr>
            
            <tr>
                <td style="border:0px solid #000000;" colspan="3">
                    
                    <?php echo $data;  ?>
                </td>
            </tr>
          
            <tr>
                <td colspan="3">
                    
                </td>
            </tr>
        </table>
    </body>
   
        
</html>



        <?php
    }

}

?>