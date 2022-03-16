



var Vtiger_Email_schoduler = {

	/**
	 * Function to show email preview in popup
	 MassSaveAjax,EmailSheduler
	 */

 sendfeadback:function(){

 var params = {
				'module' : 'Emails',
				'view'   : 'EmailSheduler',
				'mode'          :'EmailShedule'
			}

			AppConnector.request(params).then(
				function(data) {
				    
             //var hhh = JSON.stringify(data['result']['messages']);
               //console.log("Data ", "mm"); 
			},
			function(error,err){

               //console.log("Data ERROR  ", error + err);
			});
  },

/**
* Function to show email preview in popup
*/

 showNotification: function(){
 var params = {
				'module' : 'Emails',
				'view'   : 'EmailNotification',
				'mode'          :'EmailNotification'
			}

			AppConnector.request(params).then(
				function(data) {
				    
				    
			var hhh = JSON.stringify(data['result']['messages']);
		   var messagescount =JSON.stringify(data['result']['count'])
			//var nnn = jQuery.parseJSON(data['result']);
			 
			//var result =res['result'];messages
			$(".messagescount").text(messagescount);
			$(".listMessageemail").html(data['result']['messages']);
			// console.log("Data   ", 'hamemmmmmmmmmmmm'+data['result']['messages']);
		   },
			function(error,err){
               //console.log("Data ERROR  ", error);
			});
				
 },
 /**
* Function to show email preview in popup
*/
 ActivityUser:function(){
     
 
     var params ={
				'module' : 'Emails',
				'view'   : 'ActivityUser',
				'mode'          :'ActivityUser',
				
			}
			var url="";
			AppConnector.request(params).then(
				function(data){
			 
			   var respons = data['result'];
			  var messages =respons['messages'];
			  var count  = respons['count'];
			  
			  $(messages).find("ActivityNofitaion").each(function () {
			      
			     var mass =$(this).attr('allmessages');
			     //console.log(" Diiiiiinsmessages  ",mass);
			     $(".ACTIVENofiactionscontant").html(mass); 
			  });
			  
                  // $(".ACTIVTYhaitham").text(count);  
			},
			function(error,err){

                 fullErro="ActivityUser: "+error +'\nerror'+err;
                  //console.log(" ActivityUser  ",fullErro);
			}); 

     
     
     
     
 },
 
 
 

/**
* Function to show email preview in popup
*/

 Followingso:function(){
  //console.log("Data  ", 'Following');
     var params ={
				'module' : 'Emails',
				'view'   : 'FollowerNotification',
				'mode'   :'FollowerNotification',
				
			}
			
			var url="";
			AppConnector.request(params).then(
				function(data){
			 //alert(data);
			 var hhh = JSON.stringify(data['result']['messages']);
			//var hhh = JSON.stringify(data['result']);
		     var messagescount =JSON.stringify(data['result']['count'])
			//var nnn = jQuery.parseJSON(data['result']);
			 
			  jQuery('.Following_solutionsColutn').text(messagescount);
			  jQuery('.Following_solutions_time').html(data['result']['messages']);
			
		     //console.log("Data  ", 'Followingggg : ');
		   },
			function(error,err){
               //console.log("Data ERROR  ", error );
			}); 

 },
 
 Notificationpop:function()
 {
     //alert("iam test");
     jQuery.ajax({
                type: "POST",
                url: "/modules/PopUpNotify/Notificationpop.php",
                data: { pm:1},
                //contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data){
                    //lert(data.status);
                    if(data.status === 0){
                        alert("ERROR 101: \n" + data.mess);
                    }
                    else{
                        //$coun=data.count;
                        //$DATA=data.mess;
                        jQuery('.Comments_solutions_time').html(data.mess);
                        jQuery('.Comments_solutionsColutn').html(data.count);
                        
                        //alert(data.mess);
                        //console.log("conut ", data.count);
                        //console.log("DATA ", data.mess);
                    }
                },
                failure: function(errMsg) {
                    //console.log("DATA ", errMsg);
                    //alert("ERROR 102mm \n: " + errMsg);
                }
            });
     
 },

 registerEvents : function()
 {
     


 }

}

jQuery(document).ready(function(){
    //console.log("Data ERROR  ", "3333333333333");
    //alert("test");
    Vtiger_Email_schoduler.Followingso();
 Vtiger_Email_schoduler.sendfeadback();
 Vtiger_Email_schoduler.showNotification(); 
 Vtiger_Email_schoduler.ActivityUser();
 Vtiger_Email_schoduler.Notificationpop();
// Vtiger_Email_schoduler.ActivitySheduler();
setInterval(function()
  {
      
                         },5000);
setInterval(function()
  {
      Vtiger_Email_schoduler.Followingso();
     Vtiger_Email_schoduler.sendfeadback();
     Vtiger_Email_schoduler.showNotification();
     Vtiger_Email_schoduler.ActivityUser();
     Vtiger_Email_schoduler.Notificationpop();
     
   //Vtiger_Email_schoduler.ActivitySheduler();
                         },60000);  
                         
});      
