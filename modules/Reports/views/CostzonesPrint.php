<?php
//CostzonesPrint.php
class Reports_CostzonesPrint_View extends Vtiger_View_Controller {

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

    
    $tobranch =$request->get('tobranch');
    $tobranch1 = explode(',', $tobranch);

    $frombranch = $request->get('frombranch');
    $carrid = $request->get('$carri');
    $carrname= "";

        $tobranchlebel="";
        $count=count($tobranch1);
        if( $count > 0){
            for($i=1 ; $i <=  $count; $i++){
             $inval .='"'.$tobranch1[$i-1].'"';
             $tobranchlebel.=vtranslate($tobranch1[$i-1],'Invoice');
                if($i < $count)
                {
                  $inval .=",";
                  $tobranchlebel .=", ";
                }
            }
        }
         //$Carriersid = $request->get('Carriersid');
        $date = $request->get('date');
        $dateto = $request->get('dateto');


        $datalebel="";
        $datasql="";

        $curresql="";

        if ( $date  != '' &&  $dateto !='0'){
             $datasql = " AND  vtiger_invoice.invoicedate ='$date'  ";
             $datalebel = $date;
            
        
        }else if ($date  !='' && $dateto =='0'){
             $datasql = "  AND (vtiger_invoice.invoicedate BETWEEN '$date' AND '$dateto')  ";
             $datalebel ="<span>".$date."</span> <span> ___ </span> <span>".$dateto."</span>";
        }

         



        //$campnumber=$request->get('campnumber');

         $data='<table dir="rtl" width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData" >
                       <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData">';
                $data .='<thead>
                <tr>
                <th>#</th>
                <th>رقم السند</th>
                <th>المستلم</th>
                <th>المرسل</th>
                <th>نوع البضاعة</th>
                <th>العدد</th>
                <th>التكلفة</th>
                <th>الخصم</th>
                <th>الضربيه</th>
                <th>الاجمالي</th>
                <th>خالص الاجرة</th>
                <th>الصافي</th>
                <th>تكلفة مناطق</th>
                </tr>
                </thead> <tbody>';
                
                
        
        $Sql="
         SELECT vtiger_invoice.invoiceid, vtiger_invoice.discount_amount as 'invoice_discount_amount', vtiger_invoice.pre_tax_total AS 'Invoice_Pre_Tax_Total',vtiger_invoicecf.cf_987 AS 'sendername', vtiger_invoicecf.cf_950 AS 'Invoice_To_branch', vtiger_invoicecf.cf_948 AS 'Invoice_From_branch', (CASE WHEN vtiger_invoice.contactid NOT LIKE '' THEN (CASE WHEN trim(CONCAT(vtiger_contactdetailsInvoice.firstname,' ',vtiger_contactdetailsInvoice.lastname)) NOT LIKE '' THEN trim(CONCAT(vtiger_contactdetailsInvoice.firstname,' ',vtiger_contactdetailsInvoice.lastname)) ELSE '' END) ELSE '' END) AS 'Invoice_Contact_Name', 
         (CASE WHEN vtiger_invoicecf.cf_944 NOT LIKE '' THEN (CASE WHEN vtiger_contactdetailsRelInvoice945.firstname NOT LIKE '' THEN vtiger_contactdetailsRelInvoice945.firstname ELSE '..' END) ELSE ' ' END) AS 'Invoice_Received_Name', 
         vtiger_invoice.invoicedate AS 'Invoice_Invoice_Date', vtiger_invoice.invoice_no AS 'Invoice_Invoice_No', CASE WHEN (vtiger_productsInvoice.productname NOT LIKE '') THEN vtiger_productsInvoice.productname ELSE vtiger_serviceInvoice.servicename END AS 'Invoice_Item_Name', vtiger_inventoryproductreltmpInvoice.quantity AS 'Invoice_Quantity', CASE WHEN vtiger_currency_infoInvoice.id = vtiger_usersInvoice.currency_id THEN vtiger_inventoryproductreltmpInvoice.listprice/vtiger_currency_infoInvoice.conversion_rate ELSE vtiger_inventoryproductreltmpInvoice.listprice/vtiger_invoice.conversion_rate END AS 'Invoice_List_Price', vtiger_inventoryproductreltmpInvoice.comment AS 'Invoice_Item_Comment', vtiger_invoice.subject AS 'Invoice_Subject',
                vtiger_invoice.subtotal AS 'Invoice_Sub_Total',
                vtiger_invoice.received AS 'Invoice_Received', 
                vtiger_invoice.balance AS 'Invoice_Balance',

