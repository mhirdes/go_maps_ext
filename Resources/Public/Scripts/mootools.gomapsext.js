/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Marc Hirdes <Marc_Hirdes@gmx.de>, clickstorm GmbH
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

function addMapPoint(pointDescription, Route, element, infoWindow, gme){
	Route.push(pointDescription.address);
	var latitude = pointDescription.latitude;
	var longitude = pointDescription.longitude;
	if(Math.round(latitude) == 0 && Math.round(longitude) == 0) {
		element.geocoder.geocode({"address": pointDescription.address}, function(point, status) {
			latitude = point[0].geometry.location.lat();
			longitude = point[0].geometry.location.lng();
			var position = new google.maps.LatLng(latitude, longitude);
			setMapPoint(pointDescription, Route, element, infoWindow, position);
		});
	return ;
	}
	var position = new google.maps.LatLng(latitude, longitude);
	setMapPoint(pointDescription, Route, element, infoWindow, position, gme);
};

function setMapPoint(pointDescription, Route, element, infoWindow, position, gme) {
	if(pointDescription.marker != ""){
		if(pointDescription.imageSize == 1) {
			var Icon = new google.maps.MarkerImage(pointDescription.marker,
			new google.maps.Size(pointDescription.imageWidth, pointDescription.imageHeight),
			new google.maps.Point(0, 0));
			var Shape = {type: 'rectangle', coord:[0,0,pointDescription.imageWidth,0,pointDescription.imageWidth,pointDescription.imageHeight,0,pointDescription.imageHeight,0,0]};
		}else{
			var Icon = new google.maps.MarkerImage(pointDescription.marker);
		}
		if (pointDescription.shadow != ""){
			if(pointDescription.shadowSize == 1){
				var Shadow = new google.maps.MarkerImage(
					pointDescription.shadow,
					new google.maps.Size(pointDescription.shadowWidth, pointDescription.shadowHeight),
					new google.maps.Point(0,0),
					new google.maps.Point((pointDescription.imageWidth/2),pointDescription.imageHeight)
				);
			}else{
				var Shadow = new google.maps.MarkerImage(pointDescription.shadow);
			}
			var marker = new google.maps.Marker({
		 		position: position,
		 		map: element.map,
				icon: Icon,
				shape: Shape,
				shadow: Shadow
			});
		}else{
			var marker = new google.maps.Marker({
		 		position: position,
		 		map: element.map,
				icon: Icon,
				shape: Shape
			});
		}
	}else{
		var marker = new google.maps.Marker({position: position, map: element.map});
	};
	var closeInfoWindows = function() {
   		infoWindowsArray.each(function(index, infoWindow) {
   			infoWindow.close();
   		});
   	};
	if(pointDescription.infoWindowContent != "" || pointDescription.infoWindowLink > 0){
		var infoWindowContent = pointDescription.infoWindowContent;
		if(pointDescription.infoWindowLink > 0) {
			var daddr = (pointDescription.infoWindowLink == 2)? pointDescription.latitude + ", " + pointDescription.longitude : pointDescription.address;
			daddr += " (" + pointDescription.title + ")";
			infoWindowContent += '<p class="routeLink"><a href="http://maps.google.com/maps?daddr=' + escape(daddr) + '" target="_blank">' + gme.ll.infoWindowLinkText + '<\/a><\/p>';
		}
		infoWindowContent = '<div class="gme-info-window">' + infoWindowContent + '</div>';

		if(pointDescription.openByClick){
		  	google.maps.event.addListener(marker, "click", function() {
		  		if(!infoWindow.getMap() || gme.infoWindow != this.getPosition()) {
		  			infoWindow.setContent(infoWindowContent);
		  			infoWindow.open(element.map, this);
		  			gme.infoWindow = this.getPosition();
		  		}
			});
		} else {
			google.maps.event.addListener(marker, "mouseover", function() {
				if(!infoWindow.getMap() || gme.infoWindow != this.getPosition()) {
					infoWindow.setContent(infoWindowContent);
			  		infoWindow.open(element.map, this);
			  		gme.infoWindow = this.getPosition();
				}
			});
		}
		if(!pointDescription.closeByClick){
			google.maps.event.addListener(marker, "mouseout", function() {
		    	 infoWindow.close();
        	});
    	}
		if(pointDescription.opened) {
			infoWindow.setContent(infoWindowContent);
	  		infoWindow.open(element.map, marker);
	  		gme.infoWindow = marker.getPosition();
		}
   	};
   	element.markers.push(marker);
	element.bounds.extend(position);
};

function getTravelMode($travelMode) {
	var travelMode = google.maps.TravelMode.DRIVING;
	switch($travelMode) {
		case 2: travelMode = google.maps.TravelMode.BICYCLING;
				break;
		case 3:	travelMode = google.maps.TravelMode.TRANSIT;
				break;
		case 4:	travelMode = google.maps.TravelMode.WALKING;
				break;
	}
	return travelMode;
}

