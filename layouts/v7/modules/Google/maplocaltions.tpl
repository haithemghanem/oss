{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.sensor=false 
*************************************************************************************}

{strip}
   <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDN_GUnUwvA6_iW0yyNAhDl64bia2JjBOU&callback=Vtiger_Index_Js.showlocalztion"></script>
	<!--<script type="text/javascript" src="layouts/v7/modules/Google/resources/MapLocations.js"></script>-->
	<div class="modal-dialog modal-lg mapcontainer">
		<div class="modal-content">
			{include file="ModalHeader.tpl"|vtemplate_path:$SOURCE_MODULE TITLE=vtranslate('LBL_GOOGLE_MAP', $SOURCE_MODULE)}
			<div class="row modal-body">
				<input type='hidden' id='record' value='{$RECORD}' />
				<input type='hidden' id='source_module' value='{$SOURCE_MODULE}' />
				<input type='hidden' id='maplet' value='{$LAT}' />
				<input type='hidden' id='maplng' value='{$LNG}' />
				<input type="hidden" id="record_label" />

				<div class="contantedit">
				<div id='mapCanvas' class="col-md-12">
				    <div class="col-md-6 pull-left">
				       <textarea class="hide" id="copylocationurl"> </textarea>
				       <p id="Lebelmap" class="hide">{$Lebel}</p>
				     </div>
				     
				   <div class="col-md-6">
				    <a class="showMap fa fa-map-marker cursorPointer" style="padding: 0px 22px;" href="javascript:void(0);" onclick="Vtiger_Index_Js.showlocalztion();" data-module="Contacts" data-record="{$RECORD}">&nbsp;&nbsp;{vtranslate('Refresh', 'Vtiger')}</a>

				    <span id="editbutton">
				     <a   class="showMap fa fa-edit cursorPointer" style="padding: 0px 22px;" href="javascript:void(0);" onclick="Vtiger_Index_Js.editlocalztion(3);" data-module="Contacts" data-record="{$RECORD}">&nbsp;&nbsp;{vtranslate('Update', 'Vtiger')}</a>&nbsp;&nbsp;
				     <a  class="fa fa-map-marker"  href="javascript:void(0);"  onclick="Vtiger_Index_Js.openonmapdir();">&nbsp;&nbsp; {vtranslate('View On Google Map', 'Vtiger')}</a>&nbsp;&nbsp;

				     <a  class="fa fa-copy"  href="javascript:void(0);"  onclick="Vtiger_Index_Js.copylocationurl();"> {vtranslate('Copy Link Map', 'Vtiger')}</a>


				      </span>
				     </div>
				     
					<span id='address ' class='hide'></span>
					<br>
					<br>
					<div  id="mainmap"  class="col-md-12"  style="min-height: 400px;background: aliceblue;">
						
					</div>
					<div class="col-md-3 hide" id="contantedit">
					   <br>
					   <br>
					   <div class="">
						<a class="fa fa-map-marker" style="padding: 0px 22px;" href="javascript:void(0);" onclick="Vtiger_Index_Js.nowlocalztion();" data-module="Contacts" data-record="1670">&nbsp;{vtranslate('My Location', 'Vtiger')}</a>
						 </div><br>
						<div class="">
						<input type="text" id="letmap" value="{$LAT}" class="form-control" disabled="disabled" placeholder="let"> </div><br>
						<div class="">
						<input type="text" id="lngmap" class="form-control" disabled="disabled" placeholder="len"></div><br>
						<div class="">
						<button type="button" onclick="Vtiger_Index_Js.savelocation();" class="btn btn-success saveButton">{vtranslate('Save', 'Vtiger')}</button>
					     </div>
				     </div>
			
				
			</div>
		</div>
	</div>
 
	
{/strip}