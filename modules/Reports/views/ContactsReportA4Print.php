<?php

//ContactsReportA4Print

class Reports_ContactsReportA4Print_View extends Vtiger_View_Controller {

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

	function getBranchesnum($name){

	}

	function process(Vtiger_request $request) {

		global $adb;
		
	    $conditions="";

	   //organizationdetails
		$phone="";
		$numcommercialregistration="";

		$sql2 = 'SELECT phone  FROM vtiger_organizationdetails LIMIT 1';
		$result2 = $adb->pquery($sql2, array());
		$orgphone = $adb->query_result($result2, 0, 'phone');
		
        $address_from="";
		$address_to="";
		
		$date = $request->get('date');
        $dateto = $request->get('dateto');
        $datalebel="";
        $datasql="";

        if ( $date  != '' &&  $dateto !='0' && $dateto !=0){
             $datasql = "AND (vtiger_invoice.invoicedate BETWEEN '$date' AND '$dateto')";
             $datalebel ="".$date."___".$dateto."";
             
        }else if ($date  !=''){
             $datasql = "  AND vtiger_invoice.invoicedate ='$date' ";
             $datalebel = $date;
        }
		
		
		
	?>

<!DOCTYPE>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    	<link rel="SHORTCUT ICON" href="layouts/v7/skins/images/favicon.ico">
        
        <title>Contacts <?php echo $datalebel; ?></title>
        
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
                    border:0px solid #000000;
                    border-collapse:collapse;
                }
                .printReport tbody td{
                    border:1px solid #858796;
                    text-align:center;
                    font-weight: bold;
                }
                .printReport thead th{
                	border: 1px solid #858796;
                   
                    padding: 6px 9px !important;
                }
                thead {
                    display:table-header-group;
                }
                tbody {
                    display:table-row-group;
                }

                table {
                	direction: rtl;
                }



                .tophead td {
                	width: 33%;
                }
                .tophead p {
                	font-weight: bold;
                	font-size: 18px ;
                }
                .invoceinfohead{
                	text-align: right; 
                	font-size: 16px;
                     padding:0px; 
                	 margin: 1px; 
                	margin-top: 4px;
                	font-weight: bold;
                	height: 19px;
                }
                .invoceinfoheadcenter{
                	text-align: center; 
                	font-size: 18px;
                	padding:0px; margin: 1px 1px;
                	font-weight: bold;
                	margin-top: 2px;
                }

                .invoiceitemfotter{
                	text-align:center; border:0px solid #000000; padding: 0px;font-weight: bold;
                }
                .invoiceitemfotternum{
                	text-align:center;border:0px solid #000000;  padding:0px;font-weight: bold;
                }
                .branches{
                		text-align: center; padding: 0px; margin: 0px;  border:0px solid #000000;
                }
                td {
				    text-align: center;
				}
				.datarow tr{
					border-bottom: 1px dashed #0000003d;
					line-height: 1.5;

				}
				.printReport thead th{
				    padding:0px;
				}
				p.cont-2{
				    margin: 0px;
                    padding: 8px 0px;
                    font-weight: bold;
				}
				p.cont-1 {
                    margin: 0px;
                    padding: 12px 0px;
                    font-weight: bold;
                }
                .invoceinfohead , .tophead p {
                 /* border: 1px solid #858796;
                  border-radius: 8px;
                  padding: 2px 5px;*/
                }
                table p {
                  border: 1px solid #858796;
                  border-radius: 8px;
                  padding: 2px 5px !important;
                }

                .reportPrintData th , .reportPrintData td{
                	 border: 1px solid #858796;
                }
     
           
        </style>
           
    </head>
    <body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" style="text-align:center;" onLoad="JavaScript:window.print()">


    	<?php
    	
    	
    	


