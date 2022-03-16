{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/ModuleManager/views/List.php *}

{strip}
  <style type="text/css">
  	.icon-cog{
background:#c6ff00;
}

.icon-dashboard{
background:#c41c00;
}
.icon-trash{
background: #ff1744;
}

.icon-chat{
  background:#ff5722;
}
.icon-leads{
  background:#d50000;
  }
.icon-accounts {
  background:#c51162;
  }
.icon-contacts{
  background:#aa00ff;
  }
.icon-campaigns {
  background:#6200ea;
}

.icon-quotes{
  background:#304ffe;
}

.icon-products{
  background:#0091ea;
}
.icon-services{
  background:#00b8d4;
}
.icon-smsnotifier{
  background:#00bfa5;
}
.icon-potentials{
  background:#00c853;
}
.icon-assets{
  background:#64dd17;
}
.icon-salesorder{
  background:#aeea00;
}
.icon-invoice{
  background:#ffd600;
}
.icon-vendors{
  background:#ffab00;
}
.icon-pricebooks{
  background:#ff6d00;
}
.icon-purchaseorder{
  background:#dd2c00;
}
.icon-servicecontracts{
  background:#880e4f;
}
.icon-projectmilestone{
  background:#4a148c;
}
.icon-projecttask {
  background:#1a237e;
}
.icon-project{
  background:#0d47a1;
}
.icon-helpdesk{
  background:#006064;
}
.icon-faq{
  background:#1b5e20;
}
.icon-pbxmanager{
  background:#827717;
}
.icon-mailmanager{
  background:#f57f17;
}
.icon-documents{
  background:#e65100;
}
.icon-task{
  background:#40c4ff;
}
.icon-calendar{
  background:#1de9b6;
}
.icon-emailtemplates{
  background:#388e3c;
}
.icon-chat{
  background:#ff4081;
}
.icon-call{
  background:#00b0ff;
}

.icon-chart{
  background:#ff5722;
}
.icon-reports{
	background:#ff5722;
}

.icon-workday{
	background:#a33108;
}
.icon-popupnotify {

}
.icon-emails{
	background:#f57f17;
}
.icon-portal{
	background:#c6ff00;
}
.icon-webmails{
	background:#388e3c;
}
.icon-google{
	background:#c6ff00;
}
.icon-recyclebin{
	background: #ff1744;
}
.icon-webforms{
	background:#c6ff00;
}
.icon-rss{
	background:#c6ff00;
}
.icon-popupnotify{
	background:#c6ff00;
}
.headingapp{
	font-weight: 700;
}

