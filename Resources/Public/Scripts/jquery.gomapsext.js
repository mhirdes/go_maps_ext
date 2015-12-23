/**
 * Created by mhirdes on 27.11.13.
 */
(function($) {

	// create a new Google Map
	$.fn.gomapsext = function(gme) {
		var element = $(this);

		var Route = [];
		var infoWindow = new google.maps.InfoWindow();
		if(gme.mapSettings.CSSClass != '') {
			element.addClass(gme.mapSettings.CSSClass);
		}
		if(gme.mapSettings.tooltipTitle != '') {
			element.attr("title", gme.mapSettings.tooltipTitle);
		}
		element.css("width", gme.mapSettings.width);
		element.css("height", gme.mapSettings.height);
		element.data("markers", []);


		// set map options
		var myOptions = {
			zoom: gme.mapSettings.defaultZoom,
			minZoom: gme.mapSettings.minZoom,
			maxZoom: gme.mapSettings.maxZoom,
			center: new google.maps.LatLng(0, 0),
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
		};

		element.data("map", new google.maps.Map(document.getElementById(gme.mapSettings.id), myOptions));
		element.data("bounds", new google.maps.LatLngBounds());

		// styled map
		if(gme.mapSettings.styledMapName) {
			var myStyle = gme.mapSettings.styledMapCode;
			var styledMapOptions = {
				name: gme.mapSettings.styledMapName,
				alt: gme.mapSettings.tooltipTitle
			};
			var myMapType = new google.maps.StyledMapType(
				myStyle,
				styledMapOptions
			);
			element.data("map").mapTypes.set(gme.mapSettings.styledMapName, myMapType);
		}

		if(gme.mapSettings.defaultType == 3 && gme.mapSettings.styledMapName) {
			element.data("map").setMapTypeId(gme.mapSettings.styledMapName);
		}

		// KML import
		if(gme.mapSettings.kmlUrl != '' && gme.mapSettings.kmlLocal == 0) {
			var kmlLayer = new google.maps.KmlLayer(gme.mapSettings.kmlUrl, {preserveViewport: gme.mapSettings.kmlPreserveViewport});
			kmlLayer.setMap(element.data("map"));
		}

		// KML import local
		if(gme.mapSettings.kmlUrl != '' && gme.mapSettings.kmlLocal == 1) {
			$.get(gme.mapSettings.kmlUrl, function(data) {

				//loop through placemarks tags
				$(data).find("Placemark").each(function() {
					//get coordinates and place name
					var coords = $(this).find("coordinates").text();
					var place = $(this).find("name").text();
					var description = $(this).find("description").text();
					//store as JSON
					var c = coords.split(",");
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
						opened: 0,
						categories: ''
					};
					addMapPoint(address, Route, element, infoWindow, gme);
					gme.addresses.push(address);
				});
			});
		}

		// Search
		if(gme.mapSettings.markerSearch == 1) {
			var myForm = $('#' + gme.mapSettings.id + '-search');
			myForm.find('.error').hide();
			var searchIn = myForm.find('.gme-sword');
			myForm.submit(function() {
				var submitValue = $(searchIn).val().toLowerCase();
				var notFound = true;
				$.each(gme.addresses, function(i, address) {
					$.each(address, function(index, val) {
						if(typeof val == "string" && (index == "title" || index == "infoWindowContent") && submitValue != "") {
							if(val.toLowerCase().indexOf(submitValue) != -1) {
								if(element.data("markers")[i].infoWindow) {
									element.data("markers")[i].infoWindow.open(element.data("map"), element.data("markers")[i]);
								}
								element.data("map").setCenter(element.data("markers")[i].getPosition());
								gme.infoWindow = element.data("markers")[i].getPosition();
								notFound = false;
							}
						}
					});
				});
				myForm.find('.error').toggle(notFound);
				return false;
			});
		}

		// Add backend addresses
		if(gme.mapSettings.showRoute == 0) {
			element.data("geocoder", new google.maps.Geocoder());
			if(element.data("geocoder")) {
				$.each(gme.addresses, function(index, address) {
					addMapPoint(address, Route, element, infoWindow, gme);
				});

			}
		}

		// init Route function
		if(gme.mapSettings.showRoute == 1 || gme.mapSettings.calcRoute == 1) {
			var panelHtml = $('<div id="dPanel-' + gme.mapSettings.id + '"><\/div>');
			panelHtml.insertAfter(element);
			var directionsService = new google.maps.DirectionsService();
			var directionsDisplay = new google.maps.DirectionsRenderer();
			var renderRoute = function($start, $end, $travelMode, $unitSystem) {
				directionsDisplay.setMap(element.data("map"));
				directionsDisplay.setPanel(document.getElementById("dPanel-" + gme.mapSettings.id));
				var unitSystem = getUnitSystem($unitSystem);
				var request = {
					origin: $start,
					destination: $end,
					travelMode: getTravelMode($travelMode)
				};
				if(unitSystem != 0) {
					request.unitSystem = unitSystem;
				}
				directionsService.route(request, function(response, status) {
					if(status == google.maps.DirectionsStatus.OK) {
						directionsDisplay.setDirections(response);
					} else {
						alert(gme.ll.alert);
					}
				});
			};
		}

		// show route from backend
		if(gme.mapSettings.showRoute == 1) {
			renderRoute(gme.addresses[0].address, gme.addresses[1].address, gme.mapSettings.travelMode, gme.mapSettings.unitSystem);
		}

		// show route from frontend
		if(gme.mapSettings.showForm == 1) {
			var mapForm = $('#' + gme.mapSettings.id + '-form');

			mapForm.submit(function() {
				var formStartAddress = mapForm.find('.gme-saddress').val();
				var endAddressIndex = mapForm.find('.gme-eaddress option:selected').val();
				var formEndAddress = endAddressIndex ?
					gme.addresses[parseInt(endAddressIndex)].address :
					gme.addresses[0].address;
				var formTravelMode = mapForm.find('.gme-travelmode').val();
				var formUnitSystem = mapForm.find('.gme-unitsystem').val();

				if(formStartAddress == null) {
					formStartAddress = gme.addresses[0].address;
					formEndAddress = gme.addresses[1].address;
				}

				if(formTravelMode == null) {
					formTravelMode = gme.mapSettings.travelMode;
				} else {
					formTravelMode = parseInt(formTravelMode);
				}
				if(formUnitSystem == null) {
					formUnitSystem = gme.mapSettings.unitSystem;
				} else {
					formUnitSystem = parseInt(formUnitSystem);
				}

				renderRoute(formStartAddress, formEndAddress, formTravelMode, formUnitSystem);
				return false;
			});
		}

		// eventHandler resize can be used
		element.bind('mapresize', function() {
			google.maps.event.trigger(element.data("map"), 'resize');
			element.data("map").fitBounds(element.data("bounds"));
			if(gme.mapSettings.zoom > 0) {
				element.data("map").setZoom(gme.mapSettings.zoom);
			}
			refreshMap(element, gme);
			google.maps.event.trigger(infoWindow, 'content_changed');
		});

		// open info window
		window.setTimeout(function() {
			element.trigger("openinfo");
		}, 2000);

		// categories checkboxes
		var setCategories = function(selectedCats) {
			$.each(element.data("markers"), function(key, marker) {
				marker.setVisible(false);
				$.each(marker.categories, function(keyM, category) {
					if($.inArray(category, selectedCats) != -1) {
						marker.setVisible(true);
						return true;
					}
				});
			});
			if(element.markerCluster) {
				element.markerCluster.repaint();
			}
		};

		// set categories
		var getCats = getURLParameter('tx_gomapsext_show\\[cat\\]');
		if(getCats) {
			getCats = getCats.split(",");
			setCategories(getCats);
			$('.gomapsext-cats INPUT').each(function(key, checkbox) {
				if($.inArray($(checkbox).val(), getCats) != -1) {
					$(checkbox).attr('checked', true);
					return true;
				}
			});
		}
		// categories checkboxes
		$('.gomapsext-cats INPUT').change(function() {
			var selectedCats = $('.gomapsext-cats INPUT:checked').map(function() {
				return this.value;
			});
			setCategories(selectedCats);
		});


		$('.gomapsext-addresses .js-address').click(function() {
			var selectedAddress = [$(this).attr('data-address')];
			focusAddress(selectedAddress, element, gme);
			return false;
		});

		var getAddress = getURLParameter('tx_gomapsext_show\\[address\\]');
		if(getAddress) {
			focusAddress(getAddress, element, gme);
		}

		// trigger mapcreated on map
		element.trigger("mapcreated");

		refreshMap(element, gme);
	};


	// add a point
	function addMapPoint(pointDescription, Route, element, infoWindow, gme) {
		Route.push(pointDescription.address);
		var latitude = pointDescription.latitude;
		var longitude = pointDescription.longitude;
		if(Math.round(latitude) == 0 && Math.round(longitude) == 0) {
			element.data("geocoder").geocode({"address": pointDescription.address}, function(point, status) {
				latitude = point[0].geometry.location.lat();
				longitude = point[0].geometry.location.lng();
				var position = new google.maps.LatLng(latitude, longitude);
				setMapPoint(pointDescription, Route, element, infoWindow, position, gme);
			});
			return;
		}
		var position = new google.maps.LatLng(latitude, longitude);
		setMapPoint(pointDescription, Route, element, infoWindow, position, gme);
	}

	function focusAddress(addressUid, element, gme) {
		$.each(element.data("markers"), function(key, marker) {
			if($.inArray(marker.uid + "", addressUid) != -1) {
				element.data("center", marker.position);
				if(marker.infoWindow) {
					marker.infoWindow.open(element.data("map"), marker);
				}
				refreshMap(element, gme);
				return true;
			}
		});
		if(element.markerCluster) {
			element.markerCluster.repaint();
		}
	}

	// decode URL Parameter go_maps_ext[cat]
	function getURLParameter(name) {
		var uri = decodeURI(location.search);
		return (new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(uri) || ["",""])[1].replace(/\+/g, '%20') || null;
	}

	// get the travel mode
	function getTravelMode($travelMode) {
		var travelMode = google.maps.TravelMode.DRIVING;
		switch ($travelMode) {
			case 2:
				travelMode = google.maps.TravelMode.BICYCLING;
				break;
			case 3:
				travelMode = google.maps.TravelMode.TRANSIT;
				break;
			case 4:
				travelMode = google.maps.TravelMode.WALKING;
				break;
		}
		return travelMode;
	}

	// get the unit system
	function getUnitSystem($unitSystem) {
		var unitSystem = 0;
		switch ($unitSystem) {
			case 2:
				unitSystem = google.maps.UnitSystem.METRIC;
				break;
			case 3:
				unitSystem = google.maps.UnitSystem.IMPERIAL;
				break;
		}
		return unitSystem;
	}

	// insert the point on the map
	function setMapPoint(pointDescription, Route, element, infoWindow, position, gme) {
		var marker;
		if(pointDescription.marker != "") {
			var Icon;
			if(pointDescription.imageSize == 1) {
				Icon = new google.maps.MarkerImage(pointDescription.marker,
					new google.maps.Size(pointDescription.imageWidth, pointDescription.imageHeight),
					new google.maps.Point(0, 0));
				var Shape = {type: 'rectangle', coord: [0, 0, pointDescription.imageWidth, 0, pointDescription.imageWidth, pointDescription.imageHeight, 0, pointDescription.imageHeight, 0, 0]};
			} else {
				Icon = new google.maps.MarkerImage(pointDescription.marker);
			}
			if(pointDescription.shadow != "") {
				var Shadow;
				if(pointDescription.shadowSize == 1) {
					Shadow = new google.maps.MarkerImage(
						pointDescription.shadow,
						new google.maps.Size(pointDescription.shadowWidth, pointDescription.shadowHeight),
						new google.maps.Point(0, 0),
						new google.maps.Point((pointDescription.imageWidth / 2), pointDescription.imageHeight)
					);
				} else {
					Shadow = new google.maps.MarkerImage(pointDescription.shadow);
				}
				marker = new google.maps.Marker({
					position: position,
					map: element.data("map"),
					icon: Icon,
					shape: Shape,
					shadow: Shadow
				});
			} else {
				marker = new google.maps.Marker({
					position: position,
					map: element.data("map"),
					icon: Icon,
					shape: Shape
				});
			}
		} else {
			marker = new google.maps.Marker({position: position, map: element.data("map")});
		}

		if(gme.mapSettings.markerCluster == 1) {
			google.maps.event.addListener(marker, 'visible_changed', function() {
				if(marker.getVisible()) {
					element.markerCluster.addMarker(marker, true);
				} else {
					element.markerCluster.removeMarker(marker, true);
				}
			});
		}

		if(pointDescription.infoWindowContent != "" || pointDescription.infoWindowLink > 0) {
			var infoWindowContent = pointDescription.infoWindowContent;
			if(pointDescription.infoWindowLink > 0) {
				var daddr = (pointDescription.infoWindowLink == 2) ? pointDescription.latitude + ", " + pointDescription.longitude : pointDescription.address;
				daddr += " (" + pointDescription.title + ")";
				infoWindowContent += '<p class="routeLink"><a href="//maps.google.com/maps?daddr=' + encodeURI(daddr) + '" target="_blank">' + gme.ll.infoWindowLinkText + '<\/a><\/p>';
			}
			infoWindowContent = '<div class="gme-info-window">' + infoWindowContent + '</div>';

			if(pointDescription.openByClick) {
				google.maps.event.addListener(marker, "click", function() {
					if(!infoWindow.getMap() || gme.infoWindow != this.getPosition()) {
						infoWindow.setContent(infoWindowContent);
						infoWindow.open(element.data("map"), this);
						gme.infoWindow = this.getPosition();
					}
				});
			} else {
				google.maps.event.addListener(marker, "mouseover", function() {
					if(!infoWindow.getMap() || gme.infoWindow != this.getPosition()) {
						infoWindow.setContent(infoWindowContent);
						infoWindow.open(element.data("map"), this);
						gme.infoWindow = this.getPosition();
					}
				});
			}
			if(!pointDescription.closeByClick) {
				google.maps.event.addListener(marker, "mouseout", function() {
					infoWindow.close();
				});
			}
			if(pointDescription.opened) {

				element.off("openinfo").on("openinfo", function() {
					infoWindow.setContent(infoWindowContent);
					infoWindow.open(element.data("map"), marker);
				});
				gme.infoWindow = marker.getPosition();
			}

			infoWindow.setContent(infoWindowContent);
			marker.infoWindow = infoWindow;
		}
		marker.categories = pointDescription.categories.split(",");
		marker.uid = pointDescription.uid;
		element.data("markers").push(marker);
		element.data("bounds").extend(position);
	}

	// Set zoom, center and cluster
	function refreshMap(element, gme) {
		if(gme.mapSettings.zoom > 0 || gme.addresses.length == 1) {
			google.maps.event.addListener(element.data("map"), "zoom_changed", function() {
				var zoomChangeBoundsListener = google.maps.event.addListener(element.data("map"), "bounds_changed", function() {
					if(this.initZoom == 1) {
						this.setZoom((gme.mapSettings.zoom > 0) ? gme.mapSettings.zoom : gme.mapSettings.defaultZoom);
						this.initZoom = 0;
					}
					google.maps.event.removeListener(zoomChangeBoundsListener);
				});
			});
			element.data("map").initZoom = 1;
		}

		if(element.data("center")) {
			element.data("map").setCenter(element.data("center"));
		} else {
			element.data("map").fitBounds(element.data("bounds"));
		}

		refreshCluster(element, gme);
	}

	// refresh the cluster
	function refreshCluster(element, gme) {
		if(gme.mapSettings.markerCluster == 1) {
			if(element.markerCluster != null) {
				element.markerCluster.clearMarkers();
			}
			element.markerCluster = new MarkerClusterer(element.data("map"), element.data("markers"), {
				maxZoom: gme.mapSettings.markerClusterZoom,
				gridSize: gme.mapSettings.markerClusterSize
			});
		}
	}
}(jQuery));