    	$Sql ="SELECT vtiger_invoice.discount_amount as 'invoice_discount_amount', vtiger_invoice.pre_tax_total AS 'Invoice_Pre_Tax_Total',vtiger_invoice.deliveryvalue , vtiger_invoice.storagevalue , vtiger_invoicecf.cf_987 AS 'sendername',  vtiger_invoice.invoiceid,vtiger_invoicecf.cf_952 as 'menaulnumber', vtiger_invoicecf.cf_978 AS 'address_recipient' ,vtiger_invoicecf.cf_964 AS 'id_sernder',vtiger_invoicecf.cf_966 AS 'id_recipient', vtiger_invoicecf.cf_950 AS 'Invoice_To_branch', vtiger_invoicecf.cf_948 AS 'Invoice_From_branch', (CASE WHEN vtiger_invoice.contactid NOT LIKE '' THEN (CASE WHEN trim(CONCAT(vtiger_contactdetailsInvoice.firstname,' ',vtiger_contactdetailsInvoice.lastname)) NOT LIKE '' THEN trim(CONCAT(vtiger_contactdetailsInvoice.firstname,' ',vtiger_contactdetailsInvoice.lastname)) ELSE '' END) ELSE '' END) AS 'Invoice_Contact_Name', 
    	
    	    (CASE WHEN vtiger_invoicecf.cf_944 NOT LIKE '' THEN (CASE WHEN trim(CONCAT(vtiger_contactdetailsRelInvoice945.firstname,' ')) NOT LIKE '' THEN trim(CONCAT(vtiger_contactdetailsRelInvoice945.firstname,' ')) ELSE '' END) ELSE '' END) AS 'Invoice_Received_Name', 
             vtiger_invoice.invoicedate AS 'Invoice_Invoice_Date', vtiger_invoice.invoice_no AS 'Invoice_Invoice_No', CASE WHEN (vtiger_productsInvoice.productname NOT LIKE '') THEN vtiger_productsInvoice.productname ELSE vtiger_serviceInvoice.servicename END AS 'Invoice_Item_Name', vtiger_inventoryproductreltmpInvoice.quantity AS 'Invoice_Quantity', CASE WHEN vtiger_currency_infoInvoice.id = vtiger_usersInvoice.currency_id THEN vtiger_inventoryproductreltmpInvoice.listprice/vtiger_currency_infoInvoice.conversion_rate ELSE vtiger_inventoryproductreltmpInvoice.listprice/vtiger_invoice.conversion_rate END AS 'Invoice_List_Price', vtiger_inventoryproductreltmpInvoice.comment AS 'Invoice_Item_Comment', vtiger_invoice.subject AS 'Invoice_Subject',
		        vtiger_invoice.subtotal AS 'Invoice_Sub_Total',
		        vtiger_invoice.received AS 'Invoice_Received', 
		        vtiger_invoice.balance AS 'Invoice_Balance',

		  (CASE WHEN vtiger_invoicecf.cf_954 NOT LIKE '' THEN (CASE WHEN trim(vtiger_vendorRelInvoice955.vendorname) NOT LIKE '' THEN trim(vtiger_vendorRelInvoice955.vendorname) ELSE '' END) ELSE '' END) AS 'Invoice_Name_Carrier', vtiger_invoicecf.cf_958 AS 'Invoice_Expedition_Number', vtiger_invoicecf.cf_956 AS 'Invoice_Date_Transfer', vtiger_inventoryproductreltmpInvoice.tax1 AS 'Invoice_VAT', vtiger_invoice.s_h_percent AS 'Invoice_S&H_Percent', vtiger_inventoryproductreltmpInvoice.tax3 AS 'Invoice_Service', vtiger_crmentity.crmid AS 'Invoice_LBL_ACTION' ,
			GROUP_CONCAT(concat( FORMAT(vtiger_inventoryproductreltmpInvoice.quantity,0),':',vtiger_serviceInvoice.servicename ) SEPARATOR ' +') AS 'descrip item',
			COUNT(vtiger_serviceInvoice.servicename) AS 'countitem' ,
			Sum(vtiger_inventoryproductreltmpInvoice.tax1) as totoletax1,

