<?php
/*111*/
class PopUpNotify_AllList_View extends Vtiger_Index_View {

        public function process(Vtiger_Request $request) {
                $viewer = $this->getViewer($request);
				$viewer->view('List.tpl', $request->getModule());

                 $curr_user = Users_Record_Model::getCurrentUserModel();
				 $userName = $curr_user->get('user_name');
				 $userIsAdmin = $curr_user->get('is_admin');  //on / off
				 $_SESSION['module_user_id'] = $curr_user->get('id');
				 $_SESSION['module_user_isadmin'] = ($userIsAdmin == 'on' ? 1 : 0);
                
				/*  Comment admin condition
				if($userIsAdmin == 'off'){
				    echo '<br/><br/>لا يوجد سماحية لإظهار هذه الصفحة<br/><br/>No Permission...<br/><br/>';
				    exit(0);
                }
                else  */ 
                
require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $adb;
$result = $adb->pquery("Select Count(*) pop_cnt From tblPopupNotify ");
$pop_cnt = $adb->query_result($result,$i,'pop_cnt');

?>
<div style="padding: 40px;">

  <div class="col-md-12">
     
     <div  class="col-md-6" > <h2>Popup Notification:</h2>  </div>
      <div  class="col-md-6" >
      <a href="index.php?module=PopUpNotify&view=List"  class="btn btn-default pull-right" > View Mine</a>
      </div>
      
  </div>
 <div id="showuser" title="Users">
</div>
<div id="dlg-load" title="L O A D I N G ....." style="display:none;">
    <center><img src="/libraries/develop/res/loading03.gif" style="width:81px;" /></center>
</div>
<div id="dlg-users" title="Select a user" style="display:none;">
	<p>Select a user:</p>
	<select id='cmbSelUsers'>
<?
    $pop_selusers = $adb->pquery("Select id, first_name ,last_name From vtiger_users");
    $pop_selusers_count = $adb->num_rows($pop_selusers);
    for($k=0; $k < $pop_selusers_count; $k++){
        $user_id = $adb->query_result($pop_selusers,$k,'id');
        $first_name = $adb->query_result($pop_selusers,$k,'first_name');
        $last_name = $adb->query_result($pop_selusers,$k,'last_name');
        $user_name=$first_name .' '.$last_name;
       // $user_name = $adb->query_result($pop_selusers,$k,'user_name');
        echo '  <option value="'. $user_id .'">'. $user_name .'</option>';
    }

?>
	</select>
</div>
<div style="padding: 40px;">
<div id="dlg-pop-editor" title="Popup Notify" style="display:none;">
    <div class="dv-pop-card" id="dv-pop-editor" >
        <div class="dv-col1" style="width: 100%;">
            <span class="entry-title" style="margin-bottom: 11px;">Popup ID: </span>
            <span class="entry-value" id="pop-entry-id">XXX</span>
            <br />
            <span class="entry-title">Title: </span>
            <input type="textbox" class="entry-value" id="pop-entry-title" />
            <br />
            <span class="entry-title">Show on login?: </span>
            <input type="checkbox" id="pop-entry-chk-onlogin" style="margin: 6px 15px 18px 15px;" onclick="chkOnlogin_Click(this);" />
            <br />
            <span class="entry-title">Date: </span>
            <input type="textbox" class="entry-value" id="pop-entry-date" placeholder="dd-mm-yyyy" readonly='true' style="cursor: text;" />
            <br />
            <span class="entry-title">Message: </span>
            <textarea class="entry-value" id="pop-entry-msg" rows="5" style="width:220px;" ></textarea>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>

<div id="dlg-pop-cmnt" title="Popup Comment Inbox" style="display:none;">
    <iframe id="frm-cmnt-inbox" src="" style="border:0 none; width:100%; height:320px; max-height:600px;"></iframe>
</div>

</div>

<link type="text/css" rel="stylesheet" href="/libraries/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
            <link type="text/css" rel="stylesheet" href="/libraries/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">
                  <div class="">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                           <th>id</th>
                          <th>Action</th>
                          <th>Title</th>
                          <th>Contact</th>
                          <th>Assigned To</th>
                        
                        </tr>
                      </thead>
                      <tfoot id="minmn">
                        <tr>
                          <th></th>
                          <th></th>
                          <th class="ok">Title</th>
                          <th class="ok">Contact</th>
                          <th class="ok">Users</th>
                        </tr>
                      </tfoot>


                      <tbody>
                          
                          <?php
                          
 $dbquery="select * from tblPopupNotify WHERE (owner_id !='' or owner_id !=null) AND  pop_title !='' order by id DESC LIMIT 200";
$result = $adb->pquery($dbquery, array());
$count = $adb->num_rows($result);

for($i=0; $i < $count; $i++){
    $pid = $adb->query_result($result,$i,'id');
    $pop_title = $adb->query_result($result,$i,'pop_title');
    $pop_text = $adb->query_result($result,$i,'pop_text');
    $pop_date = $adb->query_result($result,$i,'pop_date');
    $pop_date_str = (($pop_date) ? str_replace(" 00:00:00", "", $pop_date) : "null-dt");
    $pop_minutes = $adb->query_result($result,$i,'pop_minutes');
    $owner_id=$adb->query_result($result,$i,'owner_id');
    
    $ass_selusers = $adb->pquery("Select id,first_name ,last_name From vtiger_users WHERE id='".$owner_id."'");
    
    $first_name = $adb->query_result($ass_selusers,0,'first_name');
    $last_name = $adb->query_result($ass_selusers,0,'last_name');
    $Name_user=$first_name .' '.$last_name;
    echo '
    <tr>
      <th>'.$i.'</th>
                           <td>
                            <span  Style="padding: 5px;" class="sp-tool2 sp-notes" onclick="spCommentInbox_Click('. $pid .');" title="Open comment inbox for this popup">
                            <i title="Unlink" class="fa fa-comment"></i>
                            </span>

                             
                            
            </td>           
                           <td>'.$pop_title.'</td>
                           <td>'.$pop_text.'</td>
                           <td>'.$Name_user.'</td>
                          ';
                         
    
    }
    ?>
   </tbody>
 </table> 
 


     <!-- Datatables -->
                  <script src="/libraries/datatables.net/js/jquery.dataTables.min.js"></script>
                  <script src="/libraries/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
                  <script src="/libraries/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/buttons.html5.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/buttons.print.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/buttons.html5.min.js"></script>
                  <script src="/libraries/datatables.net-buttons/js/buttons.colVis.js"></script>
                  
                  
             
              
              <script>
             $(document).ready(function() {
          var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
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
                    columns: ':visible'
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
     $("#datatable-buttons tfoot").css({"display":"table-header-group"});
     $('#datatable-buttons tfoot .ok').each( function (){
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder=" Search in '+title+'" />' );
    });

        var table = $('#datatable-buttons').DataTable();
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
    </script>
	<script type="text/javascript">
	    function spAdd_Click(){
            $("#dv-pop-editor").data("popid", 0);
            $("#pop-entry-id").text("New");
            $("#pop-entry-title").val("");
            $("#pop-entry-date").val("");
            $("#pop-entry-date").data("prev-date", "0");  //this is not used when add new popup
            $("#pop-entry-msg").val("");
            $("#pop-entry-chk-onlogin")[0].checked = false;
            chkOnlogin_Click($("#pop-entry-chk-onlogin")[0]);
	    	$("#dlg-pop-editor").dialog("open");

	    }
	    function spEdit_Click(pid){
            $("#dv-pop-editor").data("popid", pid);
            $("#pop-entry-id").text(pid);
            $("#pop-entry-title").val($("#pop-title" + pid).text());
            $("#pop-entry-msg").val($("#pop-text" + pid).text());
            $("#pop-entry-date").data("prev-date", $("#pop-date" + pid).data("prev-date"));
            
            if($("#pop-date" + pid).data("show-onlogin") == "1"){
                $("#pop-entry-date").val("");
                $("#pop-entry-chk-onlogin")[0].checked = true;
            }
            else{
                $("#pop-entry-date").val(flipDate($("#pop-date" + pid).text()));
                $("#pop-entry-chk-onlogin")[0].checked = false;
                $("#pop-entry-date").datepicker('update');
            }
            chkOnlogin_Click($("#pop-entry-chk-onlogin")[0]);
	    	$("#dlg-pop-editor").dialog("open");

	    }
	    function spDelete_Click(pid){
	        if(confirm('Are you sure you want to delete this popup?\n\nPopup ID: ' + pid)){
    		    $( "#dlg-load" ).dialog("open");
                $.ajax({
                    type: "POST",
                    url: "/modules/PopUpNotify/pop-ntfy-del.php",
                    data: { popid: pid },
                    dataType: "json",
                    success: function(data){
                        $("#dlg-load").dialog("close");
                        if(data.status === 0){
                            alert("ERROR 101: \n" + data.msg);
                        }
                        else{
                            $("#dv-pop-" + pid).remove();
                            $("#sp-pop-cnt").text("Count: " + (parseInt($("#sp-pop-cnt").text().slice(7)) - 1));
                             window.location = window.location.href;
                        }
                    },
                    failure: function(errMsg) {
                        $("#dlg-load").dialog("close");
                        alert("ERROR 102 \n: " + errMsg);
                    }
                });
	        }
	    }
	    function spCommentInbox_Click(pid){
	        $("#frm-cmnt-inbox")[0].src="/modules/PopUpNotify/pop-ntfy-comment-inbox.php?popid=" + pid;
	        $("#dlg-pop-cmnt").dialog( "option", "title", "Comment Inbox fro Popup: " + pid ).dialog("open");
	    }
		function chkAllUsers_Click(chk, popid){
    	    if(chk.checked){
    	        AddUserExe(popid, 0, "All Users", function() { $("#cmbUsers" + popid).prop('disabled', true); });
    	    }
    	    else{
    	        DelUserExe(popid, [0], function() { $("#cmbUsers" + popid).prop('disabled', false); });
    	    }
	        return true;
			//$("#cmbUsers" + popid).prop('disabled', chk.checked);
		}
		
		function AddUser_Click(popid){
		    if($("#chkAllUsers" + popid)[0].checked){
		        alert('Please uncheck the option "All Users" to add users');
		    }
		    else{
    		    $("#cmbSelUsers").data("popid", popid);
    	    	$( "#dlg-users" ).dialog( "open" );
		    }
		}
		function DelUser_Click(popid){
		    var lstUsers = $('#cmbUsers'+popid).val();
		    if(!lstUsers || lstUsers.length == 0){
		        alert("Select at least one user to delete");
		    }
		    else{
		        DelUserExe(popid, lstUsers);
		    }
		}
		
		function DelUserExe(pop_id, user_ids, onSuccess){
    	    $( "#dlg-load" ).dialog("open");
            $.ajax({
                    type: "POST",
                    url: "/modules/PopUpNotify/pop-ntfy-user-del.php",
                    data: { popid: pop_id, userid: "[" + user_ids.join(",") + "]" },
                    //contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(data){
                        $("#dlg-load").dialog("close");
                        if(data.status === 0){
                            alert("ERROR 101: \n" + data.msg);
                        }
                        //alert("OKKK: " + JSON.stringify(data, null, 2));
                        else{
                            for(i=0; i<user_ids.length; i++){
                                $("#cmbUsers" + pop_id + " option[value='" + user_ids[i] + "']").remove();
                            }
                            if(onSuccess){
                                onSuccess();
                            }
                        }
                    },
                    failure: function(errMsg) {
                        $("#dlg-load").dialog("close");
                        alert("ERROR 102 \n: " + errMsg);
                    }
            });
        }
		
		function AddUserExe(pop_id, user_id, user_name, onSuccess){
		    $( "#dlg-load" ).dialog("open");
            $.ajax({
                type: "POST",
                url: "/modules/PopUpNotify/pop-ntfy-user-add.php",
                data: { popid: pop_id, userid: user_id },
                //contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data){
                    $("#dlg-load").dialog("close");
                    if(data.status === 0){
                        if(data.msg.includes('Duplicate entry')){
                            alert("This user is already bound to this popup notification");
                        }
                        else{
                            alert("ERROR 101: \n" + data.msg);
                        }
                    }
                    //alert("OKKK: " + JSON.stringify(data, null, 2));
                    else{
                        if(user_id === 0){
                            $("#cmbUsers" + pop_id + " option").remove();
                        }
                        $("#cmbUsers" + pop_id).append($('<option>', {
                            value: user_id, text: user_name }));
                        if(onSuccess){
                            onSuccess();
                        }
                    }
                },
                failure: function(errMsg) {
                    $("#dlg-load").dialog("close");
                    alert("ERROR 102 \n: " + errMsg);
                }
            });
		}
		
		$(document).ready(function(){
            $( "#pop-entry-date" ).datepicker({ dateFormat: "dd-mm-yyyy" });  //dateFormat not working, we set the value directly in the file: /libraries/bootstrap/js/eternicode-bootstrap-datepicker/js/bootstrap-datepicker.js   line 29
            $("#dlg-users").dialog({
            	autoOpen: false, modal: true,
            	width: 400,
            	buttons: [
            		{
            			text: "Ok",
            			click: function() {
            			    var pid = $("#cmbSelUsers").data("popid");
                            AddUserExe(pid, $("#cmbSelUsers").val(), $("#cmbSelUsers option:selected").text(), function() { $("#dlg-users").dialog("close"); });
            			}
            		},
            		{
            			text: "Cancel",
            			click: function() {
            				$( this ).dialog( "close" );
            			}
            		}
            	]
            });
            
            $("#dlg-load").dialog({
            	autoOpen: false, modal: true, width: 215,
            });

            $("#dlg-pop-editor").dialog({
            	autoOpen: false, modal: true,
            	width: 600,
            	buttons: [
            		{
            			text: "Ok",
            			click: function() {
                            AddEditPopupExe(function() { $("#dlg-pop-editor").dialog("close"); });
            			}
            		},
            		{
            			text: "Cancel",
            			click: function() {
            				$( this ).dialog( "close" );
            			}
            		}
            	]
            });
            $("#dlg-pop-cmnt").dialog({
            	autoOpen: false, modal: true,
            	width: 600,
            	minHeight: 350,
            	close: function( event, ui ) {
            	    $("#frm-cmnt-inbox")[0].src="";
            	}
            });

		});
		
		function chkOnlogin_Click(chkOnLog){
		    $("#pop-entry-date")[0].disabled = chkOnLog.checked;
		    $("#pop-entry-date")[0].style.backgroundColor = (chkOnLog.checked ? "#989898" : "#fff");
		}
		function AddEditPopupExe(onSuccess){
		    var pop_id = $("#dv-pop-editor").data("popid");
		    var popTitle = $("#pop-entry-title").val().trim();
		    var popText = $("#pop-entry-msg").val().trim();
		    var popDate = $("#pop-entry-date").val().trim();
		    var popPrevDate = $("#pop-entry-date").data("prev-date");
		    var reActivateChild = "0";
		    
		    if(popTitle == ''){
		        alert('Enter popup title'); return;
		    }
		    if(popText == ''){
		        alert('Enter popup message'); return;
		    }
		    if(!$("#pop-entry-chk-onlogin")[0].checked && popDate == ''){
		        alert('Enter popup date or check option (Show on login)'); return;
		    }
		    
		    if($("#pop-entry-chk-onlogin")[0].checked){
		        popDate = 'NULL';
		        if(popPrevDate != 'null-dt')
		            reActivateChild = "1";
		    }
		    else{
		        popDate = checkDate(popDate);
		        if(!popDate){
	                alert('Date is invalid\nPlease enter date in the following format:\ndd/mm/yyyy'); return;
		        }
		        if(popPrevDate != popDate)
		            reActivateChild = "1";
		    }
	        
		    
		    $( "#dlg-load" ).dialog("open");
            $.ajax({
                type: "POST",
                url: "/modules/PopUpNotify/pop-ntfy-add.php",
                data: { popid: pop_id, pop_title: popTitle, pop_text: popText, pop_date: popDate, reactivate_child: reActivateChild },
                //contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data){
                    $("#dlg-load").dialog("close");
                    if(data.status === 0){
                        alert("ERROR 101: \n" + data.msg);
                    }
                    else{
                        if(pop_id === 0){
                            
                        }
                        else{
                            
                        }
                        if(onSuccess){
                            onSuccess();
                        }
                        window.location = window.location.href;
                    }
                },
                failure: function(errMsg) {
                    $("#dlg-load").dialog("close");
                    alert("ERROR 102 \n: " + errMsg);
                }
            });
		}
		