.moduleImage {
	border-radius: 5px;
	height: 40px;line-height: 50px;width: 50px;
}





  </style>
	<div class="listViewPageDiv detailViewContainer" id="moduleManagerContents">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<div id="listview-actions" class="listview-actions-container">
				<div class="clearfix">
					<h4 class="pull-left headingapp">{vtranslate('LBL_MODULE_MANAGER', $QUALIFIED_MODULE)}</h4>
					<div class="pull-right">
						<div class="btn-group">
							<button class="btn btn-default" type="button" onclick='window.location.href="{$IMPORT_USER_MODULE_FROM_FILE_URL}"'>
								{vtranslate('LBL_IMPORT_MODULE_FROM_ZIP', $QUALIFIED_MODULE)}
							</button>
						</div>&nbsp;
						<div class="btn-group">
							<button class="btn btn-default" type="button" onclick='window.location.href = "{$IMPORT_MODULE_URL}"'>
								{vtranslate('LBL_EXTENSION_STORE', 'Settings:ExtensionStore')}
							</button>
						</div>
					</div>
				</div>
				<br>
				<div class="contents">
					{assign var=COUNTER value=0}
					<table class="table table-bordered modulesTable">
						<tr>
							{foreach item=MODULE_MODEL key=MODULE_ID from=$ALL_MODULES}
								{assign var=MODULE_NAME value=$MODULE_MODEL->get('name')}
								{assign var=MODULE_ACTIVE value=$MODULE_MODEL->isActive()}
								{assign var=MODULE_LABEL value=vtranslate($MODULE_MODEL->get('label'), $MODULE_MODEL->get('name'))}
								{if $COUNTER eq 3}
								</tr><tr>
									{assign var=COUNTER value=0}
								{/if}
								<td class="ModulemanagerSettings">
									<div class="moduleManagerBlock">
										<span class="col-lg-1" style="line-height: 2.5;">
											<input type="checkbox" value="" name="moduleStatus" data-module="{$MODULE_NAME}" data-module-translation="{$MODULE_LABEL}" {if $MODULE_MODEL->isActive()}checked{/if} />
										</span>
										<span   style="" class="col-lg-1 moduleImage icon-{strtolower({$MODULE_NAME})}   {if !$MODULE_ACTIVE}dull {/if}">
										   <i  style="color: #fff;" class="vicon-{strtolower({$MODULE_NAME})}" title="{$MODULE_LABEL}"></i>
											{if vimage_path($MODULE_NAME|cat:'.png') != false}
											 
												 <!--<img class="alignMiddle" style="display:none" width="40" src="{vimage_path($MODULE_NAME|cat:'.png')}" alt="{$MODULE_LABEL}" title="{$MODULE_LABEL}"/> -->
											{else}
												<!--<img class="alignMiddle" style="display:none" width="40" src="{vimage_path('DefaultModule.png')}" alt="{$MODULE_LABEL}" title="{$MODULE_LABEL}"/> -->
											{/if}	
										</span>
										<span class="col-lg-5 moduleName {if !$MODULE_ACTIVE} dull {/if}"><h5 style="line-height: 0.5; font-weight: 700;">{$MODULE_LABEL}</h5></span>
											{assign var=SETTINGS_LINKS value=$MODULE_MODEL->getSettingLinks()}
											{if !in_array($MODULE_NAME, $RESTRICTED_MODULES_LIST) && (count($SETTINGS_LINKS) > 0)}
											<span class="col-lg-3 moduleblock">
												<span class="btn-group pull-right actions {if !$MODULE_ACTIVE}hide{/if}">
													<button class="btn btn-default btn dropdown-toggle unpin hiden " data-toggle="dropdown">
														{vtranslate('LBL_SETTINGS', $QUALIFIED_MODULE)}&nbsp;<i class="caret"></i>
													</button>
													<ul class="dropdown-menu pull-right dropdownfields">
														{foreach item=SETTINGS_LINK from=$SETTINGS_LINKS}
															{if $MODULE_NAME eq 'Calendar'}
																{if $SETTINGS_LINK['linklabel'] eq 'LBL_EDIT_FIELDS'}
																	<li><a href="{$SETTINGS_LINK['linkurl']}&sourceModule=Events">{vtranslate($SETTINGS_LINK['linklabel'], $MODULE_NAME, vtranslate('LBL_EVENTS',$MODULE_NAME))}</a></li>
																	<li><a href="{$SETTINGS_LINK['linkurl']}&sourceModule=Calendar">{vtranslate($SETTINGS_LINK['linklabel'], $MODULE_NAME, vtranslate('LBL_TASKS','Calendar'))}</a></li>
																{else if $SETTINGS_LINK['linklabel'] eq 'LBL_EDIT_WORKFLOWS'} 
																	<li><a href="{$SETTINGS_LINK['linkurl']}&sourceModule=Events">{vtranslate('LBL_EVENTS', $MODULE_NAME)} {vtranslate('LBL_WORKFLOWS','Vtiger')}</a></li>	
																	<li><a href="{$SETTINGS_LINK['linkurl']}&sourceModule=Calendar">{vtranslate('LBL_TASKS', 'Calendar')} {vtranslate('LBL_WORKFLOWS','Vtiger')}</a></li>
																{else}
																	<li><a href={$SETTINGS_LINK['linkurl']}>{vtranslate($SETTINGS_LINK['linklabel'], $MODULE_NAME)} {vtranslate($MODULE_NAME, $MODULE_NAME)}</a></li>
																{/if}
															{else}
																<li>
																	<a	{if stripos($SETTINGS_LINK['linkurl'], 'javascript:')===0}
																			onclick='{$SETTINGS_LINK['linkurl']|substr:strlen("javascript:")};'
																		{else}
																			onclick='window.location.href = "{$SETTINGS_LINK['linkurl']}"'
																		{/if}>
																		{vtranslate($SETTINGS_LINK['linklabel'],'Vtiger')} {vtranslate("SINGLE_$MODULE_NAME", $MODULE_NAME)}
																	</a>
																</li>
															{/if}
														{/foreach}
													</ul>
												</span>
											</span>
										{/if}
									</div>
									{assign var=COUNTER value=$COUNTER+1}
								</td>
							{/foreach}
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
{/strip}