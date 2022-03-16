{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}

<footer class="app-footer">
	<p>
		Powered by Solutions Time &nbsp;&nbsp;© 2017 - {date('Y')}&nbsp;&nbsp;
		<a href="https://solutions-time.com" target="_blank">AL-OSTORAH</a>&nbsp;|&nbsp;
		<a href="https://solutions-time.com" target="_blank">Privacy Policy</a>
	</p>
</footer>
</div>
<div id='overlayPage'>
	<!-- arrow is added to point arrow to the clicked element (Ex:- TaskManagement), 
	any one can use this by adding "show" class to it -->
	<div class='arrow'></div>
	<div class='data'>
	</div>
</div>
<div id='helpPageOverlay'></div>
<div id="js_strings" class="hide noprint">{Zend_Json::encode($LANGUAGE_STRINGS)}</div>
<div id="customemodule" class="modal myModal fade"></div>
<script src="layouts/v7/resources/sortcode.js"></script>
{include file='JSResources.tpl'|@vtemplate_path}



<script>

jQuery('#customemodule').on('show.bs.modal', function (event) {
    var tobro = $('[name="cf_950"]').val();
    if("" != "tobro"){
        $('[name="cf_972"]').val(tobro);
        $('[name="cf_972"]').trigger('change');
    }
});

jQuery(document).on('keydown', function (e) {
     if (e.key === 'Alt') {
        e.preventDefault();
        
        var leqinput  = $('.myModal').find('input[type=text]').filter(':visible:first').length;
        var lefilter = $('#popupModal tr.searchRow').find('input[type=text]').filter(':visible:first').length;
        
        if(leqinput > 0){
            $('.myModal').find('input[type=text]').filter(':visible:first').focus();
        }
        if(lefilter > 0){
             $('#popupModal tr.searchRow').find('input[type=text]').filter(':visible:first').focus();
        }
            
        // var lengh = $(".myModal #Contacts_editView_fieldName_firstname").length;
        // var lengt_vendername=$(".myModal #Vendors_editView_fieldName_vendorname").length;
        // var bookname_lenght= $("tr.searchRow [name='bookname']").length;
        // var firnam_lenght = $("tr.searchRow [name='firstname']").length;
        // var vendorname_lenght = $("tr.searchRow [name='vendorname']").length;
        
        // if (lengh > 0){
        //      $(".myModal #Contacts_editView_fieldName_firstname").focus();
        //  }else if(lengt_vendername>0){
        //      $(".myModal #Vendors_editView_fieldName_vendorname").focus();
        //  }else if(firnam_lenght > 0){
        //      $("tr.searchRow [name='firstname']").focus();
        //  }else if(vendorname_lenght > 0){
        //      $("tr.searchRow [name='firstname']").focus();
        //  }
         
        //  if(bookname_lenght > 0){
        //      $("tr.searchRow [name='bookname']").focus();
        //  }

    } 
 });
        
$("#starToggle").css("display" , "none");
$(document).ready(function(){
  $("#chargeTaxes").closest("tr").css("display", "none");
  $("#deductTaxes").closest("tr").css("display" , "none");
  $("#taxesOnChargesList").closest("tr").css("display" , "none");
  $("#deductedTaxesList").closest("tr").css("display" , "none");
 
});



$.Shortcuts.add({
    type: 'down',
    mask: 'F1',
    handler: function() {
         //console.log("F1 pressed");
         //jQuery("#menubar_quickCreate_Events").click();
         //window.open(urlex, '_blank');
        window.location.href = "index.php?module=Invoice&view=Edit&app=INVENTORY";
    }
});
$.Shortcuts.add({
    type: 'down',
    mask: 'F2',
    handler: function() {
         window.location.href = "index.php?module=Contacts&view=Edit&app=INVENTORY";
    }
});
$.Shortcuts.add({
    type: 'down',
    mask: 'F3',
    handler: function() {
        window.location.href = "index.php?module=Vendors&view=Edit&app=INVENTORY";
        }
});
$.Shortcuts.add({
    type: 'down',
    mask: 'F4',
    handler: function() {
        window.location.href = "index.php?module=Services&view=Edit&app=INVENTORY";
    }
});
$.Shortcuts.add({
    type: 'down',
    mask: 'F5',
    handler: function() {
        window.location.href = "index.php?module=PriceBooks&view=Edit&app=INVENTORY";
    }
});
$.Shortcuts.add({
    type: 'down',
    mask: 'F6',
    handler: function() {
        window.location.href = "index.php?module=Reports&view=ContractsReport";
    }
});
$.Shortcuts.add({
    type: 'down',
    mask: 'F7',
    handler: function() {
        window.location.href ="index.php?module=Reports&view=ShipmentReport";
    }
});

 $.Shortcuts.add({
    type: 'down',
    mask: 'Ctrl+a',
    handler: function(e) {
    e.preventDefault();
    $("#Invoice_editView_fieldName_cf_944_create").click();
     $("#addService").focus();
    }
});


$.Shortcuts.add({
    type: 'down',
    mask: 'Ctrl+x',
    handler: function(e) {
    e.preventDefault();
    $("#Invoice_editView_fieldName_subject").focus();
    }
});

$.Shortcuts.add({
    type: 'down',
    mask: 'Ctrl+q',
    handler: function(e) {
    e.preventDefault();
    $("#Invoice_editView_fieldName_cf_987").focus();
    }
});

$.Shortcuts.add({
    type: 'down',
    mask: 'Enter', //Alt,Shift,Enter,Ctrl,Ctrl+Alt
    handler: function(e) {
    e.preventDefault();
    $("#EditView").submit();
    }
});


$.Shortcuts.start();

//  setInterval(function(){
//   var  rey= $.ajax({
//   url: "https://alostora.net/vtigercron.php",
//  })
//  }, 50000);


 
 


</script>
</body>

</html>