<?php


class Reports_BranchReportsPrint_View extends Vtiger_View_Controller {
//BranchReportsPrint
//BranchReportsPrint.php


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
             $datasql = "  AND (vtiger_invoice.invoicedate BETWEEN '$date' AND '$dateto')  ";
             $datalebel ="<span>".$date."</span> <span> ___ </span> <span>".$dateto."</span>";
            
        
        }else if ($date  !='' && $dateto =='0'){
             $datasql = " AND  vtiger_invoice.invoicedate ='$date'  ";
             $datalebel = $date;
        }

         



        //$campnumber=$request->get('campnumber');

        $data='<table dir="rtl" width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData" >
                       <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData">';
                $data .='<thead>
                <tr>
                <th>مسلسل</th>
                <th>عدد العقود</th>
                 <th>الفرع</th>

                 <th>التاريخ</th>
                 <th> رقم الحملة </th>
                 <th> التفاصيل </th>
                
                </tr>
                </thead> <tbody>';
        
        $Sql="
        SELECT  Count(vtiger_invoice.invoicedate) as countinv,  vtiger_invoicecf.cf_958 as numcapan , vtiger_invoicecf.cf_954 as Carriersnid , vtiger_invoicecf.cf_950 AS 'Invoice_To_branch', vtiger_invoicecf.cf_948 AS 'Invoice_From_branch', vtiger_invoice.invoicedate AS 'invoice_invoice_date',
(CASE WHEN vtiger_invoicecf.cf_954 NOT LIKE '' THEN (CASE WHEN trim(vtiger_vendorRelInvoice955.vendorname) NOT LIKE '' THEN trim(vtiger_vendorRelInvoice955.vendorname) ELSE '' END) ELSE '' END) AS 'Invoice_Name_Carrier'
        
       from vtiger_invoice inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_invoice.invoiceid 
      left join vtiger_invoicecf on vtiger_invoice.invoiceid = vtiger_invoicecf.invoiceid 
      left join vtiger_vendor as vtiger_vendorRelInvoice955 on vtiger_vendorRelInvoice955.vendorid = vtiger_invoicecf.cf_954

      WHERE  vtiger_invoice.invoicedate !='' and vtiger_invoicecf.cf_950 !='' And  vtiger_invoicecf.cf_948 !='' AND vtiger_invoicecf.cf_954 !=''    ";



      
   if(!empty($datasql)){
                $Sql.=$datasql;

    }

    
    if(!empty($inval)){
              $Sql.="    AND  vtiger_invoicecf.cf_950 IN ($inval) ";

      }

     



      $Sql.=" GROUP BY vtiger_invoice.invoicedate , vtiger_invoicecf.cf_950  , vtiger_invoicecf.cf_958 order by vtiger_invoice.invoicedate DESC
        ";


        


         
         $paramter=array();
         $sequ=1;
         $result=$adb->pquery($Sql,$paramter);
          if($adb->num_rows($result) > 0)
            {
                
              while($roww = $adb->fetch_array($result))
               { 

                //echo json_encode($roww);

                $countinv = $roww['countinv'];
                $numcapan = $roww['numcapan'];

                $Carriersname =$roww['invoice_name_carrier']; 
                $Carriersnid = $roww['carriersnid'];
                     $invoic_Data = $roww['invoice_invoice_date'];

                

                $robranch =$roww['invoice_to_branch'];

                
                $data.='<tr>
                 <td>'.$sequ.'</td>
                 <td>'.$countinv.'</td>
                 <td>'.vtranslate($robranch,'Invoice').'</td>
                 <td>'.$invoic_Data.'</td>
                 <td>'.$numcapan.'</td>

                  <td><a target="_blank" href="index.php?module=Reports&view=BranchReportsPrint2&tobranch='.$robranch.'&date='.$invoic_Data.'&capnum='.$numcapan.'"> التفاصيل  </a> </td>

                 </tr>
                   ';

                 $sequ=$sequ+1;                 
                                  
               }

               $data.='
            
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
        <title> تقرير الفرع  </title>
        
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
    <body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" style="text-align:center;" onLoad="">
        <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
            <tr class="reportPrintHeader">
                <td  class="left"  valign="top" style="border:0px solid #000000;">
                     <h4>  الاسطورة للنقل </h4>
                    <font  color="#666666"><div id="report_info">
                    </div></font>
                </td>
                <td  class="right"  style="border:0px solid #000000;padding-left: 18%;" valign="top">
                    <h4 style="color:#CCCCCC">تقرير الفروع</h4>
                </td>
            </tr>
            <tr><td colspan="2">
                <div style="text-align: right">
                    <table dir="rtl" width="100%" border="0" cellpadding="5" cellspacing="0" align="center" style="text-align: right">
                        <thead>
                            <tr>
                                
                                   <th>التاريخ </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            
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