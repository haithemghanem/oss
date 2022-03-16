
<?php
//CarriersReportPrint2

class Reports_MandoubReportPrint_View extends Vtiger_View_Controller {

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
        $id = $request->get('mandubid');
        $mandubname=$id;


        $sql_sel ="SELECT vtiger_mandub.mandubid, vtiger_mandub.name FROM vtiger_mandub 
                                    INNER JOIN vtiger_crmentity on  vtiger_crmentity.crmid = vtiger_mandub.mandubid
                                    WHERE vtiger_crmentity.deleted =0 AND  vtiger_mandub.mandubid=$id LIMIT 1";
        $result=$adb->pquery($sql_sel,array());
        $mandubname =$adb->query_result($result, 0, 'name');


        $branch = $request->get('frombranch');


        $date = $request->get('date');
        $dateto = $request->get('dateto');
        $datalebel="";
        $datasql="";
        if ( $date  != '' &&  $dateto !='0'){
             $datasql = "  AND (vtiger_invoice.invoicedate BETWEEN '$date' AND '$dateto')  ";
             $datalebel ="<span>".$date."</span> <span> ___ </span> <span>".$dateto."</span>";
        
        }else if ($date  !='' && $dateto =='0'){
             $datasql = " AND  vtiger_invoice.invoicedate ='$date'  ";
             $datalebel = $date;
        }



        $data='<table dir="rtl" width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData">
                       <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData">';
                $data .='<thead>
                <tr>
                <th>مسلسل</th>
                <th>رقم الفاتورة</th>
                <th>اسم العميل</th>
                <th>الصافي</th>
                <th>مسلم مدفوع</th>
                <th>مسلم غير مدفوع</th>
                <th>خالص الاجرة</th>
                <th>غير مستلم</th>
                </tr>
                </thead> <tbody>'; 

    
        $Sql="SELECT  vtiger_invoice.invoiceid,vtiger_invoice.invoicedate,vtiger_invoice.invoice_no,vtiger_invoicecf.cf_1012 as mandupb_status, vtiger_invoice.balance, vtiger_invoicecf.cf_950 AS 'Invoice_To_branch', vtiger_invoicecf.cf_948 AS 'Invoice_From_branch', 
        vtiger_invoice.invoicedate AS 'invoice_invoice_date', vtiger_contactdetailsInvoice.firstname, vtiger_contactdetailsInvoice.lastname
    
       from vtiger_invoice 
       inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_invoice.invoiceid 
       inner join vtiger_invoicecf on vtiger_invoice.invoiceid = vtiger_invoicecf.invoiceid 
       left join vtiger_contactdetails as vtiger_contactdetailsInvoice on vtiger_contactdetailsInvoice.contactid = vtiger_invoicecf.cf_944
       WHERE  vtiger_crmentity.deleted=0 AND vtiger_invoicecf.cf_1010 =$id AND vtiger_invoice.invoicedate !='' and vtiger_invoicecf.cf_950 !='' And  vtiger_invoicecf.cf_948 !='' AND vtiger_invoicecf.cf_954 !='' ";
        
            if(!empty($branch)){
              $Sql.=" AND  vtiger_invoicecf.cf_950 IN ('$branch') ";
           }

           if(!empty($datasql)){
                $Sql.=$datasql;

           }
           $Sql.="order by vtiger_invoice.invoice_no DESC  LIMIT 0, 50000 ";

         $Invoice_Balance_total=0;

         $delivered_paid_total=0;
         $delivered_not_paid_total=0;
         $not_delivered_total =0;
         $balance_total=0;

         $paramter=array();
         $sequ=1;
         $result=$adb->pquery($Sql,$paramter);
          if($adb->num_rows($result) > 0)
            {
                
              while($roww = $adb->fetch_array($result))
               { 

                $invoiceid = $roww['invoiceid'];
                $invoic_no = $roww['invoice_no'];
                $Invoice_Contact_Name = $roww['firstname'];
                
                $datainv = $roww['invoicedate'];
                $Invoice_Balance = $roww['balance'];
                $Invoice_Balance_total = $Invoice_Balance_total + $Invoice_Balance;

                $mandupb_status = $roww['mandupb_status'];

                $delivered_paid="";
                $delivered_not_paid="";
                $not_delivered = "";
                $balance="";

                if($mandupb_status == "delivered and paid"){
                    $delivered_paid =  number_format($Invoice_Balance,2);   $delivered_paid_total= $delivered_paid_total + $Invoice_Balance;
                }elseif ($mandupb_status =="delivered and not paid") {
                    $delivered_not_paid = number_format($Invoice_Balance,2); $delivered_not_paid_total= $delivered_not_paid_total + $Invoice_Balance;
                }elseif ($mandupb_status =="not delivered") {
                    $not_delivered = number_format($Invoice_Balance,2);   $not_delivered_total =  $not_delivered_total + $Invoice_Balance;
                }elseif ($mandupb_status =="balance") {
                   $balance = number_format($Invoice_Balance,2); $balance_total = $balance_total + $Invoice_Balance;
                }else{

                }

                
                $data.='<tr>  
                 <td><a target="_blank" href="index.php?module=Invoice&view=Detail&record='.$invoiceid.'&app=INVENTORY"> '.$sequ.' </a></td>
                 <td>'.$invoic_no.'</td>
                 <td>'.$Invoice_Contact_Name.'</td>
                 <td>'.number_format($Invoice_Balance,2).'</td>

                 <td>'.$delivered_paid.'</td>
                 <td>'.$delivered_not_paid.'</td>
                 <td>'.$not_delivered.'</td>
                 <td>'.$balance.'</td>
                 </tr>

                   ';

                 $sequ=$sequ+1;                 
                                  
               }

               $data.='<tr>
                 <td colspan="3">الاجمالي الكلي</td>
                 <td>'.number_format($Invoice_Balance_total,2).' </td>

                 <td>'.number_format($delivered_paid_total,2).'</td>
                 <td>'.number_format($delivered_not_paid_total,2).'</td>
                 <td>'.number_format($not_delivered_total,2).'</td>
                 <td>'.number_format($balance_total,2).'</td>
                 
                 </tr>
                 
                 

                 
                   ';



            }else{

                $data ="<br> <br> <p style='text-align:center'> لايوجد سجلات , تاكد من الشروط التي وضعتها </p>";
            }

           $data.=' </tbody></table>';



        ?>



<script type="text/javascript" src="libraries/jquery/jquery.min.js"></script>

<!DOCTYPE>
<html>
    <head>
        <link rel="SHORTCUT ICON" href="favicon.ico">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>تقرير المندوب  - <?php  echo $mandubname; ?></title>
        
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
                
                <td  class=""  style="border:0px solid #000000;padding-right: 18%;" valign="top">
                    <h4 style="color:#CCCCCC"> الرقم الضريبي :300523053400003  </h4>
                </td>
                
                <td  class="right"  style="border:0px solid #000000;padding-left: 18%;" valign="top">
                    <h4 style="color:#CCCCCC">تقرير المندوب</h4>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                <div style="text-align: right">
                    <table dir="rtl" width="100%" border="0" cellpadding="5" cellspacing="0" align="center" style="text-align: right">
                        <thead>
                            <tr>
                                <th>المندوب</th>
                                <th>الفرع</th>
                                <th>التاريخ</th>
                                   
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php  echo $mandubname; ?></td>
                            <td><?php  echo vtranslate($branch,'Invoice') ?></td>
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