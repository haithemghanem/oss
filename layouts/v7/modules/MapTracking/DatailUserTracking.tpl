<div id="sidebar-essentials" class="sidebar-essentials">
		  <div class="sidebar-menu">
			    <div class="module-filters" id="module-filters">
			        <div class="sidebar-container lists-menu-container">
			            <div class="sidebar-header clearfix">
			                <h5 class="pull-left">{vtranslate('Data','Vtiger')}</h5>
			            </div>
			            <hr>
			            <br>
			            
			            <div class="col-md-12">
			            	<span col-md-12>{vtranslate('Date','Vtiger')}</span>
			            </div>
			            <div class="col-md-12">
			            <div class="input-group inputElement" style="margin-bottom: 3px;min-width: 180px !important;">
			            <input id="DUserTrackingday" type="text" class="dateField form-control " data-fieldname="date" data-fieldtype="date" name="dayne" data-date-format="yyyy-mm-dd" value="{$DATADAY}" ><span class="input-group-addon"><i class="fa fa-calendar "></i></span>
			            </div>
			            </div>

			            <div class="col-md-12">
			            	<span col-md-12>{vtranslate('Users','Vtiger')}</span>
			            </div>
			            <div class="">
			            <select class="select2 col-md-12" id="DUserTrackinguser" name="columnname" data-placeholder="{vtranslate('Users','Vtiger')}">
			              <option value="All" selected>{vtranslate('All','Vtiger')} {vtranslate('Users','Vtiger')}</option>
			              {foreach item=USERNAM key=USERID from=$ALLUSERS}
			              <option value="{$USERID}">{$USERNAM}</option>
			              {/foreach}
			            </select>
			            </div>
			            
			            <div class="col-md-12" style="padding:30px;text-align:center">
			            <button class="btn btn-success" id="DUserTracking" type="button"  name="saveButton">{vtranslate('Refresh','Vtiger')}</button>
			            
			            </div>
			            
			        </div>
			     </div>
          
            </div>
			
		</div>

 <div class="">

      <input type="hidden" id="oldlet">
      <input type="hidden" id="oldlen">
      <input type="hidden" id="ACTIVATIONTRACKING" value="{$ACTIVATIONTRACKING}">
	  <input type="hidden" id="TRACKINGPERIODS" value="{$TRACKINGPERIODS}">
	<input type="hidden" id="DATADAY" value="{$DATADAY}">

	   


		<div class="listViewPageDiv content-area" id="listViewContent">
		  <div class="">

		    <div class="essentials-toggle" title="">
			    <span class="essentials-toggle-marker fa fa-chevron-left cursorPointer"></span>
		    </div>


		    <div id="listview-actions" class="listview-actions-container" style="display:none"><div class="row">
		    	<div class="col-md-4">
		    	  
		    	</div>
		    	<div class="col-md-4">
		    	</div>
		    	<div class="col-md-4">
		    	</div>
		    </div></div>

           

		    
		    <div class="floatThead-wrapper" >
		     <div id="usertrackingcontant" class="table-container ps-container ">

		    <span id="ModuleName" class="hide">{$MODULE_NAME}</span>
				<span id="map_module" class="hide"></span>

				<div class="{$MODULE_NAME}">
				  <div class="">
				   <div class="k" style="display:none">
				  <h1> {$MODULE_NAME} </h1>
				  <h1> {$ACTIVATIONTRACKING} </h1>
				  <h1> {$TRACKINGPERIODS} </h1>
				  <h1> {$DATADAY} </h1>
				  </div>
				  
				  <div id="contant" style="display:none">
				    </div>
				   <div id="maptracking" style="width:100%;min-height:700px;background-color:#d8cdcd;">

				   </div>

				</div>
				</div>


			</div>
			</div>
			</div>

		  </div>
		</div>
 </div>
 <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDN_GUnUwvA6_iW0yyNAhDl64bia2JjBOU&sensor=false"></script>
<script type="text/javascript">
		{literal}jQuery(document).ready(function() { 
		    //var vtigerInstance = Vtiger_Index_Js.getInstance();
		     // vtigerInstance.getInstance();
		    var vtigerInstance =new Vtiger_Index_Js();
		        vtigerInstance.registerEvents();
		        
		      var gutInstancem = new MapTacking_Run_Js();
		      gutInstancem.getuserTracking();

		});
        {/literal}
	</script>
{/strip}