		function ShowUser(id ){
		   //#showuser 
		   //
		   $.ajax({
                type: "POST",
                url: "/modules/PopUpNotify/show_user.php",
                data: { popid:id},
                dataType: "json",
                 success: function(data){
                     
                     if(data.status === 0){
                        alert("ERROR 101: \n" + data.msg);
                    }
                else{
                     //alert(" else data="+data.msg);
                     $("#showuser").html(data.msg);
                     $("#showuser").dialog("open");
                    }
                 },
                failure: function(errMsg) {
                    alert("ERROR 102 \n: " + errMsg);
                }
		   });
		  //alert("id = "+id); 
		    
		}
		function close_user()
		{
		  $("#showuser").html("");  
		}
		function checkDate(dt){
		    if(dt == '')
		        return false;
		    var parts = dt.split('-'); //dd/mm/yyyy
            if(!parts || parts.length != 3)
		        return false;
	        try{
                var dtObj = new Date(parts[2], parts[1]-1, parts[0]);
                if(isNaN(dtObj))
                    return false;
                else
                    return flipDate(dt); //dtObj.getFullYear() + '-' + (dtObj.getMonth() + 1) + '-' + dtObj.getDate();
	        }
	        catch(ex){
	            return false;
	        }

		}
		function flipDate(dtStr){  //flip from yyyy-mm-dd to dd-mm-yyyy and vice versa
		    if(dtStr == '')
		        return false;
		    var parts = dtStr.split('-'); //dd/mm/yyyy
		    
            if(!parts || parts.length != 3)
		        return false;
	        try{
                   return parts[2] + "-" + parts[1] + "-" + parts[0];
	        }
	        catch(ex){
	            return false;
	        }

		}
		
	</script>
<?php   
}
}

?>