          (CASE WHEN vtiger_invoicecf.cf_954 NOT LIKE '' THEN (CASE WHEN trim(vtiger_vendorRelInvoice955.vendorname) NOT LIKE '' THEN trim(vtiger_vendorRelInvoice955.vendorname) ELSE '' END) ELSE '' END) AS 'Invoice_Name_Carrier', vtiger_invoicecf.cf_958 AS 'Invoice_Expedition_Number', vtiger_invoicecf.cf_956 AS 'Invoice_Date_Transfer', vtiger_inventoryproductreltmpInvoice.tax1 AS 'Invoice_VAT', vtiger_invoice.s_h_percent AS 'Invoice_S&H_Percent', vtiger_inventoryproductreltmpInvoice.tax3 AS 'Invoice_Service', vtiger_crmentity.crmid AS 'Invoice_LBL_ACTION' ,
            GROUP_CONCAT(concat( FORMAT(vtiger_inventoryproductreltmpInvoice.quantity,0),':',vtiger_serviceInvoice.servicename ) SEPARATOR ' +') AS 'descrip item',
            COUNT(vtiger_serviceInvoice.servicename) AS 'countitem' ,
            Sum(vtiger_inventoryproductreltmpInvoice.tax1) as totoletax1,

            SUM(vtiger_inventoryproductreltmpInvoice.quantity) AS 'Sum Qutity'

       from vtiger_invoice inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_invoice.invoiceid 
       left join vtiger_currency_info as vtiger_currency_infoInvoice on vtiger_currency_infoInvoice.id = vtiger_invoice.currency_id 
       left join vtiger_inventoryproductrel as vtiger_inventoryproductreltmpInvoice on vtiger_invoice.invoiceid = vtiger_inventoryproductreltmpInvoice.id 
       left join vtiger_products as vtiger_productsInvoice on vtiger_productsInvoice.productid = vtiger_inventoryproductreltmpInvoice.productid 
       left join vtiger_service as vtiger_serviceInvoice on vtiger_serviceInvoice.serviceid = vtiger_inventoryproductreltmpInvoice.productid 
       left join vtiger_invoicecf on vtiger_invoice.invoiceid = vtiger_invoicecf.invoiceid 
       left join vtiger_users as vtiger_usersInvoice on vtiger_usersInvoice.id = vtiger_crmentity.smownerid 
       left join vtiger_groups on vtiger_groups.groupid = vtiger_crmentity.smownerid 
       left join vtiger_users on vtiger_users.id = vtiger_crmentity.smownerid 
       left join vtiger_contactdetails as vtiger_contactdetailsInvoice on vtiger_contactdetailsInvoice.contactid = vtiger_invoice.contactid 
       left join vtiger_contactdetails as vtiger_contactdetailsRelInvoice945 on vtiger_contactdetailsRelInvoice945.contactid = vtiger_invoicecf.cf_944 
       left join vtiger_vendor as vtiger_vendorRelInvoice955 on vtiger_vendorRelInvoice955.vendorid = vtiger_invoicecf.cf_954 
       WHERE vtiger_invoice.invoiceid > 0 AND vtiger_crmentity.deleted=0 
       ";
    //   and 
    // (( vtiger_invoicecf.cf_948 = '$frombranch' and vtiger_invoice.invoicedate = '$date' and vtiger_invoicecf.cf_954 =$carrid  AND  vtiger_invoicecf.cf_950 ='$tobranch' AND vtiger_invoicecf.cf_958='$capnum' ) )
    //  GROUP BY vtiger_invoice.invoice_no order by vtiger_invoice.invoice_no   LIMIT 0, 5000 
    //     ";

