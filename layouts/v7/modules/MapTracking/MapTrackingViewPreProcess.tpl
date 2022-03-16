{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is: vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}
{include file="modules/Vtiger/partials/Topbar.tpl"}
{strip}
<div class="container-fluid app-nav">
	<div class="row">
<div class="col-sm-12 col-xs-12 app-indicator-icon-container app-{$SELECTED_MENU_CATEGORY}">
	<div class="row" title="Map Tracking">
		<span class="app-indicator-icon fa fa-map-marker"></span>
	</div>
</div>

{include file="modules/Vtiger/partials/SidebarAppMenu.tpl"}
<div class="col-sm-12 col-xs-12 module-action-bar clearfix">
			<div class="module-action-content clearfix coloredBorderTop">
				<div class="col-lg-5 col-md-5">
					<span>
						{assign var="VIEW_HEADER_LABEL" value="MapTracking"}
						{if $VIEW === 'Run'}
							{assign var="VIEW_HEADER_LABEL" value="MapRun"}
						 {elseif $VIEW === 'UserTracking'}
						  {assign var="VIEW_HEADER_LABEL" value="UserTracking"}
						{/if}
						<a href='javascript:void(0)'><h4 class="module-title pull-left"><span style="cursor: default;"> {strtoupper(vtranslate($VIEW_HEADER_LABEL, $MODULE))} </span></h4></a>
					</span>
				</div>
			  </div>
			</div>
	</div>
</div>
</nav>
	<div id='overlayPageContent' class='fade modal overlayPageContent content-area overlay-container-60' tabindex='-1' role='dialog' aria-hidden='true'>
		<div class="data">
		</div>
		<div class="modal-dialog">
		</div>
	</div>
	<div class="main-container">
		<div id="modnavigator" class="module-nav calendar-navigator clearfix">
			<div class="hidden-xs hidden-sm mod-switcher-container">

			<div id="modules-menu" class="modules-menu">
				<ul>
				   <li class="module-qtip {if $VIEW eq 'Run'}active{/if}" title="User view">
						<a href="index.php?module=MapTracking&view=Run">
							<i class="fa fa-map"></i>
							<span>User</span>
						</a>
					</li>
					<li class="module-qtip {if $VIEW eq 'UserTracking'}active{/if}" title="User view">
						<a href="index.php?module=MapTracking&view=UserTracking">
							<i class="fa fa-users"></i>
							<span>UserTracking</span>
						</a>
					</li>
				</ul>
			</div>
				
			</div>
		</div>
		
		
{/strip}
