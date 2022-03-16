Vtiger.Class('MapTacking_Run_Js',{

   getInstance : function() {
		return new MapTacking_Run_Js();
   },
    
   crestelament : function(txst){
		var para = document.createElement("P"); 
		var date= new Date();                  // Create a <p> node
		var t = document.createTextNode(date+":"+txst);   
		para.appendChild(t);                                          // Append the text to <p>
		document.getElementById("myDIV").appendChild(para);  
		},

	    rad :function(x) {
		    return x * Math.PI / 180;
		},

	   getDistance : function(p1, p2) {
		    var R = 6378137; // Earth’s mean radius in meter
		    var dLat = rad(p2.lat - p1.lat);
		    var dLong = rad(p2.lng - p1.lng);
		    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
		        Math.cos(rad(p1.lat)) * Math.cos(rad(p2.lat)) *
		        Math.sin(dLong / 2) * Math.sin(dLong / 2);
		    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
		    var d = R * c;
		    return d; // returns the distance in meter
		},

         
		savelocation : function(nlat , nlng){
			var params = {
			'module' : 'MapTracking',
			'action' : 'usersTracking',
			'mode' : 'setLocation',
			 'lat'  : nlat,
			 'lng'  : nlng,

		   };
		   app.request.post({"data":params}).then(function(error,response) {
			 var result = JSON.parse(response); 
			 var stat = result.status;
			  crestelament("___________:\t"+stat);


			});
		  
		  
		},

		settinguser : function(){
			 jQuery("#usertrakingckb").on('click',function(){
		   	 var curentTarget = jQuery(this);
		   	 var  stat;
			 if(curentTarget.is(':checked')) {
                 stat=1;
			 }else{
			 	stat=0;
			 }
			 var params = {
			 'module' : 'MapTracking',
			 'action' : 'usersTracking',
			 'mode' : 'usersainTracking',
			 'valeu'  : stat,
			 'process'  : 1,
		     };
		    
		     app.request.post({"data":params}).then(function(error,response) {
			  var result = JSON.parse(response);
			  var sts=result.sataus;
			  console.log("activ="+sts);
			   window.location.reload(true); 
		     });

		     });


			 jQuery("#Dtrakinginterval").on('change',function(){
			 var val = jQuery("#Dtrakinginterval").val();
			 var params = {
			 'module' : 'MapTracking',
			 'action' : 'usersTracking',
			 'mode' : 'usersainTracking',
			 'valeu'  : val,
			 'process'  : 2,
		     };
		     app.request.post({"data":params}).then(function(error,response) {
			  var result = JSON.parse(response);
			  var sts=result.sataus;
			  console.log(sts);
			   window.location.reload(true); 

		     });

			 });


		},


		

		sendlocation: function( nlat , nlng){
			var geins = new MapTacking_Run_Js();
			var ACTIVATIONTRACKING = document.getElementById("ACTIVATIONTRACKING").value;
            var mlat=parseFloat(nlat);
            var mlng=parseFloat(nlng);



             if (ACTIVATIONTRACKING =="0" || ACTIVATIONTRACKING ==0)
		  	{
		  		text="Tracking not activated";
		  		crestelament(text);

		  	}else{

			// var oldlet=parseFloat(document.getElementById("oldlet").value);
		     //var oldlen=parseFloat(document.getElementById("oldlen").value);

		     var oldlet=document.getElementById("oldlet").value;
		     var oldlen=document.getElementById("oldlen").value;

		     if(oldlet =="" || oldlet ==null){
		     	  document.getElementById("oldlet").value=nlat;
		          document.getElementById("oldlen").value=nlng;
                  		          
		          geins.savelocation(nlat ,nlng);
		          crestelament("____First Value");
		     }else{

		     	if(nlat == oldlet && nlng==oldlen){
		     		//crestelament("eqlelvale");

		     	}else{
		            var oldp = { lat: oldlet, lng: oldlen };
		            var newp = { lat: nlat, lng: nlng };
		             var distance = getDistance(oldp, newp);
		        //      if(distance > 0){

		        //      }

                       geins.savelocation(nlat ,nlng);
		               te='\tDis ism '+distance+'\tlatitude:\t'+nlat+"," +nlng;
		                 document.getElementById("oldlet").value=nlat;
		                 document.getElementById("oldlen").value=nlng;
		                 crestelament(te);
		                 
		     	 }
		     }

		}
	},

     getuserTracking : function(){
	
		var DUserTrackingday=jQuery("#DUserTrackingday").val();
		var DUserTrackinguser=jQuery("#DUserTrackinguser").val();

		var map = new google.maps.Map(document.getElementById('maptracking'), {
          center: new google.maps.LatLng(21.497304583198005, 39.192099319458066),
          zoom: 6
        });
        

        var image = {
          url: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m1.png',
          // This marker is 20 pixels wide by 32 pixels high.
          size: new google.maps.Size(40, 52),
          // The origin for this image is (0, 0).
          origin: new google.maps.Point(0, 0),
          // The anchor for this image is the base of the flagpole at (0, 32).
          anchor: new google.maps.Point(40, 52)
        };
        // Shapes define the clickable region of the icon. The type defines an HTML
        // <area> element 'poly' which traces out a polygon as a series of X,Y points.
        // The final coordinate closes the poly by connecting to the first coordinate.
        var shape = {
          coords: [1, 1, 1, 20, 18, 20, 18, 1],
          type: 'poly'
        };
        var infoWindow = new google.maps.InfoWindow;

		//console.log("DUserTrackingday:"+DUserTrackingday+"\n DUserTrackingday:"+DUserTrackinguser);

		jQuery("#DUserTracking").on('click',function(){
	    var DUserTrackingda=jQuery("#DUserTrackingday").val();
		var DUserTrackinguse=jQuery("#DUserTrackinguser").val();
		console.log("DUserTrackingday:"+DUserTrackingda+"\n DUserTrackingday:"+DUserTrackinguse);

		var params1 = {
			'module' : 'MapTracking',
			'action' : 'usersTracking',
			'mode' : 'getLocation',
			'Dateday'  : DUserTrackingda,
			'userTracking'  : DUserTrackinguse,
		};
		// Eng : Haithem Ghanem
		app.request.post({"data":params1}).then(function(error,response) {
			var result = JSON.parse(response);
			var sts=result.sataus;
			if(sts ==0 || sts =='0'){
              app.helper.showAlertNotification({
						'message': 'لا يوجد سجلات'
					});

			}else{
			var map = new google.maps.Map(document.getElementById('maptracking'), {
		          center: new google.maps.LatLng(21.497304583198005, 39.192099319458066),
		          zoom: 6
		        });
			console.log("status_____:"+sts);
			var address = result.address;
			jQuery(address).find("marker").each(function () {
                 jQuery(this).attr('name');
                 var id = jQuery(this).attr('id');
			    var name = jQuery(this).attr('name');
			    var address = jQuery(this).attr('address');
			    var type = jQuery(this).attr('type');
			    var lat=parseFloat(jQuery(this).attr('lat'));
			    var lng= parseFloat(jQuery(this).attr('lng'));

			     var infowincontent = document.createElement('div');
					    var strong = document.createElement('strong');
					    strong.textContent = name;
					    infowincontent.appendChild(strong);
					    infowincontent.appendChild(document.createElement('br'));

					    var text = document.createElement('text');
					    text.textContent = address;
					    infowincontent.appendChild(text);

					var point = new google.maps.LatLng(lat,lng);
					var marker = new google.maps.Marker({
		                map: map,
		                position: point,
		                icon: image,
		                shape: shape,
		              });
					// infoWindow.setContent(infowincontent);
		             //infoWindow.open(map, marker);

		              marker.addListener('click', function() {
		                infoWindow.setContent(infowincontent);
		                infoWindow.open(map, marker);
		              });
		            


			    //console.log("id:"+id+"\t name"+name);
			});
		  }
		
		});
	});

	},

	registerEvents: function() {
        this._super(); 
        //this.getuserTracking(); 
       // alert("test"); 
    },
});