        //and vtiger_inventoryproductreltmpInvoice.productid=32359
       if(!empty($datasql)){
                    $Sql.=$datasql;
        }
        
        if(!empty($carrid)){
                    $Sql.=" AND vtiger_invoicecf.cf_954 =$carrid ";
        }
    
    

      if(!empty($frombranch)){
              $Sql.='  AND  vtiger_invoicecf.cf_948 IN ("'.$frombranch.'") ';
      }
    
      if(!empty($inval)){
              $Sql.="    AND  vtiger_invoicecf.cf_950 IN ($inval) ";
      }

        $Sql.=" GROUP BY vtiger_invoice.invoice_no  order by vtiger_invoice.invoice_no   LIMIT 0, 5000 ";
        
        // echo $Sql;
        // exit;
        
      //$Sql9=" GROUP BY vtiger_invoice.invoice_no , vtiger_invoicecf.cf_954 , vtiger_invoicecf.cf_950,  vtiger_invoicecf.cf_958 order by vtiger_invoice.invoicedate DESC";

       

         
         $sumquantity=0;
         $sumcoust = 0;
         $sumtax=0;
         $sumothercoust=0;
         $sumgrandtotal=0;
         $Invoice_Receivedtotal=0;
     
        
         $coustzone_totoal= 0;
         $paramter=array();
         $sequ=1;
         $result=$adb->pquery($Sql,$paramter);
          if($adb->num_rows($result) > 0)
            {
              while($roww = $adb->fetch_array($result))
               { 
                 
                //echo json_encode($roww);
                 $Carriersid =$roww['invoice_name_carrier']; 
                $invoic_no = $roww['invoice_invoice_no'];
                $recver = $roww['invoice_received_name'];
                $sender = $roww['sendername'];
                $typedecrip = $roww['descrip item'];

                $quanty = $roww['sum qutity'];
                 $sumquantity = $sumquantity+$quanty;

                $coust  = $roww['invoice_sub_total']; 
                $sumcoust =$sumcoust+$coust;
                $Invoice_Received = $roww['invoice_received'];
                $Invoice_Receivedtotal = $Invoice_Receivedtotal +$Invoice_Received;
                
                $Invoice_Balance = $roww['invoice_balance'];

                $invoice_discount_amount = $roww['invoice_discount_amount'];
                //$tax   = 0.05 * $roww['invoice_sub_total'];
                $taxpro = ($roww['totoletax1'] / $roww['countitem']) / 100;
                $tax   = $taxpro * ($roww['invoice_sub_total']-$invoice_discount_amount);
                
                $sumtax =$sumtax+$tax; 
                $invoice_discount_amount_total += $invoice_discount_amount;

                $othercoust=$roww['invoice_s&h_percent']; 
                $sumothercoust =$sumothercoust+$othercoust;

                $grandtotal=($tax + $coust ) - $invoice_discount_amount;
                //$grandtotal=$Invoice_Received + $Invoice_Balance;
                
                $Invoice_Balance_sub += $Invoice_Balance;
                $sumgrandtotal =$sumgrandtotal+$grandtotal;
                
                $carrname = $roww['invoice_name_carrier'];
                $frombranch =$roww['invoice_from_branch'];
                
                //
                 $id_inv= $roww['invoiceid'];  $coustzone= 0;
                 $subsql="Select SUM(vtiger_inventoryproductrel.listprice *  vtiger_inventoryproductrel.quantity) AS 'listprice' from vtiger_inventoryproductrel 
                 WHERE vtiger_inventoryproductrel.productid=32359 AND vtiger_inventoryproductrel.id=$id_inv
                 GROUP BY vtiger_inventoryproductrel.id";
                 
                 $subresult=$adb->pquery($subsql,$paramter);
                if($adb->num_rows($subresult) > 0){
                     $coustzone = $adb->query_result($subresult, 0, "listprice");
                }else{
                     $coustzone= 0;
                }
                $coustzone_totoal +=$coustzone;
                
                
                

                
                $data.='<tr>
                 <td><a href="index.php?module=Invoice&view=Detail&record='.$id_inv.'&app=INVENTORY" target="_blank">'.$sequ.' </a></td>
                 <td>'.$invoic_no.'</td>
                 <td>'.$recver.'</td>
                 <td>'.$sender.'</td>
                 <td>'.$typedecrip.'</td>
                 <td>'.number_format($quanty,2).'</td>
                 <td>'.number_format($coust,2).'</td>
                 <td>'.number_format($invoice_discount_amount,2).'</td>
                 <td>'.number_format($tax,2).'</td>
                 <td>'.number_format($grandtotal,2).'</td>
                 <td>'.number_format($Invoice_Received,2).'</td>
                 <td>'.number_format($Invoice_Balance,2).'</td>
                 <td>'.number_format($coustzone,2).'</td>
                 
                 </tr>
                   ';

                 $sequ=$sequ+1;                 
                                  
               }

               $data.='<tr>
               <td colspan="5">الاجمالي الكلي</td>
                 <td>'.number_format($sumquantity,2).' </td>
                 <td>'.number_format($sumcoust,2).'</td>
                 <td>'.number_format($invoice_discount_amount_total,2).'</td>
                 <td>'.number_format($sumtax,2).'</td>
                 <td>'.number_format($sumgrandtotal,2).'</td>
                 <td>'.number_format($Invoice_Receivedtotal,2).'</td>
                 <td>'.number_format($Invoice_Balance_sub,2).'</td>
                 <td>'.number_format($coustzone_totoal,2).'</td>
                 </tr>
                 
                   ';



            }else{
                $data= "لايوجد سجلات ";
            }

