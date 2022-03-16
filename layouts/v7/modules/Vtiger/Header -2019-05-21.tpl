{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************}
{strip}
<!DOCTYPE html>
<html>
	<head>
		<title>{vtranslate($PAGETITLE, $QUALIFIED_MODULE)}</title>
        <link rel="SHORTCUT ICON" href="layouts/v7/skins/images/favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<link type='text/css' rel='stylesheet' href='layouts/v7/lib/todc/css/bootstrap.min.css'>
		<link type='text/css' rel='stylesheet' href='layouts/v7/lib/todc/css/docs.min.css'>
		<link type='text/css' rel='stylesheet' href='layouts/v7/lib/todc/css/todc-bootstrap.min.css'>
		<link type='text/css' rel='stylesheet' href='layouts/v7/lib/font-awesome/css/font-awesome.min.css'>
    <link type='text/css' rel='stylesheet' href='layouts/v7/lib/jquery/select2/select2.css'>
    <link type='text/css' rel='stylesheet' href='layouts/v7/lib/select2-bootstrap/select2-bootstrap.css'>
        <link type='text/css' rel='stylesheet' href='libraries/bootstrap/js/eternicode-bootstrap-datepicker/css/datepicker3.css'>
        <link type='text/css' rel='stylesheet' href='layouts/v7/lib/jquery/jquery-ui-1.11.3.custom/jquery-ui.css'>
        <link type='text/css' rel='stylesheet' href='layouts/v7/lib/vt-icons/style.css'>
        <link type='text/css' rel='stylesheet' href='layouts/v7/lib/animate/animate.min.css'>
        <link type='text/css' rel='stylesheet' href='layouts/v7/lib/jquery/malihu-custom-scrollbar/jquery.mCustomScrollbar.css'>
        <link type='text/css' rel='stylesheet' href='layouts/v7/lib/jquery/jquery.qtip.custom/jquery.qtip.css'>
        <link type='text/css' rel='stylesheet' href='layouts/v7/lib/jquery/daterangepicker/daterangepicker.css'>
        
        
        
        <link rel="stylesheet" href="libraries/develop/modules.css" type="text/css" media="screen" />
        
        
        
        <input type="hidden" id="inventoryModules" value={ZEND_JSON::encode($INVENTORY_MODULES)}>
        
        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
        
        {assign var=V7_THEME_PATH value=Vtiger_Theme::getv7AppStylePath($SELECTED_MENU_CATEGORY)}
        <!--rtl ar_ae-->
		{if $LANGUAGE=="ar_ae"}
    <link type='text/css' rel='stylesheet' href='layouts/v7/resources/bootstrap.rtl.css'>
    <link href="https://fonts.googleapis.com/css?family=Changa&amp;subset=arabic" rel="stylesheet">
		<link type='text/css' rel='stylesheet' href='layouts/v7/resources/Solutions-time.css'>
		 
		 <style>
          .editViewContents .form-group .fieldLabel ,.form-horizontal .control-label ,.editViewContents .row .form-group .fieldLabel
                {
                    float: right !important;
                    text-align:right;
                }
                .settingsPageDiv .treeView {
                  float: right;
                }

                .editViewContents .form-group .fieldValue ,.form-horizontal .control-label ,.editViewContents .row .form-group .fieldValue
                {
                    float: right !important;
                    text-align:right;
                }
             
                ul.detailViewSetting.dropdown-menu {
                    right: -60px !important;
                }
                .dropdown.dashBoardDropDown.open .dropdown-menu.dropdown-menu-right.moreDashBoards
                {
                   right: -90px !important; 
                }
                div.btn-group.open ul.dropdown-menu.dropdown-menu-right.widgetsList.pull-right
                {
                    text-align:right;
                    right: 0px !important;
                }
                .listViewRecordActions .table-actions .more .dropdown-menu {
                    right: 0 !important;
                }
                
              #app-menu {
                position: fixed !important;
                }
             #modnavigator
             {
                position: fixed !important;
                top:80px;
             }
             div.date-picker-wrapper
             {
                 right: 0px !important;
             }
             
            .checkbox-inline input{
              margin-left: 3px !important
            }
            
            label.checkbox-inline input[type=checkbox]
            {
               margin-left: 3px !important;
            }
            div.checkbox label input[type=checkbox]
            {
               margin-left: 3px !important;
            }
            .quickCreateContent.calendarQuickCreateContent > .row
            {
                padding-right: 40px;
            }
            .quickCreateContent.calendarQuickCreateContent > .row >.col-sm-12 >.col-sm-5:first-child
            {
               float: right !important;
            }
            .quickCreateContent.calendarQuickCreateContent > .row > .col-sm-12 > .muted.col-sm-1
            {
               float: right;
            }
             .floaclass {
                float:right !important;
            }
           .aligntestclass {
               text-align:right !important;
           }
           .dt-buttons{
               float:left !important;
               
           }
           
          td .fieldValue .inputElement input[type="checkbox"] {
               background: #ddd !important;
            }
            
       .fieldValue input[type=radio],.fieldValue .radio input[type=radio],.fieldValue .radio-inline input[type=radio],.fieldValue input[type=checkbox],.fieldValue .checkbox input[type=checkbox],.fieldValue .checkbox-inline input[type=checkbox] {
            background: #eee !important;
        }
        .moduleManagerBlock .col-lg-1 { float: right; }
        .ulBlock .widgetContainer li a {
          padding-right: 30px;
        }
        .moduleManagerBlock .moduleName{
          float: right;
        }
        
       
        #appnav .nav li{
          float: right;
        }
        #advanceSearchContainer{
          float: right;
          width: 100%;
        }
        #overlayPage{
          direction: ltr;
          right: 0px;
        }
        #layoutEditorContainer #detailViewLayout .row{
          margin-left:0px !important;
        }
        .textAlignCenter{
          /*float: right !important;*/
        }
        .profileData.textAlignCenter{
          float: none !important;
        }
        #s2id_autogen3{
          float: right !important;
        }
        #layoutEditorContainer ul.nav>li{
          float: right;
        } 
        .massEditTabs.nav>li{
          float: right;
        }

        .quick-create-module{
          line-height: 30px;
        }
        .fieldValue input[type=radio], .fieldValue .radio input[type=radio], .fieldValue .radio-inline input[type=radio], .fieldValue input[type=checkbox], .fieldValue .checkbox input[type=checkbox], .fieldValue .checkbox-inline input[type=checkbox]{
              margin-left: 3px;
        }
        .profile-dropdown-menu{
          right: 0px !important;
          left:auto !important;
        }
        #profilePageHeader.textAlignCenter{
          float: none !important;
        }
        .profilesEditView.textAlignCenter{
          float: none !important;
        }
        
       .commentDetails .title{
        padding: 0px 0px 15px 15px !important;
       }
       .recentCommentsHeader h4{
        float: right;
       }

        body{ font-family: 'Changa', sans-serif;}
        .dropdown .dropdown-menu { text-align: right; }
        #searchResults-container .container-fluid{
          text-align: right;
          float: right;
          width: 90%;
        }

        #detailView .block {
        float: right;
       }

       /* Task Management */
       #taskManagementContainer .entries .task-body{

       }
       #taskManagementContainer .taskSubject.textOverflowEllipsis{
        text-align: right;
        padding-right: 5px;
       }
       
       #taskManagementContainer .task-details .taskDueDate{
            text-align: right;
       }
      #taskManagementContainer .task-details .taskDueDate i{
            float: right;
       }
       #taskManagementContainer .task-details .taskDueDate span{
            float: right;
            padding-right: 4px;
       }
       #taskManagementContainer .task-details [class^="related"]{
         display: block;
       }
       #taskManagementContainer .task-details [class^="related"] span:first-child{
         margin-left: 5px;
         float: right;
       }
       #taskManagementContainer .entries .task-details [class^="related"] .recordName{
          max-width: 90% !important;
          float: right;
       }
       #taskManagementContainer  .contentsBlock{
        direction: rtl;
       }
       #taskManagementContainer  .contentsBlock .input-group .taskSubject{
        z-index: 999000;
       }
       #taskManagementContainer  div .title{
        text-align: center;
        line-height: 2;
       }
       #taskManagementContainer .cursorPointerMove{
        float: right;
       }
       /* Eng Task Management */
       #relatedActivities .activityEntries .activityStatus .row{
        float: right;
       }
       /*setting Editor */
       .layoutBlockHeader .blockLabel{
        float: right !important;
       }
       .layoutBlockHeader .cursorPointerMove {
        float: right !important;
       }
       .layoutBlockHeader .translatedBlockLabel {
        float: right !important;
        padding-right: 5px;
       }

       .layoutBlockHeader .blockActions{
        float: right;
        padding-right: 5px;
       }
       .detailViewButtoncontainer .dropdown-menu.dropdown-menu-right{
       left:0 !important;
       }
       
       .layoutContent .editFields{
        border-left: 1px solid #DDDDDD !important;
        border-right: 1px solid #fff !important;
       }

       .recentComments .commentTime{
        float: right;
        padding-left: 20px;
       }
       #navbar li.dropdown >a {
            width: 60px;
            padding-top: 15px;
        }
        #navbar {
            margin-left: 100px;
        }
       
		</style>
		 
		{else}
		{if strpos($V7_THEME_PATH,".less")!== false}
            <link type="text/css" rel="stylesheet/less" href="{vresource_url($V7_THEME_PATH)}" media="screen" />
            <style type="text/css">
              #detailView .block {
              float: left;
             }
            </style>
        {else}
            <link type="text/css" rel="stylesheet" href="{vresource_url($V7_THEME_PATH)}" media="screen" />
            <style type="text/css">
              #detailView .block {
              float: left;
             }
            </style>
        {/if}
		   
		{/if}
        
        {foreach key=index item=cssModel from=$STYLES}
			<link type="text/css" rel="{$cssModel->getRel()}" href="{vresource_url($cssModel->getHref())}" media="{$cssModel->getMedia()}" />
		{/foreach}
		{* For making pages - print friendly *}
		<style type="text/css">
            @media print {
            .noprint { display:none; }
                
		}
		body {
		    font-size: 14px;
		    font-weight: bold;
		}
		.select2-container .select2-choice {
          font-weight: bold;
        }
        .active-app-title {
          font-weight: bold;
        }
        .module-action-bar .module-title {
        }
        strong,
        b,
        th {
            font-weight: bold;
        }
        .crumbs {
            font-weight: bold;
        }
        .updates_timeline > li .update_info h5 {
          font-weight: bold;
        }
        
        .updates_timeline > li .update_info > .updateInfoContainer .update-name {
            font-weight: bold;
        }
        .btn-group>.btn, .btn-group-vertical>.btn {
            font-weight: bold;
        }
        .dropdown-menu>li>a 
        {
           font-weight: bold; 
        }
        .module-buttons.btn {
            font-weight: bold;
        }
        .muted 
        {
          font-weight: bold !important;  
        }
        .app-menu .app-modules-dropdown li a .module-name {
            font-weight: bold;
        }
        .settingsgroup .panel-group {
            font-weight: bold;
        }
        #quickCreateModules .quick-create-module{
            font-weight: bold;
        }
        .editViewContents .fieldLabel {
            font-weight: bold !important;
        }
        .fieldLabel {
            font-weight: bold !important;
        }
        .listview-table > tbody > tr > td, .listview-table > tfoot > tr > td {
            font-weight: 100 !important;
        }
        #s2id_autogen5{
	    width: 100% !important;
       }
       #taskManagementContainer .entries .task-details{
           clear: both;
           float: inherit;
       }
       #taskManagementContainer .entries .task-details [class^="related"] .recordName{
          max-width: 90% !important;
       }
      
       .editViewContents .fieldBlockContainer, .summaryView {
              /* padding: 10px; */
          position: relative;
          border-radius: 10px;
          margin: 0 10px 20px 10px;
          background: #fff;
          box-shadow: 0 10px 29px 0 rgba(68, 88, 144, 0.1);
          transition: all 0.3s ease-in-out;
        }

        .summaryWidgetContainer{
          position: relative;
          border: 1px solid #F3F3F3;
          padding: 15px;
          margin-bottom: 10px;
          background: #FFFFFF;
          /* padding: 10px; */
          position: relative;
          border-radius: 10px;
          margin: 0 10px 15px 10px;
          background: #fff;
          box-shadow: 0 10px 29px 0 rgba(68, 88, 144, 0.1);
          transition: all 0.3s ease-in-out;
        }


        .detailview-header-block {
          padding: 10px;
          position: relative;
          border-radius: 10px;
          margin: 10px 10px 15px 10px;
          background: #fff;
          box-shadow: 0 10px 29px 0 rgba(171, 131, 131, 0.15);
          transition: all 0.3s ease-in-out;

        }
        .detailview-header{
          padding: 10px;
          background: #fff;
          transition: all 0.3s ease-in-out;
        }

       .related-tabs.row{
        padding: 10px;
        position: relative;
        border-radius: 10px;
        margin: 0 0px 15px 0px;
        background: #fff;
        box-shadow: 0 10px 29px 0 rgba(68, 88, 144, 0.1);
        transition: all 0.3s ease-in-out;
       }

       #detailView .block 
       { 
        padding: 10px;
        position: relative;
        border-radius: 10px;
        margin: 0 10px 15px 10px;
        background: #fff;
        box-shadow: 0 10px 29px 0 rgba(68, 88, 144, 0.1);
        transition: all 0.3s ease-in-out;
       }
       .relatedContainer{
        padding: 10px;
        position: relative;
        border-radius: 10px;
        margin: 0 10px 15px 10px;
        background: #fff;
        
       }
       .relatedContainer .relatedHeader{
         box-shadow: 0 10px 29px 0 rgba(68, 88, 144, 0.1);
        transition: all 0.3s ease-in-out;
       }
       .relatedContents .relatedContainer{
         box-shadow: 0 10px 29px 0 rgba(68, 88, 144, 0.1);
        transition: all 0.3s ease-in-out;

       }

       
        


       @media (min-width: 768px){
        #detailView .block {
        width: 48%;
       }
       .userPreferences #detailView .block {
        width: 98%;
       }
       #detailView .details.block {
        width: 97%;
       }

       
       .detailViewContainer .content-area{
        padding-top: 0px;
       }

       }/* end min-width:768;*/
       

       @media (max-width: 768px){
        #detailView .block {
        width: 100%;
       }
       }/* end max-width:768;*/

       .vicon-dashboard{ 
          color:#c41c00;
         } 
        .related-tabs .tab-icon .vicon-dashboard{ 
          color:#c41c00;
         }
         .numberCircle , .bg-red{
           border-radius: 50%; 
           background: none repeat scroll 0 0 #f3081e;
           padding: 3px 3px;
         }
         #addTagTriggerer{
             background: none repeat scroll 0 0 #f3081e;
         } 

         .taskDueDate .fa-calendar{
           color: #1de9b6;
         }
         #navbar .fa-calendar , .dateRange .fa-calendar{
           color: #1de9b6;
         }
         #navbar .fa-bar-chart{
          color:#c41c00;
         }
         #navbar .fa-user,.logo .fa-user ,.userDefaultIcon {
          color:orange;
         }

         .btn-default {
        color: #333;
        text-shadow: 0 1px rgba(0,0,0,.1);
        text-shadow: 0 1px 0 #fff;
        background-color: #f3f3f300;
        background-image: -webkit-linear-gradient(top,#f5f5f5 0,#f1f1f1 100%);
        background-image: -o-linear-gradient(top,#f5f5f5 0,#f1f1f1 100%);
        background-image: -webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));
        background-image: linear-gradient(to bottom,#f5f5f500 0,#f1f1f100 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff5f5f5', endColorstr='#fff1f1f1', GradientType=0);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        background-repeat: repeat-x;
        border: 1px solid #dcdcdc;
       }
       .related-tabs .nav-tabs>li.active, .related-tabs .nav-tabs>li:hover, .related-tabs .nav-tabs>li.active:focus, .dashBoardContainer .nav-tabs>li.active, .dashBoardContainer .nav-tabs>li:hover, .dashBoardContainer .nav-tabs>li.active:focus, .contents.tabbable .nav-tabs>li.active, .contents.tabbable .nav-tabs>li:hover, .contents.tabbable .nav-tabs>li.active:focus {
            border: none;
            border-bottom: 3px solid #f3081e;
        }
        
        .related-tabs .tab-icon .vicon-dashboard{ 
          color:#c41c00;
         }


        .vicon-trash{  color: #ff1744;  } 
         .vicon-chat{ color:#ff5722; } 
         .vicon-leads{ color:#d50000; } 
         .vicon-accounts { color:#c51162; } 
         .vicon-contacts{ color:#aa00ff; } 
         .vicon-campaigns { color:#6200ea; } 
         .vicon-quotes{ color:#304ffe; } 
         .vicon-products{ color:#0091ea; } 
         .vicon-services{ color:#00b8d4; } 
         .vicon-smsnotifier{ color:#00bfa5; } 
         .vicon-potentials{ color:#00c853; } 
         .vicon-assets{ color:#64dd17; } 
         .vicon-salesorder{ color:#aeea00; } 
         .vicon-invoice{ color:#ffd600; } 
         .vicon-vendors{ color:#ffab00; } 
         .vicon-pricebooks{ color:#ff6d00; } 
         .vicon-purchaseorder{ color:#dd2c00; } 
         .vicon-servicecontracts{ color:#880e4f; } 
         .vicon-projectmilestone{ color:#4a148c; } 
         .vicon-projecttask { color:#1a237e; } 
         .vicon-project{ color:#0d47a1; } 
         .vicon-helpdesk{ color:#006064; } 
         .vicon-faq{ color:#1b5e20; } 
         .vicon-pbxmanager{ color:#827717; } 
         .vicon-mailmanager{ color:#f57f17; } 
         .vicon-documents{ color:#e65100; } 
         .vicon-task{ color:#40c4ff; }
         .vicon-meeting{ color:#1de9b6; }
         .vicon-calendar{ color:#1de9b6; } 
         .vicon-emailtemplates{ color:#388e3c; } 
         .vicon-chat{ color:#ff4081; } 
         .vicon-call{ color:#00b0ff; } 
         .vicon-chart{ color:#ff5722; } 
         .vicon-reports{ color:#ff5722; } 
         .vicon-workday{ color:#a33108; } 
         .vicon-emails{ color:#f57f17; } 
         .vicon-portal{ color:#c6ff00; } 
         .vicon-webmails{ color:#388e3c; } 
         .vicon-google{ color:#c6ff00; } 
         .vicon-recyclebin{ color: #ff1744; } 
         .vicon-webforms{ color:#c6ff00; } 
         .vicon-rss{ color:#c6ff00; } 
         .vicon-popupnotify{ color:#c6ff00; } 
         /* 1234567890 */
         .detailview-header .bgdashboard{  background:#c41c00 !important; } 
        .detailview-header .bgtrash{  background: #ff1744 !important; } 
        .detailview-header .bgchat{ background:#ff5722 !important; } 
        .detailview-header .bgleads{ background:#d50000 !important; } 
        .detailview-header .bgaccounts { background:#c51162 !important; } 
        .detailview-header .bgcontacts{ background:#aa00ff !important; } 
        .detailview-header .bgcampaigns { background:#6200ea !important; } 
        .detailview-header .bgquotes{ background:#304ffe !important; } 
        .detailview-header .bgproducts{ background:#0091ea !important; } 
        .detailview-header .bgservices{ background:#00b8d4 !important; } 
        .detailview-header .bgsmsnotifier{ background:#00bfa5 !important; } 
        .detailview-header .bgpotentials{ background:#00c853 !important; } 
        .detailview-header .bgassets{ background:#64dd17 !important; } 
        .detailview-header .bgsalesorder{ background:#aeea00 !important; } 
        .detailview-header .bginvoice{ background:#ffd600 !important; } 
        .detailview-header .bgvendors{ background:#ffab00 !important; } 
        .detailview-header .bgpricebooks{ background:#ff6d00 !important; } 
        .detailview-header .bgpurchaseorder{ background:#dd2c00 !important; } 
        .detailview-header .bgservicecontracts{ background:#880e4f !important; } 
        .detailview-header .bgprojectmilestone{ background:#4a148c !important; } 
        .detailview-header .bgprojecttask { background:#1a237e !important; } 
        .detailview-header .bgproject{ background:#0d47a1 !important; } 
        .detailview-header .bghelpdesk{ background:#006064 !important; } 
        .detailview-header .bgfaq{ background:#1b5e20 !important; } 
        .detailview-header .bgpbxmanager{ background:#827717 !important; } 
        .detailview-header .bgmailmanager{ background:#f57f17 !important; } 
        .detailview-header .bgdocuments{ background:#e65100 !important; } 
        .detailview-header .bgtask{ background:#40c4ff !important; } 
        .detailview-header .bgcalendar{ background:#1de9b6 !important; } 
        .detailview-header .bgemailtemplates{ background:#388e3c !important; } 
        .detailview-header .bgchat{ background:#ff4081 !important; } 
        .detailview-header .bgcall{ background:#00b0ff !important; } 
        .detailview-header .bgchart{ background:#ff5722 !important; } 
        .detailview-header .bgreports{ background:#ff5722 !important; } 
        .detailview-header .bgworkday{ background:#a33108 !important; } 
        .detailview-header .bgemails{ background:#f57f17 !important; } 
        .detailview-header .bgportal{ background:#c6ff00 !important; } 
        .detailview-header .bgwebmails{ background:#388e3c !important; } 
        .detailview-header .bggoogle{ background:#c6ff00 !important; } 
        .detailview-header .bgrecyclebin{ background: #ff1744 !important; } 
        .detailview-header .bgwebforms{ background:#c6ff00 !important; } 
        .detailview-header .bgrss{ background:#c6ff00 !important; } 
        .detailview-header .bgpopupnotify{ background:#c6ff00 !important; }
        /* 234567890 */
        .bg-info-dashboard{  background-color:#c41c00 !important; } 
        .bg-info-trash{  background-color: #ff1744 !important; } 
        .bg-info-chat{ background-color:#ff5722 !important; } 
        .bg-info-leads{ background-color:#d50000 !important; } 
        .bg-info-accounts { background-color:#c51162 !important; } 
        .bg-info-contacts{ background-color:#aa00ff !important; } 
        .bg-info-campaigns { background-color:#6200ea !important; } 
        .bg-info-quotes{ background-color:#304ffe !important; } 
        .bg-info-products{ background-color:#0091ea !important; } 
        .bg-info-services{ background-color:#00b8d4 !important; } 
        .bg-info-smsnotifier{ background-color:#00bfa5 !important; } 
        .bg-info-potentials{ background-color:#00c853 !important; } 
        .bg-info-assets{ background-color:#64dd17 !important; } 
        .bg-info-salesorder{ background-color:#aeea00 !important; } 
        .bg-info-invoice{ background-color:#ffd600 !important; } 
        .bg-info-vendors{ background-color:#ffab00 !important; } 
        .bg-info-pricebooks{ background-color:#ff6d00 !important; } 
        .bg-info-purchaseorder{ background-color:#dd2c00 !important; } 
        .bg-info-servicecontracts{ background-color:#880e4f !important; } 
        .bg-info-projectmilestone{ background-color:#4a148c !important; } 
        .bg-info-projecttask { background-color:#1a237e !important; } 
        .bg-info-project{ background-color:#0d47a1 !important; } 
        .bg-info-helpdesk{ background-color:#006064 !important; } 
        .bg-info-faq{ background-color:#1b5e20 !important; } 
        .bg-info-pbxmanager{ background-color:#827717 !important; } 
        .bg-info-mailmanager{ background-color:#f57f17 !important; } 
        .bg-info-documents{ background-color:#e65100 !important; } 
        .bg-info-task{ background-color:#40c4ff !important; } 
        .bg-info-calendar{ background-color:#1de9b6 !important; } 
        .bg-info-emailtemplates{ background-color:#388e3c !important; } 
        .bg-info-chat{ background-color:#ff4081 !important; } 
        .bg-info-call{ background-color:#00b0ff !important; } 
        .bg-info-chart{ background-color:#ff5722 !important; } 
        .bg-info-reports{ background-color:#ff5722 !important; } 
        .bg-info-workday{ background-color:#a33108 !important; } 
        .bg-info-emails{ background-color:#f57f17 !important; } 
        .bg-info-portal{ background-color:#c6ff00 !important; } 
        .bg-info-webmails{ background-color:#388e3c !important; } 
        .bg-info-google{ background-color:#c6ff00 !important; } 
        .bg-info-recyclebin{ background-color: #ff1744 !important; } 
        .bg-info-webforms{ background-color:#c6ff00 !important; } 
        .bg-info-rss{ background-color:#c6ff00 !important; } 
        .bg-info-popupnotify{ background-color:#c6ff00 !important; } 

        .update_icon .update_image i { line-height: 33px;}
        .update_icon .update_image [class^="vicon-"],.update_icon .update_image [class*=" vicon-"]{
          color:#fff !important;
        }

        #app-menu [class^="vicon-"],#app-menu [class*=" vicon-"] {
          color:#fff !important;
        }
        .update_icon .update_image i [class^="vicon-"],.update_icon .update_image i [class*=" vicon-"]{
          color:#fff !important;
        }
        .modules-menu [class^="vicon-"],.modules-menu [class*=" vicon-"]{
          color:#fff !important;
        }
        .app-MARKETING  [class^="vicon-"],.app-MARKETING  [class*=" vicon-"]{
          color:#fff !important;
        }
        .app-SALES [class^="vicon-"],.app-SALES [class*=" vicon-"]{
          color:#fff !important;
        }
        .app-SUPPORT [class^="vicon-"],.app-SUPPORT [class*=" vicon-"]{
          color:#fff !important;
        }
        .app-INVENTORY [class^="vicon-"],.app-INVENTORY [class*=" vicon-"]{
          color:#fff !important;
        }
        .app-PROJECT [class^="vicon-"],.app-PROJECT [class*=" vicon-"]{
          color:#fff !important;
        }


		</style>
		<script type="text/javascript">var __pageCreationTime = (new Date()).getTime();</script>
		<script src="{vresource_url('layouts/v7/lib/jquery/jquery.min.js')}"></script>
		<script src="{vresource_url('layouts/v7/lib/jquery/jquery-migrate-1.0.0.js')}"></script>
		<script type="text/javascript">
			var _META = { 'module': "{$MODULE}", view: "{$VIEW}", 'parent': "{$PARENT_MODULE}", 'notifier':"{$NOTIFIER_URL}", 'app':"{$SELECTED_MENU_CATEGORY}" };
            {if $EXTENSION_MODULE}
                var _EXTENSIONMETA = { 'module': "{$EXTENSION_MODULE}", view: "{$EXTENSION_VIEW}"};
            {/if}
            var _USERMETA;
            {if $CURRENT_USER_MODEL}
               _USERMETA =  { 'id' : "{$CURRENT_USER_MODEL->get('id')}", 'menustatus' : "{$CURRENT_USER_MODEL->get('leftpanelhide')}", 
                              'currency' : "{$USER_CURRENCY_SYMBOL}", 'currencySymbolPlacement' : "{$CURRENT_USER_MODEL->get('currency_symbol_placement')}",
                          'currencyGroupingPattern' : "{$CURRENT_USER_MODEL->get('currency_grouping_pattern')}", 'truncateTrailingZeros' : "{$CURRENT_USER_MODEL->get('truncate_trailing_zeros')}"};
            {/if}
		</script>
		
		{* this is model popup *}
		<script type="text/javascript" src="libraries/develop/module-popup-ntfy.js"></script>
		{*Notificationd by haitham Ghanem*}
		<script type="text/javascript" src="libraries/develop/Notificationd.js"></script>
    <link rel="stylesheet" type="text/css" href="layouts/v7/resources/comme.css">
    <style type="text/css">
  .app-nav .module-action-bar {
    background-color: #fff;
    border-top: none;
    border-bottom: 1px solid #eee;
    box-shadow: 0 4px 2px -2px rgba(128, 128, 128, 0.22);
  }
.module-buttons.btn {
    padding: 5px 5px 6px 8px;
    margin: 0px;
    border-radius: 5px;
    border: 1px solid transparent;
    color: #666;
    background: #fff;
    margin-top: 5px;
}


.btn-success, .btn-success.disabled {
    background: #06d79c;
    border: 1px solid #06d79c;
    -webkit-box-shadow: 0 2px 2px 0 rgba(40, 190, 189, 0.14), 0 3px 1px -2px rgba(40, 190, 189, 0.2), 0 1px 5px 0 rgba(40, 190, 189, 0.12);
    box-shadow: 0 2px 2px 0 rgba(40, 190, 189, 0.14), 0 3px 1px -2px rgba(40, 190, 189, 0.2), 0 1px 5px 0 rgba(40, 190, 189, 0.12);
    -webkit-transition: 0.2s ease-in;
    -o-transition: 0.2s ease-in;
    transition: 0.2s ease-in;
}
.btn-success, .btn-success.disabled {
    background: #06d79c;
    border: 1px solid #06d79c;
    -webkit-box-shadow: 0 2px 2px 0 rgba(40, 190, 189, 0.14), 0 3px 1px -2px rgba(40, 190, 189, 0.2), 0 1px 5px 0 rgba(40, 190, 189, 0.12);
    box-shadow: 0 2px 2px 0 rgba(40, 190, 189, 0.14), 0 3px 1px -2px rgba(40, 190, 189, 0.2), 0 1px 5px 0 rgba(40, 190, 189, 0.12);
    -webkit-transition: 0.2s ease-in;
    -o-transition: 0.2s ease-in;
    transition: 0.2s ease-in;
}

.btn-primary, .btn-primary.disabled {
    background: #745af2;
    border: 1px solid #745af2;
    -webkit-box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
    box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
    -webkit-transition: 0.2s ease-in;
    -o-transition: 0.2s ease-in;
    transition: 0.2s ease-in;
}

.modal-header {
    padding: 5px 15px;
    background: #fff;
    color: #398bf7;
}
    </style>
		
	</head>
	 {assign var=CURRENT_USER_MODEL value=Users_Record_Model::getCurrentUserModel()}
	<body data-skinpath="{Vtiger_Theme::getBaseThemePath()}" data-language="{$LANGUAGE}" data-user-decimalseparator="{$CURRENT_USER_MODEL->get('currency_decimal_separator')}" data-user-dateformat="{$CURRENT_USER_MODEL->get('date_format')}"
          data-user-groupingseparator="{$CURRENT_USER_MODEL->get('currency_grouping_separator')}" data-user-numberofdecimals="{$CURRENT_USER_MODEL->get('no_of_currency_decimals')}" data-user-hourformat="{$CURRENT_USER_MODEL->get('hour_format')}"
          data-user-calendar-reminder-interval="{$CURRENT_USER_MODEL->getCurrentUserActivityReminderInSeconds()}">
	    	{* start popup-ntfy *}
	     <div id="dlg-pop-notify" style="display:none;" title="Popup Notification">
            <iframe id="frm-pop-notify" src="" style="border:0 none; width:100%; height:250px; max-height:600px;"
                onload="frm_pop_Load(this);" ></iframe>
	        </div>
          <div id="dlg-pop-cmnt2" title="Popup Comment Inbox" style="display:none;">
        <iframe id="frm-cmnt2-inbox" src="" style="border:0 none; width:100%; height:320px; max-height:600px;"></iframe>
           </div>
        <div id="dlg-load2" title="L O A D I N G ....." style="display:none;">
          <center><img src="/libraries/develop/res/loading03.gif" style="width:81px;" /></center>
          </div>
	{* end pop-popup-ntfy *}
            <input type="hidden" id="start_day" value="{$CURRENT_USER_MODEL->get('dayoftheweek')}" /> 
		<div id="page">
            <div id="pjaxContainer" class="hide noprint"></div>
            <div id="messageBar" class="hide"></div>