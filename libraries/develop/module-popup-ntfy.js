$(document).ready(function(){
    if(!window.PopupRunObj){
        window.PopupRunObj = { a:0 };
        
        $("#dlg-pop-notify").dialog({
        	autoOpen: false, modal: true,
        	width: 500, minHeight: 280, maxHeight: 500, height: 450,
        	close: popNotify_Close,
            beforeClose: popNotify_beforeClose,
        	buttons: [
        		{
        			text: "Save & Close", icon: "ui-icon-disk",
        			click: function() { $(this).dialog("close"); }  //here we call close to raise beforeClose event
        		},
        		{
        			text: "Show Comments", 
        			click: btCommentInbox_Click
        		},
        	]
        });
        
        getPopup(); //we call it first time because in setInterval it will be called after 1 minute
        window.setInterval(function() {
            if(!$("#dlg-pop-notify").dialog("isOpen"))
                getPopup(); 
        }, 60000); //1 minute

        $("#dlg-pop-cmnt2").dialog({
        	autoOpen: false, modal: true,
        	width: 600,
        	minHeight: 350,
        	close: function( event, ui ) {
        	    $("#frm-cmnt2-inbox")[0].src="";
        	}
        });
        $("#dlg-load2").dialog( { autoOpen: false, modal: true, width: 215 } );
    }
    window.PopupRunObj.a++;  //for debug process
});

function getPopup(){
    $.ajax({
        type: "POST",
        url: "/modules/PopUpNotify/pop-ntfy-get.php",
        data: { arg1:1 },
        dataType: "json",
        success: function(data){
            if(data.status === -10){  //Invalid Login: we doesnt need to show alert (in Login page)
                //Nothing
            }
            else if(data.status === 0){
                alert("ERROR Get Popup 101: \n" + data.msg);
            }
            else{
                //alert("OKKK: " + JSON.stringify(data, null, 2));
                if(data.popupArr.length > 0){
                    window.popObj = { currIx: 0, popArr: data.popupArr };
                    ShowPopNotify(window.popObj.popArr[window.popObj.currIx]);
                }
            }
        },
        failure: function(errMsg) {
            alert("ERROR Get Popup 102 \n: " + errMsg);
        }
    });
}
function popNotify_beforeClose(event, ui){
    if(window.popObj.forceClose)
        return true;
    var frm = $("#frm-pop-notify");
    /*
    var frmWin = (frm[0].contentWindow || frm[0].contentDocument);
    var doc = frmWin.document;
    if(frmWin.$("#dv-pop-show").length === 0)
        return true;
    else{
        return false;
    }
    */
    var cmnt = $("#pop-entry-msg", frm.contents());
    if(cmnt.length === 0)
        return true;
    else{
        if(cmnt.val().trim() == ""){
            alert('Please enter your comment first....');
            return false;
        }
        else{
            var isRept = $("#chk-repeat", frm.contents())[0].checked;
            var txNextrun = $("#tx-nextrun", frm.contents())[0].value;
            if(isRept){
                if(txNextrun.trim()==''){
                    alert('You should enter date of next run or uncheck repeat option');
                    return false;
                }
                txNextrun = checkDate(txNextrun);
                if(!txNextrun){
                    alert('Invalid date in next run field\nYou should enter date of format: dd/mm/yyyy');
                    return false;
                }
            }
            CallSaveComment(isRept, txNextrun, cmnt.val().trim());
            return false;
        }
    }

}

function CallSaveComment(isRept, txNextrun, cmnt_val){
    $("#dlg-load2").dialog("open");
    var obj = window.popObj.popArr[window.popObj.currIx];
    if(!isRept)
        txNextrun = 'dt-null';
    $.ajax({
        type: "POST",
        url: "/modules/PopUpNotify/pop-save-comment.php",
        data: { popid: obj.id, 'cmnt-txt': cmnt_val, 'rept-date': txNextrun },
        dataType: "json",
        success: function(data){
            $("#dlg-load2").dialog("close");
            if(data.status === 0){
                alert("ERROR 101: \n" + data.msg);
            }
            else{
                //alert('Save eeeeeeeeeeee OOOOKKKK');
                window.popObj.forceClose = 1;
                $("#dlg-pop-notify").dialog("close");
            }
        },
        failure: function(errMsg) {
            $("#dlg-load2").dialog("close");
            alert("ERROR 102 \n: " + errMsg);
        }
    });
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

function popNotify_Close(event, ui){
    $("#frm-pop-notify")[0].src="";
    //alert(111);
    window.popObj.currIx++;
    if(window.popObj.currIx < window.popObj.popArr.length){
        ShowPopNotify(window.popObj.popArr[window.popObj.currIx]);
    }
}
function ShowPopNotify(p){
    $("#frm-pop-notify")[0].src="/modules/PopUpNotify/pop-ntfy-show.php?popid=" + p.id;
    //$("#dlg-pop-notify").dialog( "option", "title", "Popup: " + p.id ).dialog("open");
    window.popObj.forceClose=0;
    $("#dlg-pop-notify").dialog("open");
}
function frm_pop_Load(frm){
    frm = $(frm);
    var cmnt = $("#pop-entry-msg", frm.contents());
    if(cmnt.length > 0){
        frm.height(frm.contents().height());
    }
}

function btCommentInbox_Click(){
    obj = window.popObj.popArr[window.popObj.currIx];
    $("#frm-cmnt2-inbox")[0].src="/modules/PopUpNotify/pop-ntfy-comment-inbox.php?popid=" + obj.id;
    $("#dlg-pop-cmnt2").dialog( "option", "title", "Comment Inbox fro Popup: " + obj.id ).dialog("open");
}