			SUM(vtiger_inventoryproductreltmpInvoice.quantity) AS 'Sum Qutity',
			case when(vtiger_usersInvoice.last_name NOT LIKE '' and vtiger_crmentity.crmid!='' ) THEN CONCAT(vtiger_usersInvoice.first_name,' ',vtiger_usersInvoice.last_name) else vtiger_groups.groupname end AS 'Invoice_Assigned_To',
			vtiger_invoice.customerno AS 'Invoice_Sender_Phone', vtiger_invoicecf.cf_946 AS 'Invoice_Received_Phone'

       from vtiger_invoice inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_invoice.invoiceid left join vtiger_currency_info as vtiger_currency_infoInvoice on vtiger_currency_infoInvoice.id = vtiger_invoice.currency_id left join vtiger_inventoryproductrel as vtiger_inventoryproductreltmpInvoice on vtiger_invoice.invoiceid = vtiger_inventoryproductreltmpInvoice.id left join vtiger_products as vtiger_productsInvoice on vtiger_productsInvoice.productid = vtiger_inventoryproductreltmpInvoice.productid left join vtiger_service as vtiger_serviceInvoice on vtiger_serviceInvoice.serviceid = vtiger_inventoryproductreltmpInvoice.productid left join vtiger_invoicecf on vtiger_invoice.invoiceid = vtiger_invoicecf.invoiceid left join vtiger_users as vtiger_usersInvoice on vtiger_usersInvoice.id = vtiger_crmentity.smownerid left join vtiger_groups on vtiger_groups.groupid = vtiger_crmentity.smownerid left join vtiger_users on vtiger_users.id = vtiger_crmentity.smownerid left join vtiger_contactdetails as vtiger_contactdetailsInvoice on vtiger_contactdetailsInvoice.contactid = vtiger_invoice.contactid left join vtiger_contactdetails as vtiger_contactdetailsRelInvoice945 on vtiger_contactdetailsRelInvoice945.contactid = vtiger_invoicecf.cf_944 left join vtiger_vendor as vtiger_vendorRelInvoice955 on vtiger_vendorRelInvoice955.vendorid = vtiger_invoicecf.cf_954 WHERE vtiger_invoice.invoiceid > 0 AND vtiger_crmentity.deleted=0 ";

      
		
		if(!empty($datasql)){
                $Sql.= $datasql;

         }
	
        $Sql .="   GROUP BY vtiger_invoice.invoice_no order by vtiger_invoice.invoiceid  ";
        
        
         



        //$Sql .="   LIMIT 5 ";
         
        
          include "libraries/phpqrcode/qrlib.php";
          
          $paramter=array();
          $result=$adb->pquery($Sql,$paramter);
          
          
          