function getUnitSystem($unitSystem) {
	var unitSystem = 0;
	switch($unitSystem) {
		case 2: unitSystem = google.maps.UnitSystem.METRIC;
				break;
		case 3: unitSystem = google.maps.UnitSystem.IMPERIAL;
				break;	
	}
	return unitSystem;
}

//Set zoom, center and cluster
function refreshMap(element, gme) {
	if(gme.mapSettings.zoom > 0 || gme.addresses.length == 1) {
		google.maps.event.addListener(element.map, "zoom_changed", function() {
			var zoomChangeBoundsListener = google.maps.event.addListener(element.map, "bounds_changed", function(event) {
				if(this.initZoom == 1) {
						this.setZoom((gme.mapSettings.zoom > 0)?gme.mapSettings.zoom:gme.mapSettings.defaultZoom);
					    this.initZoom = 0;
					}
				google.maps.event.removeListener(zoomChangeBoundsListener);
			});
		});
		element.map.initZoom = 1;
	}
	element.map.fitBounds(element.bounds);
	
	//cluster
	if(gme.mapSettings.markerCluster == 1) {
		if(element.markerCluster != null) {
			element.markerCluster.clearMarkers();
		}
		element.markerCluster = new MarkerClusterer(element.map, element.markers, {
			maxZoom: gme.mapSettings.markerClusterZoom,
			gridSize: gme.mapSettings.markerClusterSize
		});
	}
}