           $data.=' </tbody></table>';



        ?>

<!DOCTYPE>
<html>
    <head>
        <link rel="SHORTCUT ICON" href="layouts/v7/skins/images/favicon.ico">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>تقرير تكلفة المناطق</title>
        
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
           
        </style>
    </head>
    <body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" style="text-align:center;" onLoad="JavaScript:window.print()">
        <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
            <tr class="reportPrintHeader">
                <td  class="left"  valign="top" style="border:0px solid #000000;">
                     <h4>  الاسطورة للنقل </h4>
                    <font  color="#666666"><div id="report_info">
                    </div></font>
                </td>
                <td  class="right"  style="border:0px solid #000000;padding-left: 18%;" valign="top">
                    <h4 style="color:#CCCCCC">تقرير تكلفة المناطق</h4>
                </td>
            </tr>
            <tr><td colspan="2">
                <div style="text-align: right">
                    <table dir="rtl" width="100%" border="0" cellpadding="5" cellspacing="0" align="center" style="text-align: right">
                        <thead>
                        <tr>
                        <th><?php echo vtranslate('car num','Invoice'); ?></th>
                        <th>من فرع</th>
                        <th>إلى فرع </th>
                        <th>التاريخ </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php  echo $carrname; ?></td>
                            <td><?php  echo vtranslate($frombranch ,'Invoice'); ?></td>
                            <td><?php  echo $tobranchlebel; ?></td>
                            <td><?php  echo $datalebel; ?></td>
                        <tr>
                    </tbody>
                    </table>



                <div>
            </td></tr>
            
            <tr>
                <td style="border:0px solid #000000;" colspan="2">
                    
                    <?php echo $data;  ?>
                </td>
            </tr>
          
            <tr>
                <td colspan="2">
                    
                </td>
            </tr>
        </table>
    </body>
    
</html>



        <?php
    }




}


?>


