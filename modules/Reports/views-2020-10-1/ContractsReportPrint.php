<?php

//ContractsReportPrint

class Reports_ContractsReportPrint_View extends Vtiger_View_Controller {

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
		$logoname="";
		$numcommercialregistration="";
		$orgphone;

		$sql2 = 'SELECT phone  FROM vtiger_organizationdetails LIMIT 1';
		$result2 = $adb->pquery($sql2, array());
		$orgphone = $adb->query_result($result2, 0, 'phone');

		




		
	?>




<!DOCTYPE>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    	<link rel="SHORTCUT ICON" href="layouts/v7/skins/images/favicon.ico">
        
        <title> تقرير العقود <?php echo $request->get('date');?> </title>
        
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
                    border:0px dotted #000000;
                    text-align:center;
                    font-weight: bold;
                }
                .printReport thead th{
                    border-bottom:0px solid #000000;
                    border-left:0px solid #000000;
                    border-top:0px solid #000000;
                    border-right:0px solid #000000;
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
                }
                .invoceinfohead{
                	text-align: right; font-size: 16px; padding:0px;  margin: 1px; margin-top: 4px;
                	font-weight: bold;
                	height: 19px;
                }
                .invoceinfoheadcenter{
                	text-align: center; font-size: 16px;
                	padding:0px; margin: 1px 1px;
                	font-weight: bold;
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

           
        </style>

           
        
    </head>
    <body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" style="text-align:center;" onLoad="JavaScript:window.print()">


    	<?php





    	$Sql ="SELECT vtiger_invoice.pre_tax_total AS 'Invoice_Pre_Tax_Total', vtiger_invoice.deliveryvalue , vtiger_invoice.storagevalue , vtiger_invoicecf.cf_987 AS 'sendername',vtiger_invoice.invoiceid,vtiger_invoicecf.cf_952 as 'menaulnumber', vtiger_invoicecf.cf_978 AS 'address_recipient' , vtiger_invoice.invoiceid,vtiger_invoicecf.cf_964 AS 'id_sernder',vtiger_invoicecf.cf_966 AS 'id_recipient', vtiger_invoicecf.cf_950 AS 'Invoice_To_branch', vtiger_invoicecf.cf_948 AS 'Invoice_From_branch', (CASE WHEN vtiger_invoice.contactid NOT LIKE '' THEN (CASE WHEN trim(CONCAT(vtiger_contactdetailsInvoice.firstname,' ',vtiger_contactdetailsInvoice.lastname)) NOT LIKE '' THEN trim(CONCAT(vtiger_contactdetailsInvoice.firstname,' ',vtiger_contactdetailsInvoice.lastname)) ELSE '' END) ELSE '' END) AS 'Invoice_Contact_Name', (CASE WHEN vtiger_invoicecf.cf_944 NOT LIKE '' THEN (CASE WHEN trim(CONCAT(vtiger_contactdetailsRelInvoice945.firstname,' ')) NOT LIKE '' THEN trim(CONCAT(vtiger_contactdetailsRelInvoice945.firstname,' ')) ELSE '' END) ELSE '' END) AS 'Invoice_Received_Name', vtiger_invoice.invoicedate AS 'Invoice_Invoice_Date', vtiger_invoice.invoice_no AS 'Invoice_Invoice_No', CASE WHEN (vtiger_productsInvoice.productname NOT LIKE '') THEN vtiger_productsInvoice.productname ELSE vtiger_serviceInvoice.servicename END AS 'Invoice_Item_Name', vtiger_inventoryproductreltmpInvoice.quantity AS 'Invoice_Quantity', CASE WHEN vtiger_currency_infoInvoice.id = vtiger_usersInvoice.currency_id THEN vtiger_inventoryproductreltmpInvoice.listprice/vtiger_currency_infoInvoice.conversion_rate ELSE vtiger_inventoryproductreltmpInvoice.listprice/vtiger_invoice.conversion_rate END AS 'Invoice_List_Price', vtiger_inventoryproductreltmpInvoice.comment AS 'Invoice_Item_Comment', vtiger_invoice.subject AS 'Invoice_Subject',
		        vtiger_invoice.subtotal AS 'Invoice_Sub_Total',
		        vtiger_invoice.received AS 'Invoice_Received', 
		        vtiger_invoice.balance AS 'Invoice_Balance',

		  (CASE WHEN vtiger_invoicecf.cf_954 NOT LIKE '' THEN (CASE WHEN trim(vtiger_vendorRelInvoice955.vendorname) NOT LIKE '' THEN trim(vtiger_vendorRelInvoice955.vendorname) ELSE '' END) ELSE '' END) AS 'Invoice_Name_Carrier', vtiger_invoicecf.cf_958 AS 'Invoice_Expedition_Number', vtiger_invoicecf.cf_956 AS 'Invoice_Date_Transfer', vtiger_inventoryproductreltmpInvoice.tax1 AS 'Invoice_VAT', vtiger_invoice.s_h_percent AS 'Invoice_S&H_Percent', vtiger_inventoryproductreltmpInvoice.tax3 AS 'Invoice_Service', vtiger_crmentity.crmid AS 'Invoice_LBL_ACTION' ,
			GROUP_CONCAT(concat( FORMAT(vtiger_inventoryproductreltmpInvoice.quantity,0),':',vtiger_serviceInvoice.servicename ) SEPARATOR ' +') AS 'descrip item',
			COUNT(vtiger_serviceInvoice.servicename) AS 'Count Item' ,

			SUM(vtiger_inventoryproductreltmpInvoice.quantity) AS 'Sum Qutity',
			case when(vtiger_usersInvoice.last_name NOT LIKE '' and vtiger_crmentity.crmid!='' ) THEN CONCAT(vtiger_usersInvoice.first_name,' ',vtiger_usersInvoice.last_name) else vtiger_groups.groupname end AS 'Invoice_Assigned_To',
			vtiger_invoice.customerno AS 'Invoice_Sender_Phone', vtiger_invoicecf.cf_946 AS 'Invoice_Received_Phone'

       from vtiger_invoice inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_invoice.invoiceid left join vtiger_currency_info as vtiger_currency_infoInvoice on vtiger_currency_infoInvoice.id = vtiger_invoice.currency_id left join vtiger_inventoryproductrel as vtiger_inventoryproductreltmpInvoice on vtiger_invoice.invoiceid = vtiger_inventoryproductreltmpInvoice.id left join vtiger_products as vtiger_productsInvoice on vtiger_productsInvoice.productid = vtiger_inventoryproductreltmpInvoice.productid left join vtiger_service as vtiger_serviceInvoice on vtiger_serviceInvoice.serviceid = vtiger_inventoryproductreltmpInvoice.productid left join vtiger_invoicecf on vtiger_invoice.invoiceid = vtiger_invoicecf.invoiceid left join vtiger_users as vtiger_usersInvoice on vtiger_usersInvoice.id = vtiger_crmentity.smownerid left join vtiger_groups on vtiger_groups.groupid = vtiger_crmentity.smownerid left join vtiger_users on vtiger_users.id = vtiger_crmentity.smownerid left join vtiger_contactdetails as vtiger_contactdetailsInvoice on vtiger_contactdetailsInvoice.contactid = vtiger_invoice.contactid left join vtiger_contactdetails as vtiger_contactdetailsRelInvoice945 on vtiger_contactdetailsRelInvoice945.contactid = vtiger_invoicecf.cf_944 left join vtiger_vendor as vtiger_vendorRelInvoice955 on vtiger_vendorRelInvoice955.vendorid = vtiger_invoicecf.cf_954 WHERE vtiger_invoice.invoiceid > 0 AND vtiger_crmentity.deleted=0 ";

       
        $Carriersnum="";
        $tobranch="";
        $capnum="";
        $date="";
        
       

        $Carriersnum = $request->get('Carriersid');

		$tobranch = $request->get('tobranch');
		
		$capnum = $request->get('capnum');

		$date = $request->get('date');
		$dateto = $request->get('dateto');
        $datecondion =$request->get('datecondion');
        
	
		
		if(!empty($Carriersnum) && $Carriersnum !="0"  && $Carriersnum !=""){

			$Sql .=" AND  vtiger_vendorRelInvoice955.vendorid =$Carriersnum  "; 

		}
		

		if(!empty($tobranch) &&  $tobranch !="0"   &&  $tobranch !="" ){
			$Sql .=" AND vtiger_invoicecf.cf_950 ='$tobranch'  "; 
		}
		
		if ( $datecondion  != '' &&  $datecondion ==2){
			 $Sql .="   AND (vtiger_invoice.invoicedate BETWEEN '$date' AND '$dateto')  ";
        
		}else if ($datecondion  != '' && $datecondion == 1){
			 $Sql .="  AND  vtiger_invoice.invoicedate ='$date'  ";
		}


		if(!empty($capnum) && $capnum !="0"  && $capnum !=""){
			$Sql .="  AND  vtiger_invoicecf.cf_958='$capnum'    "; 

		}

	

        $Sql .="   GROUP BY vtiger_invoice.invoice_no order by vtiger_invoice.invoiceid   LIMIT 0, 5000";
        
        
        

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
			   	$sender = $roww['sendername'];
			   	
			   	$storagevalue = $roww['storagevalue'];
			   	$deliveryvalue = $roww['deliveryvalue'];

			   	$typedecrip = $roww['descrip item'];

			   	$invoice_invoice_date = $roww['invoice_invoice_date'];

			   	$quanty = $roww['sum qutity'];

			   	$sumquantity = $sumquantity+$quanty;

			   	$coust  = $roww['invoice_sub_total']; 

			   	//$sumcoust =$sumcoust+$coust;
			   	$Invoice_Received = $roww['invoice_received'];
			   	//$Invoice_Receivedtotal = $Invoice_Receivedtotal +$Invoice_Received;
			   	
			   	$Invoice_Balance = $roww['invoice_balance'];


			   	$tax   = 0.05 * $roww['invoice_sub_total'];
			   	 //$tax   = ($Invoice_Received + $Invoice_Balance) - $roww['invoice_pre_tax_total'] ;
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

			   	

			   	$frombranch ="";
			   	
				   
			   	    switch ($roww['invoice_to_branch']) {
						case 'Jeddah':
							$orgphone="0554705683";
							break;
						case 'Abha':
							$orgphone="0502516815";
							break;
						case 'Khamis Mushait':
							$orgphone="0503435094";
							break;
						case 'Mahail Asir':
							$orgphone="0507499544";
							break;
						case 'Riyadh':
							$orgphone="0502447060";
							break;
						
						default:
							$orgphone="";
							break;
					}
			   	    
			   	
					
					$from_broch=$roww['invoice_from_branch'];

					$frombranoinv=$frombranch.'/'.$invoic_no;
					$sequence_main=1;

			   	






			   	$Sql2="SELECT `id`, `productid`, `sequence_no`, `quantity`, `listprice`, `discount_percent`, `discount_amount`, `comment`, `description`, `incrementondel`, `lineitem_id`, `tax1`, `tax2`, `tax3`, `image`, `purchase_cost`, `margin`, `tax4`, `tax5` FROM `vtiger_inventoryproductrel` WHERE 1";
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
						   		$decr.="\t : ".$roww9['comment'];
						   	}


						   	if($sequence_main == 1){ ?>

                                    <div style="border:1px solid #fff; width: 950px; height: 597px; padding-top:16px; padding-left:90px;">

							        <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" style="padding-top:11px">
							           
							           <tr class="tophead">
							           	<td colspan="3" style="padding: 2px 0px 1px 0px;">
							           		<div style="height: 90px;width: 100%;border:0px solid #000;">
							           			<div style=" width: 180px; float: left;">

							                		<p align="center"  style="margin: 8px 1px; " class="" >&ensp;<?php echo $invoic_no;?>&ensp;</p>
							                		<p align="center"  style="margin: 8px 1px; "  class="" >&ensp;<?php echo $menaulnumber;?>&ensp;</p>
							                		<p align="center"  style="margin: 9px 1px;"  class="" >&ensp;<?php echo $invoice_invoice_date;?>&ensp;</p>
							               
							                	</div>

							           			

							           		</div>
							           	</td>
							           </tr>


							            <tr> 
							            	<td colspan="3" style="padding: 2px 0px 1px 0px;">
							            		<div style=" width: 50%; float: right; height: 100px;">
							            			
							            			

							                		<p align="center"   class="invoceinfohead" style="margin-right: 42%"> <?php echo $sender;?> </p>
							                		<p align="center" class="invoceinfohead"  style="margin-right: 42%"><?php echo $id_sernder;?></p>
							                		<p align="center" class="invoceinfohead" style="margin-right: 42%"><?php echo $invoice_sender_phone;?></p>
							                	    <p align="center" class="invoceinfohead" style="margin-right: 42%"><?php echo vtranslate($from_broch); ?> </p>
							                	    <p align="center" class="invoceinfohead" style="margin-right: 42%"><?php echo $Invoice_Subject;?> </p>

							                	
							                	</div>
							                	

							                	<div style="width: 50%; float: left; ">
							                		
							                		<p align="center" class="invoceinfohead" style="margin-right: 42%"><?php echo $recver;?> </p>
							                		<p align="center" class="invoceinfohead" style="margin-right: 42%"><?php echo $id_recipient;?> </p>
							                		<p align="center" class="invoceinfohead" style="margin-right: 42%"><?php echo $invoice_received_phone;?> </p>
							                		
							                		
							                		<p align="center" class="invoceinfohead" style="margin-right: 42%"><?php echo vtranslate($invoice_to_branch); ?> </p>
							                		<p align="center" class="invoceinfohead" style="margin-right: 42%"><?php echo $address_recipient ;?> </p>
							                	


							                	</div>

							            	</td>
							            

							            </tr>

							            
							            <tr>

							                <td style="border:0px solid #000000; border-bottom: 0px; padding: 0px; padding-top: 5px;" colspan="3">
							                	<div style="border:0px solid #000000; height: 136px;margin-top: 8px;margin-left: 20px;">
							                     <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" class="printReport reportPrintData">
							                    <thead>
									                <tr>
									                <th width="15%">&ensp;&ensp;&ensp;&ensp;&ensp;</th>
									                <th>&ensp;&ensp;&ensp;&ensp;&ensp;</th>
									                <th width="10%">&ensp;&ensp;&ensp;&ensp;</th>
									                <th width="8%" >&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</th>
									                <th width="26%" >&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</th>
									                </tr>
							                      </thead>

							                     <tbody class="datarow">





						   <?php  }


						   echo '<tr>
                			<td>'.$ns.'|'.$numcoun.'</td>
                			<td>'.$decr.'</td>
                			<td>'.intval($roww9['quantity']).'</</td>
                			<td>'.intval($roww9['listprice']).'</</td>
                			<td>'.intval($roww9['margin']).'</</td>
                		</tr>';
                		     

                		  if($sequence_main == 3 ||  $numcoun == $ns ){ ?>
                		  	</tbody>
                	
				                   </table>

				                   </div>
				                    
				                    
				                </td>
				            </tr>

				            <tr>
				                <td colspan="3" style="border:0px solid #000000; border-top: 0px; padding: 0px;">
				                    
				                    <div style="height: 123px; border:0px solid #000000; ">
				                	<table width="100%" >
				                  	<tbody>
				                  		<tr>
				                  			<td style="" width="56%">


				                  			</td>

				                  			<td style="" width="8%">
				                  				<p class="cont-1"><?php echo intval($storagevalue) ;?></p>
				                  				<p class="cont-1"><?php echo intval($deliveryvalue) ;?></p> 
				                  				<p class="cont-1"><?php echo  intval($Invoice_Balance); ?></p>
				                  			</td>

				                  			<td style="" width="8%">
				                  			</td>

				                  			<td style="" width="26%">
				                  				<p class="cont-2"><?php echo intval($coust);  ?></p>
				                  				<p class="cont-2"><?php echo $tax ;?></p>
				                  				<p class="cont-2"><?php echo  intval($othercoust); ?></p>
				                  				<p class="cont-2" ><?php echo  intval($Invoice_Received); ?></p>

				                  			</td>
				                  		</tr>
				                  	</tbody>
				                  </table>
				               </div>

				                </td>
				            </tr>
				            <tr>
				            	   <td colspan="3" style="border:0px solid #000000; border-top: 0px; padding: 0px;">
				            			<div style="height: 85px; width: 100%"> 


				            			</div>
				            			<div style="width: 23%; float: left;"> 
				            				<p style="text-align: right;margin: 0px; font-weight: bold;"><?php echo $orgphone ; ?> </p>
				            			</div>
				            		</td>
				            </tr>

				          
				            
				        </table>
				    </div>






                		  <?php }
                		  $ns=$ns+1;

                		  $sequence_main = $sequence_main +1;

                		  if($sequence_main == 4){
                		  	$sequence_main =1;

                		  }

						 }//end wile

						}else{

							echo '<tr>
                			<td colspan="5">لايوجد بيانات</td>
                			
                		</tr>

                		';

						}


                     ?> 
	

                	
   <?php


			   }
			}


 ?>


        

    </body>
    
</html>



		<?php
	}




}


?>