		  if($adb->num_rows($result) > 0)
		    {
		    	

			  while($roww = $adb->fetch_array($result))
			   { 
                

                $invoiceid = $roww['invoiceid'];
			   	$Carriersid =$roww['invoice_name_carrier']; 
			   	$invoic_no = $roww['invoice_invoice_no'];

			   	$invoice_sender_phone =$roww['invoice_sender_phone'];
			   	$invoice_received_phone =$roww['invoice_received_phone'];

			   	$recver = $roww['invoice_received_name'];
			   	$sender =$roww['sendername']; //$roww['invoice_contact_name'];

			   	$typedecrip = $roww['descrip item'];
			   	
			   	$storagevalue = $roww['storagevalue'];
			   	$deliveryvalue = $roww['deliveryvalue'];

			   	$invoice_invoice_date = $roww['invoice_invoice_date'];

			   	$quanty = $roww['sum qutity'];

			   	$sumquantity = $sumquantity+$quanty;

			   	$coust  = $roww['invoice_sub_total']; 

			   	//$sumcoust =$sumcoust+$coust;
			   	$Invoice_Received = $roww['invoice_received'];
			   	//$Invoice_Receivedtotal = $Invoice_Receivedtotal +$Invoice_Received;
			   	
			   	$Invoice_Balance = $roww['invoice_balance'];

			   	$invoice_discount_amount = $roww['invoice_discount_amount'];


			   	// $tax   = 0.05 * $roww['invoice_sub_total'];
			   	$taxpro = ($roww['totoletax1'] / $roww['countitem']) / 100;
			   	$tax   = $taxpro * ($roww['invoice_sub_total']- $invoice_discount_amount);
			   	
			   	$pre_tax_total = $roww['invoice_pre_tax_total'];


			   	//$sumtax =$sumtax+$tax; 

			   	$othercoust=$roww['invoice_s&h_percent']; 
			   	//$sumothercoust =$sumothercoust+$othercoust;

			    $grandtotal=$Invoice_Received + $Invoice_Balance;
			    //$sumgrandtotal =$sumgrandtotal+$grandtotal;

			    $invoice_to_branch = $roww['invoice_to_branch'];

			    $invoice_assigned_to = $roww['invoice_assigned_to'];
			    
			     $id_sernder=$roww['id_sernder'];
                 $id_recipient=$roww['id_recipient'];
                 $address_recipient=$roww['address_recipient'];
                 $Invoice_Subject=$roww['invoice_subject'];
                 $menaulnumber=$roww['menaulnumber'];

			   	

			   	$frombranch = "";
			 
			   	  
			     $invoice_to_branch = $roww['invoice_to_branch'];
	   	         $from_broch=$roww['invoice_from_branch'];
	   	    
	   	    	if($from_broch == "Jeddah" &&  $invoice_to_branch =="Riyadh"){
		          $orgphone="0530888141";
				}elseif($from_broch == "Khamis Mushait" &&  $invoice_to_branch =="Riyadh"){
				    $orgphone="0501111956";
				}elseif($from_broch == "Abha" &&  $invoice_to_branch =="Riyadh"){
				    $orgphone="0501111956";
				}elseif($from_broch == "Mahail Asir" &&  $invoice_to_branch =="Riyadh"){
				    $orgphone="0530888141";
				}elseif($from_broch == "jawal alttayir Jeddah" &&  $invoice_to_branch =="jawal alttayir KM"){
				    $orgphone="0557436061";
				}elseif($from_broch == "jawal alttayir KM" &&  $invoice_to_branch =="jawal alttayir Jeddah"){
				    $orgphone="0505730085";
				}elseif($from_broch == "jawal alttayir KM" &&  $invoice_to_branch =="Riyadh"){
				    $orgphone="0569284002";
				}elseif($from_broch == "Riyadh" &&  $invoice_to_branch =="jawal alttayir KM"){
				    $orgphone="0557436061";
				}elseif($invoice_to_branch == "Abha"){
				    $orgphone="0502516815";
				}elseif($invoice_to_branch =="Jeddah"){
				    $orgphone="0554705683";
				}elseif($invoice_to_branch =="Khamis Mushait"){
				    $orgphone="0503435094";
				}elseif($invoice_to_branch =="Mahail Asir"){
				    $orgphone="0507499544";
				}elseif($invoice_to_branch =="Riyadh"){
				    $orgphone="0502447060";
				}else{
				    $orgphone="0554705683";
				}
			   	
			   
			   
			   
			   //$address_from=""; $address_to="";
				if($from_broch == "Jeddah"){
				    $address_from="حي المحجر";
				}elseif($from_broch == "Riyadh"){
				     $address_from="حي المنصورة-شارع محمد بن شعيل";
				}elseif($from_broch == "Khamis Mushait"){
				     $address_from="حي المثناة-طريق المدينة العسكرية";
				}elseif($from_broch == "Abha"){
				     $address_from="حي الشرف-طرق الملك عبدالله";
				}elseif($from_broch == "Mahail Asir"){
				     $address_from="حي الروضة-طرق خميس البحر";
				}elseif($from_broch == "jawal alttayir KM"){
				     $address_from="حي العرق الجنوبي-طريق الملك سعود";
				}elseif($from_broch == "jawal alttayir Jeddah"){
				     $address_from="حي المحجر";
				}
				
			    if($from_broch == "Riyadh" && ($invoice_to_branch == "jawal alttayir KM" || $invoice_to_branch == "jawal alttayir Jeddah" )){
			        $address_from="حي المنصورة-مخرج20";
			    }
				
				if($invoice_to_branch == "Jeddah"){
				    $address_to="حي المحجر";
				}elseif($invoice_to_branch == "Riyadh"){
				     $address_to="حي المنصورة-شارع محمد بن شعيل";
				}elseif($invoice_to_branch == "Khamis Mushait"){
				     $address_to="حي المثناة-طريق المدينة العسكرية";
				}elseif($invoice_to_branch == "Abha"){
				     $address_to="حي الشرف-طرق الملك عبدالله";
				}elseif($invoice_to_branch == "Mahail Asir"){
				     $address_to="حي الروضة-طرق خميس البحر";
				}elseif($invoice_to_branch == "jawal alttayir KM"){
				     $address_to="حي العرق الجنوبي-طريق الملك سعود";
				}elseif($invoice_to_branch == "jawal alttayir Jeddah"){
				     $address_to="حي المحجر";
				}
				
				if($invoice_to_branch == "Riyadh" && ($from_broch == "jawal alttayir KM" || $from_broch == "jawal alttayir Jeddah" )){
			        $address_to="حي المنصورة-مخرج20";
			    }

					$frombranoinv=$frombranch.'/'.$invoic_no;
					$sequence_main=1;
                     
                    
                    
					
					$filename ='storage/qrcode/'.$invoiceid.'.png';
					$namefoundation="اسم المؤسسة:الأسطورة مباشر للنقل البري";
                    $taxnumber="الرقم الضريبي:300523053400003";
                    $dateqr="التاريخ:".$invoice_invoice_date;
                    $invtotal="قيمة الفاتورة:".$grandtotal;
                    $invnumber="رقم الفاتورة:".$invoic_no;
                    $taxtotal="قيمة الضريبة:".$tax;
                    
                    $rqlebelar=$namefoundation.','.$taxnumber.','.$dateqr.','.$invtotal.','.$invnumber.','.$taxtotal;

					//$rqlebel="Al-ostorah,300523053400003,INV_NO:".$invoic_no.",Date,".$invoice_invoice_date.",Total Invoice=".$grandtotal.",Tax=".$tax;

                    QRcode::png($rqlebelar, $filename,'L', 4, 2); 
                
                    
                   

			   
         ?>        

                     <?php

                     $Sql9="SELECT vtiger_crmentity.label, vtiger_inventoryproductrel.productid ,vtiger_inventoryproductrel.quantity,vtiger_inventoryproductrel.listprice,vtiger_inventoryproductrel.comment , vtiger_inventoryproductrel.margin FROM vtiger_inventoryproductrel
                        INNER JOIN vtiger_crmentity ON  vtiger_crmentity.crmid=vtiger_inventoryproductrel.productid 
                      WHERE vtiger_inventoryproductrel.id=?  ORDER BY sequence_no";

                     $paramter9=array($invoiceid);

			          $result9=$adb->pquery($Sql9,$paramter9);
			          $ns=1;
			          $numcoun=$adb->num_rows($result9);
                        
                      
          
					  if($adb->num_rows($result9) > 0)
					    {
					    	
						  while($roww9 = $adb->fetch_array($result9))
						   { 
                                
						   	$decr=$roww9['label'];

						   	if($roww9['comment'] != '' || $roww9['comment'] !=null){
						   		$decr.=" -: ".$roww9['comment'];
						   	}


						   	if($sequence_main == 1){ ?>


						   		<div style="border:1px solid #fff; width: 950px; height: 1391px; padding-top:16px; padding:5px;">

							        <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" style="padding-top:11px">
							           
							           <tr class="tophead">

							           	<td  style="padding: 2px 0px 1px 0px;">
							           		<div style="height: 90px;width: 100%;border:0px solid #000;">
                                                <!-- test/logo/o-logo-ostorah.jpg -->
							                	<div style="text-align: right;"> 
							                		<img height="90" src="test/logo/o-logo-ostorah.jpg" alt="alastura.PNG">
							                		<img height="90" style="padding: 0px 20px;" src="<?php echo $filename; ?>" alt="Q">
							                	</div>
							           		</div>
							           	</td>

							           	<td  colspan="2" style="padding: 2px 0px 1px 0px;">
							           		<div style="height: 90px;width: 100%;border:0px solid #000;">
							                	<div style="">
							                		<h2>بوليصة شحــــن</h2>
							                		<p align="center"  style="margin: 1px 1px;"  class="" > <b>الرقم الضرببي:</b> 300523053400003</p>
							                	</div>
							           		</div>
							           	</td>

							           	<td  style="padding: 2px 0px 1px 0px;">
							           		<div style="height: 90px;width: 100%;border:0px solid #000;">

							           			
                                                <div style="width: 10%; float: right;">
                                                	&ensp;
                                                </div>
							           			<div style=" width: 55%; float: left;">
							                		<p align="center"  style="margin: 1px 1px; " class="" >&ensp;<?php echo $invoic_no;?>&ensp;</p>
							                		<p align="center"  style="margin: 1px 1px; "  class="" >&ensp;<?php echo $menaulnumber;?>&ensp;</p>
							                		<p align="center"  style="margin: 1px 1px;"  class="" >&ensp;<?php echo $invoice_invoice_date;?>&ensp;</p>
							               
							                	</div>

							                	<div style="width: 35%; float: right;">
							                		<p align="center"   style="margin: 1px 1px; " class="" > رقم الفاتورة</p>
							                		<p align="center"   style="margin: 1px 1px; "  class="" >رقم عقد الشحن</p>
							                		<p align="center"   style="margin: 1px 1px;"  class="" >تاريخ الشحن</p>
							                	</div>


							           		</div>
							           	</td>

							           </tr>

                                         
                                        <tr> 

							            	<td   colspan="2"  style="padding: 2px 0px 1px 0px;">
							            		<div style=" width: 30%; float: right; height: 100px; text-align: center;">
							            		
							                		<p align="center" class="invoceinfoheadcenter" style="">المــــرســـــل</p>
							                		<p align="center" class="invoceinfoheadcenter"  style="">هوية المرسـل</p>
							                		<p align="center" class="invoceinfoheadcenter" style="">هاتف المرسل</p>
							                	    <p align="center" class="invoceinfoheadcenter" style="">مـن فــــــــرع</p>
							                	    <p align="center" class="invoceinfoheadcenter" style="">نـوع الطــــرد</p>
							                	
							                	</div>
							                	
							                	<div style="width: 70%; float: left; ">
							                		
							                		

							                		<p align="center"   class="invoceinfohead" > <?php echo $sender;?> </p>
							                		<p align="center" class="invoceinfohead"  ><?php echo $id_sernder;?></p>
							                		<p align="center" class="invoceinfohead" ><?php echo $invoice_sender_phone;?></p>
							                	    <p align="center" class="invoceinfohead" ><?php echo vtranslate($from_broch).'-'.$address_from; ?> </p>
							                	    <p align="center" class="invoceinfohead" ><?php echo $Invoice_Subject;?> </p>
							                	
							                	</div>

							            	</td>

							            	<td colspan="2"  style="padding: 2px 0px 1px 0px;">

							            		<div style=" width: 30%; float: right; height: 100px;">
							                		<p align="center" class="invoceinfoheadcenter" style="">المـستـــــــــلم</p>
							                		<p align="center" class="invoceinfoheadcenter"  style="">هوية المستــلم</p>
							                		<p align="center" class="invoceinfoheadcenter" style="">هاتف المستـلم</p>
							                	    <p align="center" class="invoceinfoheadcenter" style="">إلى فـــــــــرع</p>
							                	    <p align="center" class="invoceinfoheadcenter" style="">العنـــــــــــوان</p>
							                	
							                	</div>
							                	
							                	<div style="width: 70%; float: left; ">
							                		
							                		<p align="center" class="invoceinfohead" style=""><?php echo $recver;?> </p>
							                		<p align="center" class="invoceinfohead" style=""><?php echo $id_recipient;?> </p>
							                		<p align="center" class="invoceinfohead" style=""><?php echo $invoice_received_phone;?> </p>
							                		
							                		<p align="center" class="invoceinfohead" style=""><?php echo vtranslate($invoice_to_branch).'-'.$address_to; ?> </p>
							                		<p align="center" class="invoceinfohead" style=""><?php echo $address_recipient ;?> </p>
							                	
							                	</div>

							            	</td>
							            

							            </tr>

							            

							            
							            <tr>

							              <td style="border:0px solid #858796; border-bottom: 0px; padding: 0px;padding-top: 5px;" colspan="4">
							               <div style="border:1px solid #858796;  ">
							                   <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData">
							                    <thead>
									                <tr>
									                <th width="15%">التسلــسل</th>
									                <th>الوصــــف</th>
									                <th width="10%">العـــدد</th>
									                <th width="15%" >التكـلفة</th>
									                <th width="123px" >الإجمـــــــــالي</th>

									                </tr>
							                      </thead>

							                     <tbody class="datarow">






						   <?php  }


						   echo '<tr>
                			<td>'.$ns.'</td>
                			<td>'.$decr.'</td>
                			<td >'.intval($roww9['quantity']).'</</td>
                			<td >'.intval($roww9['listprice']).'</</td>
                			<td >'.intval($roww9['margin']).'</</td>
                		</tr>';

                		  if($sequence_main == 20 ||  $numcoun == $ns ){ ?>
                		  	    </tbody>
                	
				                   </table>

				                   </div>
				                    
				                    
				                </td>
				            </tr>
				            

				            <tr>
				                <td colspan="4" style="border:0px solid #000000; border-top: 0px; padding: 0px;">
				                    
				                    <div style=" border:0px solid #000000; ">
				                	<table width="100%" >
				                  	<tbody>
				                  		<tr>
				                  			<td  width="35%" style="border: 1px solid #858796">
				                  				
				                  				
				                 

				                  				<h2>غايتنا/السرعة.المصاقية.السعر المناسب</h2>
				                  				<h3>في حالة رغبة العميل التامين على الإرسالية
 يجب مراجعة المكتب وعمل عقد خاص بذلك</h3>

				                  			

				                  		    </td>
				                  				
                                             
				                  			<td width="15%" style="border: 1px solid #858796">
				                  			   <h3>توقيع المستلم</h3>
				                  			   <br>
				                  			   <br>
				                  			   <br>
				                  			</td>

				                  			

				                  			<td style="" width="14%">
				                  				<p class="cont-1">الاجمالي  بعد الضريبة</p> 
				                  				<p class="cont-1">الــمـدفـــــــــوع</p>
				                  				<p class="cont-1">البـــــــاقـــــي</p>
				                  			</td>

				                  			<td style="" width="8%">
				                  				<p class="cont-1"><?php echo number_format($Invoice_Received+$Invoice_Balance,2) ;?></p>
				                  				<p class="cont-1"><?php echo  number_format($Invoice_Received,2); ?></p>
				                  				<p class="cont-1"><?php echo number_format($Invoice_Balance,2) ;?></p> 
				                  			</td>

				                  			<td   style="" width="18%">
				                  				<p class="cont-2">الإجمالي الفرعي</p>
				                  				<p class="cont-2">الخصم</p>
				                  				<p class="cont-2">الاجمالي قبل الضريبة</p>
				                  				<p class="cont-2">ضريبة القيمة المضافة</p>

				                  			</td>

				                  			<td style="" width="16%">
				                  				<p class="cont-2"><?php echo number_format($coust,2);  ?></p>
				                  				<p class="cont-2"><?php echo number_format($invoice_discount_amount,2); ?></p>
				                  				<p class="cont-2"><?php echo number_format($coust-$invoice_discount_amount,2); ?></p>
				                  				<p class="cont-2"><?php echo number_format($tax,2);?></p>
				                  				

				                  			</td>
				                  		</tr>	
				                  	</tbody>
				                  </table>				              
				                 </div>

				              </td>
				            </tr>

				            <tr>
				            	 <td colspan="4" style="border:0px solid #000000; border-top: 0px; padding: 0px;">
				            	<div style="border:1px solid #858796;  ">
							                   <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData">
							                    <thead>
									                <tr>
									                <th width="20%">الريــــــــــاض</th>
									                <th width="20%" >جـــــــــــــــدة</th>
									                <th width="20%">خميـس مشيط</th>
									                <th width="20%">أبــــــــهــــــا</th>
									                <th width="20%" >محايل عسير</th>

									                </tr>
							                      </thead>

							                     <tbody class="datarow">
							                     	
							                     	<tr>
							                     		<td>
							                     			4468337<br>
							                     			4467211
							                     		</td>
							                     		<td>
							                     			6356655<br>
							                     			6388020
							                     			
							                     		</td>
							                     		<td>
							                     			2210101<br>
							                     			2220101
							                     		</td>
							                     		<td>
							                     			2280101<br>
							                     			2290202
							                     		</td>
							                     		<td>
							                     			0138386286<br>
							                     			0569513057
							                     		</td>
							                     	</tr>

							                     	</tbody>
								                  </table>
								        </div>
								    </td>

				            </tr>

				            
				            <tr>
				            	   <td colspan="2" style="border:0px solid #000000; border-top: 0px; padding-top: 10px;">

				            		    <strong>تأمين سيارات خاصة وكمبليت/جدة:</strong>
				            			<div style="width: 23%; float: left;"> 
				            				
				            				<p style="text-align: right;margin: 0px; font-weight: bold;"><?php echo $orgphone ; ?> </p>
				            			</div>
				            		</td>

				            		<td colspan="2" style="border:0px solid #000000; border-top: 0px; padding-top: 10px;">
				            			<strong>للملاحظة والاستفسار</strong>
				            			<div style="width: 23%; float: left;"> 
				            				<p style="text-align: right;margin: 0px; font-weight: bold;"><?php echo $orgphone ; ?> </p>
				            			</div>
				            		</td>



				            </tr>

				          </tbody>
				            
				        </table>
				    </div>









                		  <?php }
                		  $ns=$ns+1;

                		  $sequence_main = $sequence_main +1;

                		  if($sequence_main == 20){
                		  	$sequence_main =1;

                		  }

						 }//end wile

			}else{

					echo '
					    <p>لايوجد بيانات</p>
                		';

			}


     ?> 

   <?php

		}
	}else{

					echo '
					    <p>لايوجد بيانات</p>
                		';

    }
 ?>
 </body>
    
</html>



		<?php

		//echo "hhhhhhhhhhhhhhzzzzzzzzooo";

		//  $fileName="invoice.pdf";
		
		// header("Content-Type: application/pdf"); 
  //       header("Content-Disposition: attachment; filename=\"$fileName\""); 
	}




}


?>