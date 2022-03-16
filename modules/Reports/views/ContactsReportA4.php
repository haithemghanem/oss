<?php

//ContactsReportA4


class Reports_ContactsReportA4_View extends Vtiger_Index_View {

	
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

          <div class="row">
	       



	         <div class="col-md-12" >

             <div class="col-sm-10 floaclass" style="">

	                <div class="col-sm-2 aligntestclass floaclass">
	                <?php  echo vtranslate('Date','Invoice');?>
	                </div>

	                <div class="col-sm-1 aligntestclass" style="padding: 0px">
	                  <select id="datecondion" class="form-control">
	                     <option value="1"><?php  echo vtranslate('equal','Invoice');?></option>
	                     <option value="2"><?php  echo vtranslate('between','Invoice');?></option>
	                 </select>

	                </div>


	                
	              <div class="col-sm-3 aligntestclass">
	                	<div class="referencefield-wrapper  ">
	                     <div class="input-group date">
	                       <input class="inputElement dateField form-control row-fluid ignore-validation"  id="dateid" type="text" data-rule-date="true" data-format="yyyy-mm-dd"  value="<?php echo date('Y-m-d'); ?>" required  data-value="value">
	                        <span class="input-group-addon">
	                          <i class="fa fa-calendar"></i>
	                         </span>
	                     </div>
	                   </div> 
	                </div>



	             
	                
	                <div  id="contanttodate" class="col-sm-4 aligntestclass hide">

	                   <div class="col-sm-2 floaclass">
	                   	 <?php  echo vtranslate('TO','Invoice');?>

	                    </div>

                       <div  class="col-sm-10 aligntestclass">
	                	<div class="referencefield-wrapper  ">
	                	<div class="input-group date">
	                       <input class="inputElement dateField form-control row-fluid ignore-validation"  id="dateidto" type="text" data-rule-date="true" data-format="yyyy-mm-dd"  value=""  data-value="value">
	                        <span class="input-group-addon">
	                          <i class="fa fa-calendar"></i>
	                         </span>
	                     </div>
	                    </div>
	                </div>

	                	
	                </div>
	            </div>

	            <div class="col-sm-2 floaclass" style="">
	            	<button class="btn btn-success generateReport" type="submit" id="bton-run"><strong><?php  echo vtranslate('Generate Now','Invoice');?></strong></button>

	             </div>
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
		    var vtigerInstance =new Vtiger_Index_Js();
		        vtigerInstance.registerEvents();
		    jQuery("#datecondion").on('change',function(e ){
		    	var val = this.value;
		    	if(val == 1){
		    		jQuery('#contanttodate').addClass('hide');
		    		jQuery("#dateidto").val("");

		    	}else if( val ==2){
		    		jQuery('#contanttodate').removeClass('hide');

		    	}	

		    });


		  jQuery("#formrepor").submit(function(e){
		  	e.preventDefault();

		  	var dateid =jQuery("#dateid").val();

		  	var  condate = jQuery("#datecondion").val();

		  	var dateidto = jQuery("#dateidto").val();

		  	if(dateidto == ''){
		  		dateidto =0;

		  	}
		  	
		  	var urlex="?module=Reports&view=ContactsReportA4Print&date="+dateid+"&condate="+condate
		  	+"&dateto="+dateidto;
		  	window.open(urlex, '_blank');
		  	//console.log(urlex);

		  });

		});
        
	    </script>

	   

		<?php
	
 

	}

}



?>