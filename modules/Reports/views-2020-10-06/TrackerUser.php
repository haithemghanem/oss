<?php

class Reports_TrackerUser_View extends Vtiger_Index_View {
    
    
    public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Reports_Module_Model::getInstance($moduleName);

		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserPriviligesModel->hasModulePermission($moduleModel->getId())) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
		}
	}
	
	function getusername($userid){
	     global $adb;
	     $fullname="";
	     $selectuser="SELECT  CONCAT(first_name ,' ',last_name) AS fullname  FROM `vtiger_users` WHERE id=?";
         $resultw = $adb->pquery($selectuser, array($userid));
         $numer=$adb->num_rows($resultw);
	     if($numer)
	     {
	         $fullname= $adb->query_result($resultw, 0, 'fullname');
	     }
	    return $fullname; 
	}
  
  function process (Vtiger_Request $request) {
		//parent::process($request);
		global $adb;
		
	   ?>
	    <br>
      
       <div class="main">
	    <div class="row">
	       <div class="col-md-12" >
	           
	           	  <div class="col-sm-3 floaclass"> 
	                <div class="col-sm-3  floaclass aligntestclass ">
	                   <?php  echo vtranslate('User Name','Reports');?>
	                </div>
	                <div class="col-sm-9 aligntestclass">
	                   <select id="username" class="form-control">
	                    <option value="0"><?php  echo vtranslate('undefined','Reports');?></option>
                         <?php
                           $selectuser="SELECT id , CONCAT(first_name ,' ',last_name) AS fullname FROM vtiger_users WHERE status='Active' ";
                           $resuluser = $adb->pquery($selectuser, array());
                    	    while($rown = $adb->fetch_array($resuluser))
                                  {
                                   echo '<option value="'.$rown['id'].'">'.$rown['fullname'].'</option>';
                                                             
                                  }
                         
                         ?>
                     </select>
	                </div>
	           </div> 
	           
	           
	           
	           <div class="col-sm-3 floaclass " style=""> 
	                <div class="col-sm-3 aligntestclass floaclass">
	                  <?php  echo vtranslate('Model Name', 'Reports');?>
	                </div>
	                <div class="col-sm-9 aligntestclass">
	                  <select id="modelname" class="form-control">
	                    <option value="all"><?php  echo vtranslate('undefined','Reports');?></option>
                         <?php
                           $selectmodel="SELECT name  FROM vtiger_modtracker_tabs INNER JOIN vtiger_tab ON vtiger_tab.tabid = vtiger_modtracker_tabs.tabid WHERE vtiger_modtracker_tabs.visible =1 AND vtiger_tab.presence !=1 and vtiger_tab.name !='Webmails'";
                            $resulmodel = $adb->pquery($selectmodel, array());
                               while($row = $adb->fetch_array($resulmodel))
                                     {
                                         echo '<option value="'.$row['name'].'">'.vtranslate($row['name'],$row['name']).'</option>';
                                         
                                     }
                         ?>
                     </select>
	                </div>
	           </div>
	           
	           <div class="col-sm-4 floaclass" style="">
	                <div class="col-sm-4 aligntestclass floaclass">
	                   <?php  echo vtranslate('Number of records','Reports');?>
	                </div>
	                
	                <div class="col-sm-8 aligntestclass">
	                     <select id="countit" class="form-control" >
	                     <option value="20">20</option>
	                     <option value="50">50</option>
                         <option value="100">100</option>
                         <option value="200">200</option>
                         <option value="300">300</option>
                         <option value="500">500</option>
                         <option value="1000">1000</option>
                         <option value="2000">2000</option>
                         <option value="3000">3000</option>
                         <option value="5000">5000</option>
                         <option value="10000">10000</option>
                     </select>
	                </div>
	           </div>

	           
	         </div>
	       </div>
	   <hr />
	      <div class="row">
	      <div class="col-md-12">
	           <div class="col-sm-4 floaclass " style="">
	                <div class="col-sm-4  floaclass aligntestclass ">
	                  <?php  echo vtranslate('Date and Time', 'Reports'); ?>
	                   </div>
	                <div class="col-sm-8 aligntestclass">
	                    <select id="datatypeop" class="form-control">
	                     <option value="0"><?php  echo vtranslate('undefined','Reports');?></option>
                         <option value="1"><?php  echo vtranslate('Larger','Reports');?></option>
                         <option value="2"><?php  echo vtranslate('Less','Reports');?></option>
                         <option value="3"><?php  echo vtranslate('between','Reports');?></option>
                     </select>
	               </div>
	                   
	             </div>
	           <div class="col-sm-6 floaclass">
	               <div class="fieldUiHolder " style="display: block;">
	                   <div class="referencefield-wrapper col-sm-5 floaclass">
	                     <div class="input-group date">
	                       <input class="inputElement dateField form-control row-fluid ignore-validation"  id="datafris" type="text" data-rule-date="true" data-format="yyyy-mm-dd"  value="" data-value="value">
	                        <span class="input-group-addon">
	                          <i class="fa fa-calendar"></i>
	                         </span>
	                     </div>
	                   </div>
	                    
	                   <div class="referencefield-wrapper col-sm-6  hide"  id="datatoshow">
	                   <div class="col-sm-3 floaclass">
	                       <span> <?php  echo vtranslate('TO','Reports');?> </span>
	                   </div>
	                   <div class="col-sm-9">
	                     <div class="input-group date">
	                       <input class="inputElement dateField form-control row-fluid ignore-validation" id="datato" type="text" data-rule-date="true" data-format="yyyy-mm-dd"  value="" data-value="value">
	                        <span class="input-group-addon">
	                          <i class="fa fa-calendar"></i>
	                         </span>
	                     </div>
	                     </div>
	                   </div>
	               </div>
	            </div>
	            
	            <div class="col-sm-2">
	            <button class="btn btn-default generateReport" id="bton-run"><strong><?php  echo vtranslate('Generate Now','Reports');?></strong></button>
	            </div>
	       </div>
	      </div>
	      
	    </div>
	    
	   <link type="text/css" rel="stylesheet" href="/libraries/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="/libraries/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        
        <br>
        
      
      <style>
         .row #contant_creport #datatable table thead tr th
        { min-width: 70px !important;}
         .row #contant_creport #datatable table tbody tr td
        { min-width: 70px !important;}
        
      </style>
       <hr/>
	   <div class="row">
	       <div id="contant_creport" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
	           
	        
	           
	         </div><!-- end con -->
	     </div>
	   
	      <script src="/libraries/datatables.net/js/jquery.dataTables.min.js"></script>
          <script src="/libraries/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
         <script src="/libraries/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
         <script src="/libraries/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
         <script src="/libraries/datatables.net-buttons/js/buttons.html5.min.js"></script>
          <script src="/libraries/datatables.net-buttons/js/buttons.print.min.js"></script>
         <script src="/libraries/datatables.net-buttons/js/buttons.html5.min.js"></script>
         <script src="/libraries/datatables.net-buttons/js/buttons.colVis.js"></script>
                  

	  
	 <script>
	     $(document).ready(function(){
	         
	         $("#datatypeop").on('change',function(e){
	          //datato 
	          var vale =$("#datatypeop").val();
	          //datatoshow
	          if(vale==3){
	               $("#datatoshow").removeClass("hide");
	          }
	          else{
	              $("#datatoshow").addClass("hide");
	          }
	          //console.log("this vale:"+vale);
	         });
	         
	         $("#bton-runn").on('click',function(){
	             alert("gggooood");
	         });
	         
	        $("#bton-run").on('click',function(){
	       console.log("user :"+$("#username").val());
	       var url ="/module/Reports/TrackerUseraj";
	       var params = {
				'module' : 'Reports',
				'view'   : 'TrackerUseraj',
				'mode'   :'TrackerUsera',
				'count'  : $("#countit").val(),
				'modelsel' : $("#modelname").val(),
				'usersel'  : $("#username").val(),
				'datatypeop'  : $("#datatypeop").val(),
				'datafris'  : $("#datafris").val(),
				'datato'  : $("#datato").val(),
			 }
			 jQuery('#contant_creport').html("")
	         AppConnector.request(params).then(
				function(data){
			  jQuery('#contant_creport').html(data['result']['Messages']);
			  console.log("counttt "+data['result']['count']);
		     },
			function(error,err){
			     console.log("error ");
			}
			);
	        });
	     });
	   
	function tabsis($idtabl){
	    //alert(""+$idtabl+"");
     $('#'+$idtabl+' tfoot .ok').each( function (){
        var title = $(this).text();
        var serchin="<?php  echo vtranslate('Search in','Reports');?> :";
        $(this).html( '<input type="text" placeholder=" '+serchin+' '+title+'" />' );
    });

    var table = $('#'+$idtabl+'').DataTable();
    // Apply the search
    table.columns().every( function (){
        var that = this;
        $('input' , this.footer()).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search(this.value)
                    
                    .draw();
            }
        });
        });
	   }
	 </script>
	  <?php
	  
	}



}