/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/ 
Vtiger.Class("Google_MapLocation_Js", {}, {


initialize : function(){

var uluru = {lat: 21.48632343805013, lng: 39.19441674804693};

  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('maplocaltion'), {zoom: 10, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map ,animation: google.maps.Animation.DROP,
        draggable: true});

},

initializemaplocation : function(container){

  var thisInstance = this;

   var letm=container.find('#maplet').val();
   var legm=container.find('#maplng').val();
   var uluru = {lat:letm , lng: legm};
  // The map, centered at Uaul
  var map = new google.maps.Map(
      container.find('#map'), {zoom: 4, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
  },

	showMapLocation : function(container) {
		var thisInstance = this;
		container = jQuery(container);
		app.helper.showProgress();
		var params = {
			'module' : 'Google',
			'action' : 'MapLocationAjax',
			'mode' : 'getLocation',
			'recordid' : container.find('#record').val(),
			'source_module' : container.find('#source_module').val()
		}
		app.request.post({"data":params}).then(function(error,response){
			var result = JSON.parse(response);
			app.helper.hideProgress();
			var address = result.address;
			container.find('#record_label').val(result.label);
			var location = jQuery.trim((address).replace(/\,/g," "));
			if(location != '' && location != null){
				container.find("#address").html(location);
				container.find('#address').removeClass('hide');
			}else{
				app.helper.hidePopup();
				app.helper.showAlertNotification({message:app.vtranslate('Please add address information to view on map')});
				return false;
			}
			container.find("#mapLink").on('click',function() {
			   window.open(thisInstance.getQueryString(location));
			});
			thisInstance.loadMapScript();
		});
	},

	loadMapScript : function() {
		//	jQuery.getScript("https://maps.google.com/maps/api/js?sensor=true&async=2&callback=initialize", function () {});
		//"https://maps.googleapis.com/maps/api/js?key=AIzaSyDY44B55qSjwPsLW5lu4TOZY6O0UPQtzaE&callback=initialize", function () {});
		
    
	},

	getQueryString : function (address) {
		address = address.replace(/,/g,' ');
		address = address.replace(/ /g,'+');
		return "https://maps.google.com/maps?q=" + address + "&zoom=14&size=512x512&maptype=roadmap&sensor=false";
	}
 


});

