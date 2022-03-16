
<?php

class Reports_CarriersReport_View extends Vtiger_Index_View {

	
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Reports_Module_Model::getInstance($moduleName);

		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserPriviligesModel->hasModulePermission($moduleModel->getId())) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
		}
	}


	function process (Vtiger_request $request) {
		   global $adb;

		?>

	

	  <div class="main" style="min-height: 600px;">
	    <div class="row" style="background: #fff;padding: 50px;">
          <form  id="formrepor">
	       <div class="col-md-12" >
	        
	        <div class="col-sm-4 floaclass" style="">
	                <div class="col-sm-4 aligntestclass floaclass">
	                  <?php  echo vtranslate('To branch','Invoice');?>
	                </div>
	                 
	                <div class="col-sm-8 aligntestclass">
	                    <select id="tobranch" class="form-control" required="true">
	                     <option value=""><?php  echo vtranslate('Select Branch','Invoice');?></option>
	                    <?php 
	                    $quer="SELECT * FROM vtiger_cf_950 WHERE 1 ORDER by sortorderid";
	                    $paramter=array();
				             $result=$adb->pquery($quer,$paramter);
				             if($adb->num_rows($result) > 0)
				              {
				              	while($roww = $adb->fetch_array($result))
					             { 
					             	
					                echo '<option value="'.$roww['cf_950'].'">'.vtranslate($roww['cf_950'],'Invoice').'</option>';
					              }

				              }

	                    ?>
	                   
                         
                     </select>
	                </div>
	           </div>
             <div class="col-sm-4 floaclass"> 
	                <div class="col-sm-3  floaclass aligntestclass ">
	                   <?php  echo vtranslate('Carrier Name','Invoice');?>
	                </div>
	                <div class="col-sm-9 aligntestclass">

	                	 <select  id="carriersid" data-fieldtype="picklist" class="inputElement select2  select2-offscreen" type="picklist" name="" data-selected-value="" tabindex="-1" title="" required>
				             <option value=""><?php  echo vtranslate('Select Carrier','Invoice');?> </option>
				             
				             <?php
				      
				             $sql="SELECT vtiger_vendor.vendorname , vtiger_vendor.vendorid ,vtiger_crmentity.label FROM vtiger_vendor
                                    INNER JOIN vtiger_crmentity on vtiger_crmentity.crmid = vtiger_vendor.vendorid and vtiger_crmentity.deleted=0";
				             $paramter=array();
				             $result=$adb->pquery($sql,$paramter);
				             if($adb->num_rows($result) >= 1)
				              {
					            while($roww = $adb->fetch_array($result))
					             { 
					                 
					               echo '<option value="'.$roww['vendorid'].'" class="'.$roww['vendorname'].'">'.$roww['vendorname'].'</option>';
					             }
				              }
				             
				             ?>

                        </select>

	                </div>
	             </div>

            <br>
            <br>
            <br>
            <br>

	         <div class="col-md-12" >

	         	
	         		
	         	

	         	 <div class="col-sm-4 floaclass" style="">
	                <div class="col-sm-4 aligntestclass floaclass">
	                <?php  echo vtranslate('Date','Invoice');?>
	                </div>
	                
	                <div class="col-sm-8 aligntestclass">
	                	<div class="referencefield-wrapper  ">
	                     <div class="input-group date">
	                       <input class="inputElement dateField form-control row-fluid ignore-validation"  id="dateid" type="text" data-rule-date="true" data-format="yyyy-mm-dd"  value="" required  data-value="value">
	                        <span class="input-group-addon">
	                          <i class="fa fa-calendar"></i>
	                         </span>
	                     </div>
	                   </div> 

	                </div>
	              </div>
	              
	              <div class="col-sm-4 floaclass" style="">
	             	<div class="col-sm-4 aligntestclass floaclass">
	                  رقم الحملة
	                </div>
	                <div class="col-sm-8 aligntestclass">
	                	<input type="text" name="" id="capnum" value="1">
	                </div>
	             </div>



	            <div class="col-sm-4 floaclass" style="">
	            	<button class="btn btn-success generateReport" type="submit" id="bton-run"><strong><?php  echo vtranslate('Generate Now','Invoice');?></strong></button>

	            </div>
	            </form>

	         <br>
            <br>
            <br>
            <br>


	     </div>
	    </div>
	    
	   <hr>

	   <script type="text/javascript">
	   jQuery(document).ready(function() { 
		    //var vtigerInstance = Vtiger_Index_Js.getInstance();
		     // vtigerInstance.getInstance();
		    var vtigerInstance =new Vtiger_Index_Js();
		        vtigerInstance.registerEvents();

		  jQuery("#formrepor").submit(function(e){
		  	e.preventDefault();
		  	var capnum =jQuery("#capnum").val();
		  	var dateid =jQuery("#dateid").val();
		  	var carriersid = jQuery("#carriersid").val();
		  	var tobranch = jQuery("#tobranch").val();
		  	//var host = window.location.hostname;
		  	
		  	var urlex="?module=Reports&view=CarriersReportPrint&Carriersid="+carriersid+"&tobranch="+tobranch+"&date="+dateid+"&capnum="+capnum;
		  	window.open(urlex, '_blank');
		  	console.log(urlex);

		  });

		});
        
	    </script>

	   

		<?php
	}




}

?>