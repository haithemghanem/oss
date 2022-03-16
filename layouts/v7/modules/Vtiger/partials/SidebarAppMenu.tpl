{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}

<div class="app-menu hide" id="app-menu">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 col-xs-2 cursorPointer app-switcher-container">
                <div class="row app-navigator">
                    <span id="menu-toggle-action" class="app-icon fa fa-bars"></span>
                </div>
            </div>
        </div>
        {assign var=USER_PRIVILEGES_MODEL value=Users_Privileges_Model::getCurrentUserPrivilegesModel()}
        {assign var=HOME_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Home')}
        {assign var=DASHBOARD_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Dashboard')}
        <div class="app-list row">

            {if $USER_PRIVILEGES_MODEL->hasModulePermission($DASHBOARD_MODULE_MODEL->getId())}
                <div class="menu-item app-item dropdown-toggle" data-default-url="{$HOME_MODULE_MODEL->getDefaultUrl()}">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa fa-dashboard"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('LBL_DASHBOARD',$MODULE)}</span>
                    </div>
                </div>
            {/if}
            {assign var=APP_GROUPED_MENU value=Settings_MenuEditor_Module_Model::getAllVisibleModules()}
            {assign var=APP_LIST value=Vtiger_MenuStructure_Model::getAppMenuList()}
            {foreach item=APP_NAME from=$APP_LIST}
                {if $APP_NAME eq 'ANALYTICS'} {continue}{/if}
                {if count($APP_GROUPED_MENU.$APP_NAME) gt 0}
                 <!--   <div class="dropdown app-modules-dropdown-container">
                        {foreach item=APP_MENU_MODEL from=$APP_GROUPED_MENU.$APP_NAME}
                            {assign var=FIRST_MENU_MODEL value=$APP_MENU_MODEL}
                            {if $APP_MENU_MODEL}
                                {break}
                            {/if}
                        {/foreach}

                        <div class="menu-item app-item dropdown-toggle app-item-color-{$APP_NAME}" data-app-name="{$APP_NAME}" id="{$APP_NAME}_modules_dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-default-url="{$FIRST_MENU_MODEL->getDefaultUrl()}&app={$APP_NAME}">
                            <div class="menu-items-wrapper app-menu-items-wrapper">
                                <span class="app-icon-list fa {$APP_IMAGE_MAP.$APP_NAME}"></span>
                                <span class="app-name textOverflowEllipsis"> {vtranslate("LBL_$APP_NAME")}</span>
                                <span class="fa fa-chevron-right pull-right"></span>
                            </div>
                        </div>

                        <ul class="dropdown-menu app-modules-dropdown" aria-labelledby="{$APP_NAME}_modules_dropdownMenu">
                            {foreach item=moduleModel key=moduleName from=$APP_GROUPED_MENU[$APP_NAME]}
                                {assign var='translatedModuleLabel' value=vtranslate($moduleModel->get('label'),$moduleName )}
                                <li>
                                    <a href="{$moduleModel->getDefaultUrl()}&app={$APP_NAME}" title="{$translatedModuleLabel}">
                                        <span class="module-icon">{$moduleModel->getModuleIcon()}</span>
                                        <span class="module-name textOverflowEllipsis"> {$translatedModuleLabel}</span>
                                    </a>
                                </li>
                            {/foreach}
                            
                        </ul>
                    </div> -->
                {/if}
            {/foreach}


            
            <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Invoice&amp;view=List&amp;app=INVENTORY">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list vicon-invoice"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Invoice')}</span>
                    </div>
                </div>


              <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Contacts&amp;view=List&amp;app=INVENTORY">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list vicon-contacts"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Contacts')}</span>
                    </div>
                </div>
                
                
                

               

            <!--<div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Accounts&amp;view=List&amp;app=INVENTORY">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list vicon-accounts"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Accounts')}</span>
                    </div>
                </div>-->




            <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Vendors&view=List&app=INVENTORY">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list vicon-vendors"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Vendors')}</span>
                    </div>
                </div>


            
            <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Services&amp;view=List&amp;app=INVENTORY">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list vicon-services"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Services')}</span>
                    </div>
                </div>
                
            <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Mandub&amp;view=List&amp;app=INVENTORY">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list vicon-vendors3"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Mandub','Mandub')}</span>
                    </div>
            </div>
          
           <!-- <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=PriceBooks&view=List&app=INVENTORY">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list vicon-pricebooks"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('PriceBooks')}</span>
                    </div>
                </div> -->


            <div class="app-list-divider"></div>
            {if $USER_MODEL->get('user_name') eq 'admin' } {/if}
                 
            <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Invoice&view=CarriersReport2">
                    <div class="menu-items-wrapper"> 
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('car report' ,'Invoice')}</span>
                    </div>
            </div>
            
            <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Invoice&view=CarriersReport3">
                    <div class="menu-items-wrapper"> 
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis">سيارات الرياض</span>
                    </div>
            </div>
                
            {if $USER_MODEL->isAdminUser() or $USER_MODEL->get('user_name') eq 'admin' }  
            
             <div class="dropdown app-modules-dropdown-container dropdown-compact">
                 <div class="menu-item app-item dropdown-toggle app-item-misc" data-app-name="TOOLS" id="TOOLS_modules_dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <div class="menu-items-wrapper app-menu-items-wrapper">
                        <span class="app-icon-list fa fa-ellipsis-h"></span>
                        <span class="app-name textOverflowEllipsis">المزيد من التقارير</span>
                        <span class="fa fa-chevron-right pull-right"></span>
                    </div>
                </div>
                 
                 <ul class="dropdown-menu app-modules-dropdown dropdown-modules-compact" aria-labelledby="TOOLS_modules_dropdownMenu" data-height="0.34">
                    
                    <li>
                            <a href="index.php?module=Reports&view=Costzones">
                                <span class="app-icon-list fa fa-bar-chart"></span>
                                <span class="module-name textOverflowEllipsis"> تقرير تكلفة المناطق</span>
                            </a>
                    </li>
                    
                    
                    
                     <li>
                            <a href="index.php?module=Reports&view=CustodyReport">
                                <span class="app-icon-list  fa fa-bar-chart"></span>
                                <span class="module-name textOverflowEllipsis">تقرير العهد</span>
                            </a>
                    </li>
                    
                    <li>
                            <a href="index.php?module=Reports&view=MandoubReport">
                                <span class="app-icon-list  fa fa-bar-chart"></span>
                                <span class="module-name textOverflowEllipsis">تقرير المندوب</span>
                            </a>
                    </li>
                    
                    <li>
                            <a href="index.php?module=Reports&view=ContactsReportA4"> 
                                <span class="app-icon-list  fa fa-bar-chart"></span>
                                <span class="module-name textOverflowEllipsis">تقرير العقود A4</span>
                            </a>
                    </li>
                    
                    <li>
                            <a href="index.php?module=Home&view=History">
                                <span class="app-icon-list  fa fa-calendar"></span>
                                <span class="module-name textOverflowEllipsis">أرشيف المستخدمين</span>
                            </a>
                    </li>
                    
                    
                    
                </ul>
                </div>
                
            <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Reports&view=CarrsReports">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis"> تقرير الحملات </span>
                    </div>
                </div>

                <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Reports&view=BranchReports">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis">تقرير الفرع</span>
                    </div>
                </div>
                
                <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Reports&view=RevenueReports">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis">تقرير الايرادات</span>
                    </div>
                </div>
                
                <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Reports&view=ContractsReportStatus">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis">تقرير حالة الاستلام</span>
                    </div>
                </div>
                
                

                {/if}

            <!--    <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Reports&view=CompanyReport">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Company Report')}</span>
                    </div>
                </div>

                <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Reports&view=ContactsReport">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Contacts Report')}</span>
                    </div>
                </div>-->
                
                
                
                
                
                <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Invoice&view=ContractsReport">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Contracts Report')}</span>
                    </div>
                </div> 
                
                <div class="menu-item app-item dropdown-toggle" data-default-url="index.php?module=Invoice&view=ShipmentReport">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa fa-bar-chart"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Shipment Report')}</span>
                    </div>
                </div> 
                
                 
                
                 {if $USER_MODEL->isAdminUser() or $USER_MODEL->get('user_name') eq 'admin'}
                
                
                
                 
                 
                 
                 {/if}
                
                {if $USER_MODEL->isAdminUser()}
                <div class="dropdown app-modules-dropdown-container dropdown-compact">
                    <div class="menu-item app-item dropdown-toggle app-item-misc" data-app-name="TOOLS" id="TOOLS_modules_dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-default-url="{if $USER_MODEL->isAdminUser()}index.php?module=Vtiger&parent=Settings&view=Index{else}index.php?module=Users&view=Settings{/if}">
                        <div class="menu-items-wrapper app-menu-items-wrapper">
                            <span class="app-icon-list fa fa-cog"></span>
                            <span class="app-name textOverflowEllipsis"> {vtranslate('LBL_SETTINGS', 'Settings:Vtiger')}</span>
                            {if $USER_MODEL->isAdminUser()}
                                <span class="fa fa-chevron-right pull-right"></span>
                            {/if}
                        </div>
                    </div>
                    <ul class="dropdown-menu app-modules-dropdown dropdown-modules-compact" aria-labelledby="{$APP_NAME}_modules_dropdownMenu" data-height="0.27">
                        <li>
                            <a href="?module=Vtiger&parent=Settings&view=Index">
                                <span class="fa fa-cog module-icon"></span>
                                <span class="module-name textOverflowEllipsis"> {vtranslate('LBL_CRM_SETTINGS','Vtiger')}</span>
                            </a>
                        </li>
                        <li>
                            <a href="?module=Users&parent=Settings&view=List">
                                <span class="fa fa-user module-icon"></span>
                                <span class="module-name textOverflowEllipsis"> {vtranslate('LBL_MANAGE_USERS','Vtiger')}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            {/if}


            
            {assign var=MAILMANAGER_MODULE_MODEL value=Vtiger_Module_Model::getInstance('MailManager')}
            {if $USER_PRIVILEGES_MODEL->hasModulePermission($MAILMANAGER_MODULE_MODEL->getId())}
            
                <!--<div class="menu-item app-item app-item-misc" data-default-url="index.php?module=MailManager&view=List">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa">{$MAILMANAGER_MODULE_MODEL->getModuleIcon()}</span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('MailManager')}</span>
                    </div>
                </div>-->
            {/if}
            
            <div class="menu-item app-item app-item-misc" data-default-url="index.php?module=PopUpNotify&view=List">
                     <!-- <div class="menu-items-wrapper">
                        <span class="fa fa-flag  module-icon"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Advanced Popup')}</span>
                    </div> -->
                </div>
            {assign var=DOCUMENTS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Documents')}
            {if $USER_PRIVILEGES_MODEL->hasModulePermission($DOCUMENTS_MODULE_MODEL->getId())}
                <div class="menu-item app-item app-item-misc" data-default-url="index.php?module=Documents&view=List">
                    <div class="menu-items-wrapper">
                        <span class="app-icon-list fa">{$DOCUMENTS_MODULE_MODEL->getModuleIcon()}</span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate('Documents')}</span>
                    </div>
                </div>
            {/if}
            {if $USER_MODEL->isAdminUser()}
                {if vtlib_isModuleActive('ExtensionStore')}
                    <!--<div class="menu-item app-item app-item-misc" data-default-url="index.php?module=ExtensionStore&parent=Settings&view=ExtensionStore">
                        <div class="menu-items-wrapper">
                            <span class="app-icon-list fa fa-shopping-cart"></span>
                            <span class="app-name textOverflowEllipsis"> {vtranslate('LBL_EXTENSION_STORE', 'Settings:Vtiger')}</span>
                        </div>
                    </div>-->
                {/if}
            {/if}
            <div class="dropdown app-modules-dropdown-container dropdown-compact">
                {foreach item=APP_MENU_MODEL from=$APP_GROUPED_MENU.$APP_NAME}
                    {assign var=FIRST_MENU_MODEL value=$APP_MENU_MODEL}
                    {if $APP_MENU_MODEL}
                        {break}
                    {/if}
                {/foreach}
                <div class="menu-item app-item dropdown-toggle app-item-misc" data-app-name="TOOLS" id="TOOLS_modules_dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <div class="menu-items-wrapper app-menu-items-wrapper">
                        <span class="app-icon-list fa fa-ellipsis-h"></span>
                        <span class="app-name textOverflowEllipsis"> {vtranslate("LBL_MORE")}</span>
                        <span class="fa fa-chevron-right pull-right"></span>
                    </div>
                </div>
                <ul class="dropdown-menu app-modules-dropdown dropdown-modules-compact" aria-labelledby="{$APP_NAME}_modules_dropdownMenu" data-height="0.34">
                    {assign var=EMAILTEMPLATES_MODULE_MODEL value=Vtiger_Module_Model::getInstance('EmailTemplates')}
                    {if $EMAILTEMPLATES_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($EMAILTEMPLATES_MODULE_MODEL->getId())}
                        <li>
                            <a href="{$EMAILTEMPLATES_MODULE_MODEL->getDefaultUrl()}">
                                <span class="fa module-icon">{$EMAILTEMPLATES_MODULE_MODEL->getModuleIcon()}</span>
                                <span class="module-name textOverflowEllipsis"> {vtranslate($EMAILTEMPLATES_MODULE_MODEL->getName(), $EMAILTEMPLATES_MODULE_MODEL->getName())}</span>
                            </a>
                        </li>
                    {/if}
                    {assign var=RECYCLEBIN_MODULE_MODEL value=Vtiger_Module_Model::getInstance('RecycleBin')}
                    {if $RECYCLEBIN_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($RECYCLEBIN_MODULE_MODEL->getId())}
                      <!--  <li>
                            <a href="{$RECYCLEBIN_MODULE_MODEL->getDefaultUrl()}">
                                <span class="fa fa-trash module-icon"></span>
                                <span class="module-name textOverflowEllipsis"> {vtranslate('Recycle Bin')}</span>
                            </a>
                        </li> -->
                    {/if}
                    {assign var=RSS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Rss')}
                    {if $RSS_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($RSS_MODULE_MODEL->getId())}
                        <!--<li>
                            <a href="index.php?module=Rss&view=List">
                                <span class="fa fa-rss module-icon"></span>
                                <span class="module-name textOverflowEllipsis">{vtranslate($RSS_MODULE_MODEL->getName(), $RSS_MODULE_MODEL->getName())}</span>
                            </a>
                        </li>-->
                    {/if}
                    {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Portal')}
                    {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}
                        <!--<li>
                            <a href="index.php?module=Portal&view=List">
                                <span class="fa fa-desktop module-icon"></span>
                                <span class="module-name textOverflowEllipsis"> {vtranslate('Portal')}</span>
                            </a>
                        </li>-->
                    {/if}
                    
                </ul>
            </div>
            
        </div>

    </div>
</div>
