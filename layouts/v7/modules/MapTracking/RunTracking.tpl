
{strip}

 <div class="">

      <input type="hidden" id="oldlet">
      <input type="hidden" id="oldlen">
      <input type="hidden" id="ACTIVATIONTRACKING" value="{$ACTIVATIONTRACKING}">
	  <input type="hidden" id="TRACKINGPERIODS" value="{$TRACKINGPERIODS}">
	  <input type="hidden" id="trackingperiodsintger" value="{$trackingperiodsintger}">
	  
	   <input type="hidden" id="DATADAY" value="{$DATADAY}">
		<div class="listViewPageDiv content-area full-width" id="listViewContent">
		  <div class="col-sm-12 col-xs-12 ">



		    <div id="listview-actions" class="listview-actions-container"><div class="row">
		    	<div class="col-md-4">
                  {assign var=ACTIVATIONTRACKINGST value='active'}
                      {if $ACTIVATIONTRACKING === '0'}
                          {assign var=ACTIVATIONTRACKINGST value='unactive'}
                     {/if}
                   <input type="checkbox" class="bootstrap-switch" id="usertrakingckb" style="margin: 1px 5px;" name="userckecd" {if $ACTIVATIONTRACKINGST ==='active'} checked {/if}>
		    	   <span class=""> {vtranslate({$ACTIVATIONTRACKINGST},'Vtiger')}</span>
                            
		    	</div>
		    	<div class="col-md-4">
                   <span> {vtranslate('Tracking Periods','Users')} </span>
                   <span>
                   	 <select class="select2 col-md-12" id="Dtrakinginterval" name="columnname" data-placeholder="{vtranslate('Tracking Periods','Users')}">
                   	  {foreach item=TRNAME key=TRID from=$TRACKINGPERIODSLIST}
			              <option value="{$TRNAME}" {if  $TRNAME ===$TRACKINGPERIODS} selected {/if}>{vtranslate({$TRNAME},'Users')} </option>
			              {/foreach}
                  
                   	 </select>
                   </span>
		    	</div>
		    	<div class="col-md-4">
		    	</div>
		    </div></div>

           

		    
		    <div class="floatThead-wrapper" >
		    <div class="table-container ps-container" >

		    <span id="ModuleName" class="hide">{$MODULE_NAME}</span>
				<span id="map_module" class="hide"></span>

				<div class="{$MODULE_NAME}">
				  <div class="col-md-12" >
				  
				  
				  <div id="contant" style="displye:none">
				       
				    </div>
				   <div id="myDIV">
				       
				   </div>

				</div>
				</div>


			</div>
			</div>
			</div>

		  </div>
		</div>




 </div>

