
<?php

class Invoice_CarriersReport_View extends Vtiger_Index_View {

	

	function process(Vtiger_request $request) {
		// $mode = $request->getMode();
		// if(!empty($mode)) {
		// 	$this->invokeExposedMethod($mode, $request);
		// }

       $viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();
		//$this->initializeListViewContents($request);


		?>

	

	  <div class="main">
	    <div class="row">
	       <div class="col-md-12" >
	           
	           	<div dir="" class="row">
         <div class="col-md-12 float-right" style="float: right !important;">
           </div>
         <div class="col-xs-12 col-sm-6 col-md-2 col-lg-1 pull-right" style="float: right !important;">
  
            <div class="fieldUiHolder " style="display: block;">
	                   <div class="referencefield-wrapper col-sm-5 floaclass">
	                     <div class="input-group date">
	                       <input class="inputElement dateField form-control row-fluid ignore-validation"  id="datafris" type="text" data-rule-date="true" data-format="yyyy-mm-dd"  value="" data-value="value">
	                        <span class="input-group-addon">
	                          <i class="fa fa-calendar"></i>
	                         </span>
	                     </div>
	                   </div>         
	           </div>

          <div class="col-xs-12 col-sm-6 col-md-2 col-lg-1 pull-right" style="float: right !important;">
             <span> اسم الخدمة</span>
         </div>
         
         
            
         <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 pull-right">
             
         
         <select  id="selservice" data-fieldtype="picklist" class="inputElement select2  select2-offscreen" type="picklist" name="" data-selected-value="" tabindex="-1" title="">
             <option value="">حدد خدمة</option>
             
             <?php
             $adb = PearDatabase::getInstance();
             $sql="SELECT vtiger_service.servicename ,vtiger_service.serviceid, vtiger_crmentity.label FROM vtiger_service , vtiger_crmentity  WHERE vtiger_service.serviceid=vtiger_crmentity.crmid AND vtiger_crmentity.deleted =0";
             $paramter=array();
             $result=$adb->pquery($sql,$paramter);
             if($adb->num_rows($result) >= 1)
              {
	            while($roww = $adb->fetch_array($result))
	             { 
	                 
	               echo '<option value="'.$roww['servicename'].'" class="'.$roww['servicename'].'">'.$roww['servicename'].'</option>';
	             }
              }
             
             ?>

             </select>
         
            </div>
	     </div>
	     <div class="col-sm-2">
	            <button class="btn btn-default generateReport" id="bton-run"><strong><?php  echo vtranslate('Generate Now','Reports');?></strong></button>
	        </div>
	   <hr>

	   

		<?php
	}




}

?>