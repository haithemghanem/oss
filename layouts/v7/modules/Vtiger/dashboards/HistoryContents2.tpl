{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

 <link type="text/css" rel="stylesheet" href="./libraries/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
 <link type="text/css" rel="stylesheet" href="./libraries/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">

<div style='padding:15px;'>

<div class="" style="margin: 1px;">
  <div class="col-sm-12" style='padding-bottom: 20px;'>

  <form method="GET" action="index.php?module=Home&view=History"> 
     <input type="hidden" name="module" value="Home">
     <input type="hidden" name="view" value="History">
   <div class="col-lg-3">
	   <div class="userList">
	        {assign var=CURRENT_USER_ID value=$CURRENT_USER->getId()}
	        {if $ACCESSIBLE_USERS|@count gt 1}
	            <select class="select2 " name="type" style='min-width: 200px;'>
	                <option value="all" {if $USERIDD  eq  "all"} selected {/if} > {$USERIDD} {vtranslate('All', $MODULE_NAME)}</option>
	                {foreach key=USER_ID from=$ACCESSIBLE_USERS item=USER_NAME}
	                    <option value="{$USER_ID}"  {if $USERIDD  eq  $USER_ID } selected {/if} >
	                    {if $USER_ID eq $CURRENT_USER_ID} 
	                        {vtranslate('LBL_MINE',$MODULE_NAME)}
	                    {else}
	                        {$USER_NAME}
	                    {/if}
	                   
	                    </option>
	                {/foreach}
	            </select>
	            {else}
	                <center>{vtranslate('LBL_MY',$MODULE_NAME)} {vtranslate('History',$MODULE_NAME)}</center>
	        {/if}
	    </div>
    </div>

   <div class="col-lg-3">
            <select class="select" name="historyType" style='min-width: 100px;'>
	                <option value="all" {if $HISTORYTYPE eq 'all'} selected  {/if} >{vtranslate('All', $MODULE_NAME)}</option>
	                <option value="updates" {if $HISTORYTYPE eq 'updates'} selected  {/if} >{vtranslate(LBL_UPDATES, $MODULE_NAME)}</option>
	                 {if $COMMENTS_MODULE_MODEL->isPermitted('DetailView')}
                        <option value="comments" {if $HISTORYTYPE eq 'comments'} selected  {/if} >{vtranslate(LBL_COMMENTS, $MODULE_NAME)}</option>
                     {/if}
             </select>         
       </div>


        <div class="col-lg-4">
              <span class="col-lg-4">
                        <span>
                            <strong>{vtranslate('LBL_SELECT_DATE_RANGE', $MODULE_NAME)}</strong>
                        </span>
              </span>
              <span class="col-lg-7">
                    <div class="input-daterange input-group dateRange " id="datepicker" name="modifiedtime">
                        <input type="text" class="input-sm form-control dateField  id="start" data-date-format="yyyy-mm-dd"  value="{$MODIFIEDSTART}" name="start" style="height:30px;"/>
                        <span class="input-group-addon">to</span>
                        <input type="text" class="input-sm form-control dateField " data-date-format="yyyy-mm-dd"  id="end" value="{$MODIFIEDEND}" name="end" style="height:30px;"/>
                    </div>
                </span>
            </div>

         

	      <div class="col-lg-1">
	          <button class="btn btn-success generateReport" type="submit" id="bton-run"><strong>{vtranslate('GO','Vtiger')}</strong></button>
	     </div>


	     <div class="col-lg-1">

            {if $NEXTPAGE}
			<div class="row">
				<div class="col-lg-12">
					<a href="index.php?module=Home&view=History&type={$USERIDD}&historyType={$HISTORYTYPE}&start={$MODIFIEDSTART}&end={$MODIFIEDEND}&page={$NEXTPAGE}" class="btn btn-default" data-page="{$PAGE}" data-nextpage="{$NEXTPAGE}">{vtranslate('LBL_NEXT')} </a>
				</div>
			  </div>
		    {/if}

         </div>


     </div>
    </div>
  </form>
  <br>
	{if $HISTORIES neq false}

	
     
          <table  dir="" id="datatable1" class="table table-striped table-bordered">
            <thead>
              <tr>
                
                <th style="min-width: 70px !important;"> {vtranslate('App Name', 'Reports')}</th>
                <th style="min-width: 70px !important;"> {vtranslate('Action', 'Reports')} </th>
                <th style="min-width: 200px !important;"> {vtranslate('User Name', 'Reports')} </th>
                <th style="min-width: 70px !important;"> {vtranslate('Record', 'Reports')} </th>
                <th style="min-width: 70px !important;"> {vtranslate('Contant', 'Reports')} </th>
                <th style="min-width: 70px !important;"> {vtranslate('Interval', 'Reports')} </th>
                <th style="min-width: 200px !important;"> {vtranslate('Data&Time', 'Reports')} </th>
              </tr>
               
            </thead>
            <tfoot>
                <tr>
               
                <th class="ok" style="min-width: 70px !important;"> {vtranslate('App Name', 'Reports')}</th>
                <th class="ok" style="min-width: 70px !important;"> {vtranslate('Action', 'Reports')} </th>
                <th class="ok" style="min-width: 70px !important;"> {vtranslate('User Name', 'Reports')} </th>
                <th class="ok" style="min-width: 70px !important;"> {vtranslate('Record', 'Reports')} </th>
                <th class="ok" style="min-width: 70px !important;"> {vtranslate('Contant', 'Reports')} </th>
                <th class="ok" style="min-width: 70px !important;"> {vtranslate('Interval', 'Reports')} </th>
                <th class="ok" style="min-width: 70px !important;"> {vtranslate('Data&Time', 'Reports')} </th>


              </tr>
            </tfoot>
            
            <tbody>


		{foreach key=$index item=HISTORY from=$HISTORIES}
			{assign var=MODELNAME value=get_class($HISTORY)}
			{if $MODELNAME == 'ModTracker_Record_Model'}
				{assign var=USER value=$HISTORY->getModifiedBy()}
				{assign var=TIME value=$HISTORY->getActivityTime()}
				{assign var=PARENT value=$HISTORY->getParent()}
				{assign var=MOD_NAME value=$HISTORY->getParent()->getModule()->getName()}
				{assign var=SINGLE_MODULE_NAME value='SINGLE_'|cat:$MOD_NAME}
				{assign var=TRANSLATED_MODULE_NAME value = vtranslate($MOD_NAME ,$MOD_NAME)}
				{assign var=PROCEED value= TRUE}
				{if ($HISTORY->isRelationLink()) or ($HISTORY->isRelationUnLink())}
					{assign var=RELATION value=$HISTORY->getRelationInstance()}
					{if !($RELATION->getLinkedRecord())}
						{assign var=PROCEED value= FALSE}
					{/if}
				{/if}
				{if $PROCEED}
					
                       <tr>
							{assign var=VT_ICON value=$MOD_NAME}
							{if $MOD_NAME eq "Events"}
								{assign var="TRANSLATED_MODULE_NAME" value="Calendar"}
								{assign var=VT_ICON value="Calendar"}
							{else if $MOD_NAME eq "Calendar"}
								{assign var=VT_ICON value="Task"}
							{/if}

							<td> 
							<span>{$HISTORY->getParent()->getModule()->getModuleIcon($VT_ICON)}  </span>
							<span>&nbsp;&nbsp; {vtranslate($MOD_NAME,$MOD_NAME)} </span>
							</td>
						

						
							{assign var=DETAILVIEW_URL value=$PARENT->getDetailViewUrl()}

							{if $HISTORY->isUpdate()}
							    
								{assign var=FIELDS value=$HISTORY->getFieldInstances()}

								 <td> {vtranslate('LBL_UPDATED')} </td>
									
									<td> <b>{$USER->getName()}</b> </td>

									<td>
									 <a class="cursorPointer" {if stripos($DETAILVIEW_URL, 'javascript:')===0}
																								  onclick='{$DETAILVIEW_URL|substr:strlen("javascript:")}' {else} onclick='window.location.href="{$DETAILVIEW_URL}"' {/if}>
										{$PARENT->getName()} </a>
									  </td>

									 <td>
									{foreach from=$FIELDS key=INDEX item=FIELD}

										{if $INDEX lt 2}
											{if $FIELD && $FIELD->getFieldInstance() && $FIELD->getFieldInstance()->isViewableInDetailView()}
												<div>
													<i>{vtranslate($FIELD->getName(), $FIELD->getModuleName())}</i>
													{if $FIELD->get('prevalue') neq '' && $FIELD->get('postvalue') neq '' && !($FIELD->getFieldInstance()->getFieldDataType() eq 'reference' && ($FIELD->get('postvalue') eq '0' || $FIELD->get('prevalue') eq '0'))}
														&nbsp;{vtranslate('LBL_FROM')} <b>{Vtiger_Util_Helper::toVtiger6SafeHTML($FIELD->getDisplayValue(decode_html($FIELD->get('prevalue'))))}</b>
													{else if $FIELD->get('postvalue') eq '' || ($FIELD->getFieldInstance()->getFieldDataType() eq 'reference' && $FIELD->get('postvalue') eq '0')}
														&nbsp; <b> {vtranslate('LBL_DELETED')} </b> ( <del>{Vtiger_Util_Helper::toVtiger6SafeHTML($FIELD->getDisplayValue(decode_html($FIELD->get('prevalue'))))}</del> )
													{else}
														&nbsp;{vtranslate('LBL_CHANGED')}
													{/if}
													{if $FIELD->get('postvalue') neq '' && !($FIELD->getFieldInstance()->getFieldDataType() eq 'reference' && $FIELD->get('postvalue') eq '0')}
														{vtranslate('LBL_TO')} <b>{Vtiger_Util_Helper::toVtiger6SafeHTML($FIELD->getDisplayValue(decode_html($FIELD->get('postvalue'))))}</b>
													{/if}    
												</div>
											{/if}
										{else}
											<a href="{$PARENT->getUpdatesUrl()}">{vtranslate('LBL_MORE')}</a>
											{break}
										{/if}
									{/foreach}
								</td>
							{else if $HISTORY->isCreate()}
								<td> {vtranslate('LBL_ADDED')} </td>
								<td>	<b>{$USER->getName()}</b> </td>
								<td>  
									<a class="cursorPointer" {if stripos($DETAILVIEW_URL, 'javascript:')===0} onclick='{$DETAILVIEW_URL|substr:strlen("javascript:")}' {else} onclick='window.location.href="{$DETAILVIEW_URL}"' {/if}>{$PARENT->getName()}</a>
								</td>
								 <td> </td>
							{else if ($HISTORY->isRelationLink() || $HISTORY->isRelationUnLink())}
								{assign var=RELATION value=$HISTORY->getRelationInstance()}
								{assign var=LINKED_RECORD_DETAIL_URL value=$RELATION->getLinkedRecord()->getDetailViewUrl()}
								{assign var=PARENT_DETAIL_URL value=$RELATION->getParent()->getParent()->getDetailViewUrl()}
								
								  <td> 
								  {if $HISTORY->isRelationLink()}
										{vtranslate('LBL_LINKED', $MODULE_NAME)}
									{else}
										{vtranslate('LBL_REMOVED', $MODULE_NAME)}
									{/if}

								  </td>
								   <td> <b>{$USER->getName()}</b> </td>
								  <td>
									{if $RELATION->getLinkedRecord()->getModuleName() eq 'Calendar'}
										{if isPermitted('Calendar', 'DetailView', $RELATION->getLinkedRecord()->getId()) eq 'yes'}
											<a class="cursorPointer" {if stripos($LINKED_RECORD_DETAIL_URL, 'javascript:')===0} onclick='{$LINKED_RECORD_DETAIL_URL|substr:strlen("javascript:")}'
											{else} onclick='window.location.href="{$LINKED_RECORD_DETAIL_URL}"' {/if}>{$RELATION->getLinkedRecord()->getName()}</a>
									{else}
										{vtranslate($RELATION->getLinkedRecord()->getModuleName(), $RELATION->getLinkedRecord()->getModuleName())}
									{/if}
								{else if $RELATION->getLinkedRecord()->getModuleName() == 'ModComments'}
									<i>"{$RELATION->getLinkedRecord()->getName()}"</i>
								{else}
									<a class="cursorPointer" {if stripos($LINKED_RECORD_DETAIL_URL, 'javascript:')===0} onclick='{$LINKED_RECORD_DETAIL_URL|substr:strlen("javascript:")}'
									{else} onclick='window.location.href="{$LINKED_RECORD_DETAIL_URL}"' {/if}>{$RELATION->getLinkedRecord()->getName()}</a>
							{/if}{vtranslate('LBL_FOR')} <a class="cursorPointer" {if stripos($PARENT_DETAIL_URL, 'javascript:')===0}
							   onclick='{$PARENT_DETAIL_URL|substr:strlen("javascript:")}' {else} onclick='window.location.href="{$PARENT_DETAIL_URL}"' {/if}>
									{$RELATION->getParent()->getParent()->getName()}</a>
							</td>
							 <td>  </td>
						 {else if $HISTORY->isRestore()}

							<td> {vtranslate('LBL_RESTORED')}  </td>
							<td>	<b>{$USER->getName()}</b>  </td>

							<td> <a class="cursorPointer" {if stripos($DETAILVIEW_URL, 'javascript:')===0}
																						  onclick='{$DETAILVIEW_URL|substr:strlen("javascript:")}' {else} onclick='window.location.href="{$DETAILVIEW_URL}"' {/if}>
									{$PARENT->getName()}</a>
							</td>
							<td>  </td>

						{else if $HISTORY->isDelete()}
							<td> {vtranslate('LBL_DELETED')} </td>

							<td> {$USER->getName()}  </td>
								 
							<td>
								 {$PARENT->getName()}
							</td>
							<td>  </td>
						{/if}
					 <td>
					<p class="pull-right muted" style="padding-right:10px;"><small title="{Vtiger_Util_Helper::formatDateTimeIntoDayString("$TIME")}">{Vtiger_Util_Helper::formatDateDiffInStrings("$TIME")}</small></p>
					</td>
					<td> {$TIME} </td>

			{/if}

			{else if $MODELNAME == 'ModComments_Record_Model'}

			   <td> <span><i class="vicon-chat entryIcon" title={$TRANSLATED_MODULE_NAME}></i></span>  <span> Comments </span></td>

			   <td> {vtranslate('LBL_COMMENTED')} {vtranslate('LBL_ON')}  </td>
			   <td> <b>{$HISTORY->getCommentedByName()}</b> </td>


                <td>
				
					{assign var=COMMENT_TIME value=$HISTORY->getCommentedTime()}

					<div>
					  <a class="textOverflowEllipsis" href="{$HISTORY->getParentRecordModel()->getDetailViewUrl()}">{$HISTORY->getParentRecordModel()->getName()}</a>
						</td>

					<td>
						<div><i>"{nl2br($HISTORY->get('commentcontent'))}"</i></div>
					</td>

				 <td>

					<p class="pull-right muted" style="padding-right:10px;"><small title="{Vtiger_Util_Helper::formatDateTimeIntoDayString("$COMMENT_TIME")}">{Vtiger_Util_Helper::formatDateDiffInStrings("$COMMENT_TIME")}</small></p>

				</td>
				<td> {$TIME} </td>


				
			{/if}

          </tr>
		{/foreach}

    </tbody>
</table>

	<script src="./libraries/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="./libraries/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="./libraries/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="./libraries/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	<script src="./libraries/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="./libraries/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="./libraries/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="./libraries/datatables.net-buttons/js/buttons.colVis.js"></script>

<script type="text/javascript">
{literal}
	   jQuery(document).ready(function() { 
		    var vtigerInstance =new Vtiger_Index_Js();
		        vtigerInstance.registerEvents();
		  	var urlex; 
		  $( "#start" ).datepicker();
		  $( "#end" ).datepicker();
		});
      {/literal}
	</script>
  
	 <script>
	 {literal}
         jQuery(document).ready(function() {
          var handleDataTableButtons = function() {
          if ($("#datatable1").length) {
            $("#datatable1").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm",
                  exportOptions: {
                    columns: ":visible"
                }
                },
                {
                  extend: "colvis",
                  className: "btn-sm",
                  targets: -1,
                  visible: false
        
                }
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        TableManageButtons.init();
       var table = jQuery("#datatable1").DataTable();
     $("#datatable1 tfoot").css({"display":"table-header-group"});

    $('#datatable1 tfoot .ok').each( function (){
        var title = $(this).text();
        var serchin="{vtranslate('Search in','Reports')} :";
        $(this).html( '<input type="text" placeholder="'+title+'" />' );
    });


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

       
        
      });
      {/literal}
    </script>
		
   

	{else}
		<span class="noDataMsg">
			{if $HISTORY_TYPE eq 'updates'}
				{vtranslate('LBL_NO_UPDATES', $MODULE_NAME)}
			{elseif $HISTORY_TYPE eq 'comments'}
				{vtranslate('LBL_NO_COMMENTS', $MODULE_NAME)}
			{else}
				{vtranslate('LBL_NO_UPDATES_OR_COMMENTS', $MODULE_NAME)}
			{/if}
		</span>
	{/if}
</div>