<script type="text/javascript">
		{literal}jQuery(document).ready(function() { 
		    var vtigerInstance = Vtiger_Index_Js.getInstance();
		      vtigerInstance.registerEvents();

		       var trackignInstancem = new MapTacking_Run_Js();
		        trackignInstancem.registerEvents();
		         trackignInstancem.settinguser();
          var ACTIVATIONTRACKING = document.getElementById("ACTIVATIONTRACKING").value;
		if(ACTIVATIONTRACKING =="0" || ACTIVATIONTRACKING ==0){
        	text="Tracking not activated";
		  		trackignInstancem.crestelament(text);

        }else{
		if(navigator.geolocation){
		 //id = navigator.geolocation.watchPosition(success, error, options);
		 setInterval(function(){
		      navigator.geolocation.getCurrentPosition(function(position) {
		                 var lett= position.coords.latitude;
		                  var lng=position.coords.longitude;
		                  trackignInstancem.sendlocation(position.coords.latitude,position.coords.longitude);
		                   //console.log("Latiii : " + lett +","+ lng);
		                 //crestelament("\n<hr>Lati : " + lett +","+ lng);
		            });
		          
		          }, 3000);

		}else{
		   var  text ="error not support show location";
		   crestelament(text);
		}
	   }      
       });


		function  crestelament(txst){
		var para = document.createElement("P"); 
		var date= new Date();                  // Create a <p> node
		var t = document.createTextNode(date+":"+txst);   
		para.appendChild(t);                                          // Append the text to <p>
		document.getElementById("myDIV").appendChild(para);  
		}

		var rad = function(x) {
		    return x * Math.PI / 180;
		}

		var getDistance = function(p1, p2) {
		    var R = 6378137; // Earth’s mean radius in meter
		    var dLat = rad(p2.lat - p1.lat);
		    var dLong = rad(p2.lng - p1.lng);
		    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
		        Math.cos(rad(p1.lat)) * Math.cos(rad(p2.lat)) *
		        Math.sin(dLong / 2) * Math.sin(dLong / 2);
		    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
		    var d = R * c;
		    return d; // returns the distance in meter
		}

		function savelocation(nlat , nlng,nname){


		}

		function sendlocation( nlat , nlng){
			var ACTIVATIONTRACKING = document.getElementById("ACTIVATIONTRACKING").value;
            var mlat=parseFloat(nlat);
            var mlng=parseFloat(nlng);

             if (ACTIVATIONTRACKING =="0" || ACTIVATIONTRACKING ==0)
		  	{
		  		text="Tracking not activated";
		  		crestelament(text);

		  	}else{

			 var oldlet=parseFloat(document.getElementById("oldlet").value);
		     var oldlen=parseFloat(document.getElementById("oldlen").value);

		     if(oldlet =="" || oldlet ==null){
		     	  document.getElementById("oldlet").value=nlat;
		          document.getElementById("oldlen").value=nlng;
		     }else{

		     	if(mlat == oldlet && mlng==oldlen){

		     	}else{
		            var oldp = { lat: oldlet, lng: oldlen };
		            var newp = { lat: nlat, lng: nlng };
		             var distance = getDistance(oldp, newp);
		        //      if(distance > 0){

		        //      }

		               te='\tDis is'+distance+'\tlatitude:\t'+mlat+"," +mlng;
		                 document.getElementById("oldlet").value=mlat;
		                 document.getElementById("oldlen").value=mlng;
		                 crestelament(te);
		     	 }
		     }

		}
	}

        var interval=parseInt(document.getElementById("trackingperiodsintger").value); 
        var ACTIVATIONTRACKING = document.getElementById("ACTIVATIONTRACKING").value;

		var id, target, options;

		function success(pos) {
		  var crd = pos.coords;

		  if (ACTIVATIONTRACKING =="0" || ACTIVATIONTRACKING ==0)
		  	{
		  		text="Tracking not activated";
		  		crestelament(text);

		  	}else{

		  if (target.latitude === crd.latitude && target.longitude === crd.longitude) {

		       var txt="Congratulations, you reached the target\t"+crd.latitude+","+crd.longitude;
		       var oldlet= parseFloat(document.getElementById("oldlet").value);
		       var oldlen=parseFloat(document.getElementById("oldlen").value);
		
		    navigator.geolocation.clearWatch(id);
		  }else{
		    
		       var oldlet=document.getElementById("oldlet").value;
		       var oldlen=document.getElementById("oldlen").value;
		       
		       if(oldlet =="" || oldlet==null){
		           document.getElementById("oldlet").value=crd.latitude;
		           document.getElementById("oldlen").value=crd.longitude;
		            //var te='latitude:\t'+crd.latitude +"," +crd.longitude;
		             // crestelament(te);
		       }else{

		       	 if(oldlen == crd.latitude && oldlen == crd.longitude){
		       	 	console.log("old eql new");
 
		       	 }else{
		         var oldp = { lat: oldlet, lng: oldlen };
		         var newp = { lat: crd.latitude, lng: crd.longitude };
		         var distance = getDistance(oldp, newp);
		            var te;
		           if(distance > 1){
		                te='\tDis is'+distance+'\tlatitude:\t'+crd.latitude +"," +crd.longitude;
		                 document.getElementById("oldlet").value=crd.latitude;
		                 document.getElementById("oldlen").value=crd.longitude;
		                  crestelament(te);
		           }else{
		              te='\tLess Dis :'+distance+'\tlatitude:\t'+crd.latitude +"," +crd.longitude;
		               crestelament(te);
		               console.log(te);
		           }
		       }
		         
		          
		           
		       }
		  }
		}
		}

		function error(err) {
		  //console.warn('ERROR(' + err.code + '): ' + err.message);
		   var  text ='ERROR(' + err.code + '): ' + err.message;
		   crestelament(text);
		}


		target = {
		  latitude : 0,
		  longitude: 0
		};

		options = {
		  enableHighAccuracy:true,
		  timeout: interval,
		  maximumAge:interval
		};

         
       
		

{/literal}
	</script>
{/strip}