function initMap(gme) {
	var element = document.id(gme.mapSettings.title);
	var Route = new Array();
	var pointDescriptions = new Array();
	var infoWindow = new google.maps.InfoWindow();
	if(gme.mapSettings.CSSClass != ''){element.addClass(gme.mapSettings.CSSClass)};
	if(gme.mapSettings.tooltipTitle  != ''){element.set("title", gme.mapSettings.tooltipTitle)};
	element.setStyle("width", gme.mapSettings.width);
	element.setStyle("height", gme.mapSettings.height);
	element.markers = new Array();
	
	if(gme.mapSettings.styledMapCode) {
		var myStyle = gme.mapSettings.styledMapCode;
	}
		
	if(gme.mapSettings.styledMapName){
		var styledMapOptions = {
						name: gme.mapSettings.styledMapName,
						alt: gme.mapSettings.tooltipTitle
		};
		var myMapType = new google.maps.StyledMapType(
			myStyle,
			styledMapOptions
		)
	}

	var myOptions = {
		zoom: gme.mapSettings.defaultZoom,
		center: new google.maps.LatLng(0,0),
		draggable: gme.mapSettings.draggable,
		disableDoubleClickZoom: gme.mapSettings.doubleClickZoom,
		scrollwheel: gme.mapSettings.scrollZoom,
		panControl: gme.mapSettings.panControl,
		scaleControl: gme.mapSettings.scaleControl,
		streetViewControl: gme.mapSettings.streetviewControl,
		zoomControl: gme.mapSettings.zoomControl,
		zoomControlOptions: {style: gme.zoomTypes[gme.mapSettings.zoomControlType]},
		mapTypeId: gme.defaultMapTypes[gme.mapSettings.defaultType],
		mapTypeControl: gme.mapSettings.mapTypeControl,
		mapTypeControlOptions: {mapTypeIds: gme.mapSettings.mapTypes}
	}
	element.map = new google.maps.Map(document.getElementById(gme.mapSettings.title),myOptions);
	element.bounds = new google.maps.LatLngBounds();
	
	if(gme.mapSettings.styledMapName){
		element.map.mapTypes.set(gme.mapSettings.styledMapName, myMapType);
	}

	if(gme.mapSettings.defaultType==3 && gme.mapSettings.styledMapName){
		element.map.setMapTypeId(gme.mapSettings.styledMapName);
	}
	
	// KML import
	if(gme.mapSettings.kmlUrl != '' && gme.mapSettings.kmlLocal == 0) {
		var kmlLayer = new google.maps.KmlLayer(gme.mapSettings.kmlUrl, {preserveViewport: gme.mapSettings.kmlPreserveViewport});
		kmlLayer.setMap(element.map);
	}
	
	// KML import local
	if(gme.mapSettings.kmlUrl != '' && gme.mapSettings.kmlLocal == 1) {
		var request = new Request({
			url: gme.mapSettings.kmlUrl, 
			onSuccess: function(responseText, responseXML){
				var html = "";

	            //loop through placemarks tags
	           responseXML.getElements("Placemark").each(function(item, index){
	                //get coordinates and place name
	                var coords = item.getElement("coordinates").textContent;
	                var place = item.getElement("name").textContent;
	                var description = item.getElement("description").textContent;
	                //store as JSON
	                var c = coords.split(",")
	                var address = {
	                	title: place,
	            		latitude: c[1],
	            		longitude: c[0],
	            		address: place,
	            		marker: '',
	            		imageSize: 0,
	            		imageWidth: 0,
	            		imageHeight: 0,
	            		shadow: '',
	            		shadowSize: 0,
	            		shadowWidth: 0,
	            		shadowHeight: 0,
	            		infoWindowContent: description,
	            		infoWindowLink: 0, 
	            		openByClick: 1,
	            		closeByClick: 1,	
	            		opened: 0
	                };
	                addMapPoint(address, Route, element, infoWindow, gme);
	                gme.addresses.push(address);
	            });
	           	refreshMap(element, gme);
			}
		});
		request.send();
	}
	
	if(gme.mapSettings.showRoute==0) {
		element.geocoder = new google.maps.Geocoder();
		if (element.geocoder) {
			for (var i=0; i < gme.addresses.length; i++) {
				addMapPoint(gme.addresses[i], Route, element, infoWindow, gme);
			}
			refreshMap(element, gme);
		}
	}
	
	// Search
	
	if(gme.mapSettings.markerSearch == 1) {
		var myForm = document.id(gme.mapSettings.title+'-search');
		var searchWord = myForm.getElements('.gme-sword');
		myForm.addEvent('submit', function(){
        	var submitValue = searchWord[0].get('value');
        	submitValue = submitValue.toLowerCase();
        	var notFound = true;
        	for (var i=0; i < gme.addresses.length; i++) {
        			Object.each(gme.addresses[i], function(val, index) {
        			if(typeof val == "string" && (index=="title" || index=="infoWindowContent") && submitValue!="") {
        				if(val.toLowerCase().indexOf(submitValue) != -1) {
                			infoWindow.setContent(gme.addresses[i].infoWindowContent);
                	  		infoWindow.open(element.map, element.markers[i]);
                	  		element.map.setCenter(element.markers[i].getPosition());
                	  		element.map.setZoom(7);
                	  		gme.infoWindow = element.markers[i].getPosition();
                	  		notFound = false;
                		}
        			}
        		});
			}
        	if(notFound) {
				alert('Die Suche liefert keine Ergebnisse.');
			}
        	return false;
        });
	}
	
	if(gme.mapSettings.showRoute==1 || gme.mapSettings.calcRoute==1) {
		var panelHtml = new Element("div", {id: "dPanel-"+gme.mapSettings.title});
		panelHtml.inject(element, "after");
		var directionsService = new google.maps.DirectionsService();
		directionsDisplay = new google.maps.DirectionsRenderer();
		var renderRoute = function($start, $end, $travelMode, $unitSystem) {
			directionsDisplay.setMap(element.map);
			directionsDisplay.setPanel(document.getElementById("dPanel-"+gme.mapSettings.title));
			var unitSystem = getUnitSystem($unitSystem);
			var request = {
				origin:$start,
				destination:$end,
				travelMode: getTravelMode($travelMode)
			};
			if(unitSystem != 0) {
				request.unitSystem = unitSystem;
			}
			directionsService.route(request, function(response, status) {
				 if (status == google.maps.DirectionsStatus.OK) {
				      directionsDisplay.setDirections(response);
				 } else {
				      alert(gme.ll.alert);
				 }
			});
		};
	}
	

	if(gme.mapSettings.showRoute==1){
		renderRoute(gme.addresses[0].address, gme.addresses[1].address, gme.mapSettings.travelMode, gme.mapSettings.unitSystem);
	}
	
	if(gme.mapSettings.showForm == 1) {
		var mapForm = document.id(gme.mapSettings.title+'-form');
		
		mapForm.addEvent("submit", function() {
			var formStartAddress = mapForm.getElement('.gme-saddress');
			var formEndAddress = gme.addresses[0].address;
			var formTravelMode = mapForm.getElement('.gme-travelmode');
			var formUnitSystem = mapForm.getElement('.gme-unitsystem');
			
			if(formStartAddress == null){
				formStartAddress = gme.addresses[0].address;
				formEndAddress = gme.addresses[1].address;
			} else {
				formStartAddress = formStartAddress.get('value');
			}
			
			if(formTravelMode == null) {
				formTravelMode = gme.mapSettings.travelMode;
			}  else {
				formTravelMode = parseInt(formTravelMode.get('value'));
			}
			if(formUnitSystem == null) {
				formUnitSystem = gme.mapSettings.unitSystem;
			} else {
				formUnitSystem = parseInt(formUnitSystem.get('value'));
			}
			
			renderRoute(formStartAddress, formEndAddress, formTravelMode, formUnitSystem);
			return false;
		});
	}

	element.addEvent('mapresize', function() {
		google.maps.event.trigger(element.map, 'resize');
		element.map.fitBounds(element.bounds);
		if(gme.mapSettings.zoom > 0) {
			element.map.setZoom(gme.mapSettings.zoom);
		}
		google.maps.event.trigger(infoWindow, 'content_changed');
	});
	
};