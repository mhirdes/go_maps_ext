/**
 * Created by mhirdes on 27.11.13.
 */
(function ($) {
    var GoMapsExt = window.GoMapsExt = window.GoMapsExt || {};

    GoMapsExt.Data = {
        mapSettings: {
            markerSearch: null,
            defaultZoom: null,
            doubleClickZoom: null,
            scrollZoom: null,
            panControl: null,
            scaleControl: null,
            streetviewControl: null,
            zoomControl: null,
            zoomControlType: null,
            defaultType: null,
            mapTypeControl: null,
            mapTypes: null,
            showRoute: null,
            calcRoute: null,
            styledMapName: null,
            styledMapCode: null,
            tooltipTitle: null,
            kmlUrl: null,
            kmlLocal: null,
            showForm: null
        },
        zoomTypes: [],
        defaultMapTypes: [],
        addresses: []
    };

    /**
     * Controller for Map functionality
     *
     * @param {HTMLElement} element
     * @param {GoMapsExt.Data} gme
     * @constructor
     */
    GoMapsExt.Controller = function (element, gme) {
        var $element = this.element = $(element);
        this.gme = gme;
        this.data = gme;
        this.route = [];
        this.infoWindow = new google.maps.InfoWindow();
        this.bounds = new google.maps.LatLngBounds();
        this.markers = [];

        this.map = new google.maps.Map(document.getElementById(gme.mapSettings.id), this._createMapOptions());

        this._initializeCss();
        this._initializeData();
        this._initializeKmlImport();

        this._initializeSearch();
        this._initializeBackendAddresses();
        this._initializeRoute();
        this._initializeResizeListener();
        this._initializeCheckboxListener();
        this._initializeAddressListener();

        // open info window
        window.setTimeout(function () {
            $element.trigger("openinfo");
        }, 2000);

        this.setCategoriesFromRequest();
        this.focusAddressFromRequest();

        // trigger mapcreated on map
        $element.trigger("mapcreated");

        this.refreshMap($element, gme);
    };

    GoMapsExt.Controller.prototype = {
        // categories checkboxes
        setCategories: function (selectedCats) {
            var $element = this.element;

            $.each(this.markers, function (key, marker) {
                marker.setVisible(false);
                $.each(marker.categories, function (keyM, category) {
                    if ($.inArray(category, selectedCats) != -1) {
                        marker.setVisible(true);
                        return true;
                    }
                });
            });
            if ($element.markerCluster) {
                $element.markerCluster.repaint();
            }
        },

        setCategoriesFromRequest: function () {
            // set categories
            var getCats = this.getURLParameter('tx_gomapsext_show\\[cat\\]');
            if (getCats) {
                getCats = getCats.split(",");
                this.setCategories(getCats);
                $('.js-gme-cat').each(function (key, checkbox) {
                    if ($.inArray($(checkbox).val(), getCats) != -1) {
                        $(checkbox).attr('checked', true);
                        return true;
                    }
                });
            }
        },

        focusAddressFromRequest: function () {
            var getAddress = this.getURLParameter('tx_gomapsext_show\\[address\\]'),
                $element = this.element,
                gme = this.data;
            if (getAddress) {
                this.focusAddress(getAddress, $element, gme);
            }
        },

        // add a point
        addMapPoint: function (pointDescription, Route, $element, infoWindow, gme) {
            var _this = this,
                latitude = pointDescription.latitude,
                longitude = pointDescription.longitude;

            Route.push(pointDescription.address);

            if (Math.round(latitude) == 0 && Math.round(longitude) == 0) {
                $element.data("geocoder").geocode({"address": pointDescription.address}, function (point, status) {
                    latitude = point[0].geometry.location.lat();
                    longitude = point[0].geometry.location.lng();
                    var position = new google.maps.LatLng(latitude, longitude);
                    _this.setMapPoint(pointDescription, Route, $element, infoWindow, position, gme);
                });
                return;
            }

            var position = new google.maps.LatLng(latitude, longitude);

            this.setMapPoint(pointDescription, Route, $element, infoWindow, position, gme);
        },

        focusAddress: function (addressUid, $element, gme) {
            var _this = this;
            $.each(this.markers, function (key, marker) {
                if (marker.uid == addressUid) {
                    $element.data("center", marker.position);
                    if (marker.infoWindow) {
                        marker.infoWindow.setContent(marker.infoWindowContent);
                        marker.infoWindow.open(_this.map, marker);
                    }
                    _this.refreshMap($element, gme);
                    return true;
                }
            });
            if ($element.markerCluster) {
                $element.markerCluster.repaint();
            }
        },

        /**
         * decode URL Parameter go_maps_ext[cat]
         *
         * @param name
         * @returns {string|null}
         */
        getURLParameter: function (name) {
            var uri = decodeURI(location.search);
            return (new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(uri) || ["", ""])[1].replace(/\+/g, '%20') || null;
        },

        /**
         * get the travel mode
         *
         * @param $travelMode
         * @returns {string}
         */
        getTravelMode: function ($travelMode) {
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
        },

        /**
         * get the unit system
         *
         *  @param $unitSystem
         * @returns {number}
         */
        getUnitSystem: function ($unitSystem) {
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
        },

        /**
         * insert the point on the map
         *
         * @param pointDescription
         * @param Route
         * @param $element
         * @param infoWindow
         * @param position
         * @param gme
         */
        setMapPoint: function (pointDescription, Route, $element, infoWindow, position, gme) {
            var _map = this.map,
                markerOptions = {
                    position: position,
                    map: _map,
                    title: pointDescription.title
                };
            if (pointDescription.marker != "") {
                if (pointDescription.imageSize == 1) {
                    var Icon = {
                        url: pointDescription.marker,
                        size: new google.maps.Size(pointDescription.imageWidth * 2, pointDescription.imageHeight * 2),
                        scaledSize: new google.maps.Size(pointDescription.imageWidth, pointDescription.imageHeight),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(pointDescription.imageWidth / 2, pointDescription.imageHeight)
                    };

	                var Shape = {
		                type: 'rect',
		                coord: [0, 0, pointDescription.imageWidth, pointDescription.imageHeight]
	                };

                    var anchorPoint = new google.maps.Point(0, -pointDescription.imageHeight);

	                $.extend(markerOptions, {icon: Icon, shape: Shape, anchorPoint: anchorPoint});
                } else {
	                $.extend(markerOptions, {icon: pointDescription.marker});
                }

            }
            var marker = new google.maps.Marker(markerOptions);

            if (gme.mapSettings.markerCluster == 1) {
                google.maps.event.addListener(marker, 'visible_changed', function () {
                    if (marker.getVisible()) {
                        $element.markerCluster.addMarker(marker, true);
                    } else {
                        $element.markerCluster.removeMarker(marker, true);
                    }
                });
            }

            if (pointDescription.infoWindowContent != "" || pointDescription.infoWindowLink > 0) {
                var infoWindowContent = pointDescription.infoWindowContent;
                if (pointDescription.infoWindowLink > 0) {
                    var daddr = (pointDescription.infoWindowLink == 2) ? pointDescription.latitude + ", " + pointDescription.longitude : pointDescription.address;
                    daddr += " (" + pointDescription.title + ")";
                    infoWindowContent += '<p class="routeLink"><a href="//maps.google.com/maps?daddr=' + encodeURI(daddr) + '" target="_blank">' + gme.ll.infoWindowLinkText + '<\/a><\/p>';
                }
                infoWindowContent = '<div class="gme-info-window">' + infoWindowContent + '</div>';

                if (pointDescription.openByClick) {
                    google.maps.event.addListener(marker, "click", function () {
                        if (!infoWindow.getMap() || gme.infoWindow != this.getPosition()) {
                            infoWindow.setContent(infoWindowContent);
                            infoWindow.open(_map, this);
                            gme.infoWindow = this.getPosition();
                        }
                    });
                } else {
                    google.maps.event.addListener(marker, "mouseover", function () {
                        if (!infoWindow.getMap() || gme.infoWindow != this.getPosition()) {
                            infoWindow.setContent(infoWindowContent);
                            infoWindow.open(_map, this);
                            gme.infoWindow = this.getPosition();
                        }
                    });
                }
                if (!pointDescription.closeByClick) {
                    google.maps.event.addListener(marker, "mouseout", function () {
                        infoWindow.close();
                    });
                }
                if (pointDescription.opened) {

                    $element.off("openinfo").on("openinfo", function () {
                        infoWindow.setContent(infoWindowContent);
                        infoWindow.open(_map, marker);
                    });
                    gme.infoWindow = marker.getPosition();
                }

                infoWindow.setContent(infoWindowContent);
                marker.infoWindowContent = infoWindowContent;
                marker.infoWindow = infoWindow;
            }
            marker.categories = pointDescription.categories.split(",");
            marker.uid = pointDescription.uid;
            this.markers.push(marker);
            this.bounds.extend(position);
        },

        resize: function() {
            var _map = this.map,
                gme = this.data;

            google.maps.event.trigger(_map, 'resize');
            _map.fitBounds(this.bounds);
            if (gme.mapSettings.zoom > 0) {
                _map.setZoom(gme.mapSettings.zoom);
            }
            this.refreshMap(this.element, gme);
            google.maps.event.trigger(this.infoWindow, 'content_changed');
        },

        /**
         * Set zoom, center and cluster
         *
         * @param $element
         * @param gme
         */
        refreshMap: function ($element, gme) {
            var _map = this.map;
            if (gme.mapSettings.zoom > 0 || gme.addresses.length == 1) {
                google.maps.event.addListener(_map, "zoom_changed", function () {
                    var zoomChangeBoundsListener = google.maps.event.addListener(_map, "bounds_changed", function () {
                        if (this.initZoom == 1) {
                            this.setZoom((gme.mapSettings.zoom > 0) ? gme.mapSettings.zoom : gme.mapSettings.defaultZoom);
                            this.initZoom = 0;
                        }
                        google.maps.event.removeListener(zoomChangeBoundsListener);
                    });
                });
                _map.initZoom = 1;
            }

            if ($element.data("center")) {
                _map.setCenter($element.data("center"));
            } else {
                _map.fitBounds(this.bounds);
            }

            this.refreshCluster($element, gme);
        },

        /**
         * refresh the cluster
         *
         * @param $element
         * @param gme
         */
        refreshCluster: function ($element, gme) {
            if (gme.mapSettings.markerCluster == 1) {
                if ($element.markerCluster != null) {
                    $element.markerCluster.clearMarkers();
                }
                $element.markerCluster = new MarkerClusterer(this.map, this.markers, {
                    imagePath: 'https://googlemaps.github.io/js-marker-clusterer/images/m',
                    styles: gme.mapSettings.markerClusterStyle,
                    maxZoom: gme.mapSettings.markerClusterZoom,
                    gridSize: gme.mapSettings.markerClusterSize
                });
            }
        },

        _initializeCss: function () {
            this.element
                .css("width", this.gme.mapSettings.width)
                .css("height", this.gme.mapSettings.height);
        },
        _initializeData: function () {
            var $element = this.element,
                gme = this.data,
                _map = this.map;

            $element.data("map", _map);

            // styled map
            if (gme.mapSettings.styledMapName) {
                var myStyle = gme.mapSettings.styledMapCode,
                    styledMapOptions = {
                        name: gme.mapSettings.styledMapName,
                        alt: gme.mapSettings.tooltipTitle
                    },
                    myMapType = new google.maps.StyledMapType(
                        myStyle,
                        styledMapOptions
                    );
                _map.mapTypes.set(gme.mapSettings.styledMapName, myMapType);
            }

            if (gme.mapSettings.defaultType == 3 && gme.mapSettings.styledMapName) {
                _map.setMapTypeId(gme.mapSettings.styledMapName);
            }

        },

        _createMapOptions: function () {
            var gme = this.gme;
            return {
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
        },

        _initializeKmlImport: function () {
            var _this = this,
                _map = this.map,
                gme = this.data,
                Route = this.route,
                $element = this.element;

            // KML import
            if (gme.mapSettings.kmlUrl != '' && gme.mapSettings.kmlLocal == 0) {
                var kmlLayer = new google.maps.KmlLayer(gme.mapSettings.kmlUrl, {preserveViewport: gme.mapSettings.kmlPreserveViewport});
                kmlLayer.setMap(_map);
            }

            // KML import local
            if (gme.mapSettings.kmlUrl != '' && gme.mapSettings.kmlLocal == 1) {
                $.get(gme.mapSettings.kmlUrl, function (data) {

                    //loop through placemarks tags
                    $(data).find("Placemark").each(function () {
                        //get coordinates and place name
                        var coords = $(this).find("coordinates").text(),
                            place = $(this).find("name").text(),
                            description = $(this).find("description").text(),
                            c = coords.split(","),
                            address = {
                                title: place,
                                latitude: c[1],
                                longitude: c[0],
                                address: place,
                                marker: '',
                                imageSize: 0,
                                imageWidth: 0,
                                imageHeight: 0,
                                infoWindowContent: description,
                                infoWindowLink: 0,
                                openByClick: 1,
                                closeByClick: 1,
                                opened: 0,
                                categories: ''
                            };
                        _this.addMapPoint(address, Route, $element, infoWindow, gme);
                        gme.addresses.push(address);
                    });
                });
            }
        },

        _initializeSearch: function () {
            var _this = this,
                gme = this.data,
                $element = this.element;

            // Search
            if (gme.mapSettings.markerSearch == 1) {
                var $myForm = $('#' + gme.mapSettings.id + '-search'),
                    searchIn = $myForm.find('.js-gme-sword');

                $myForm.find('.js-gme-error').hide();

                $myForm.submit(function () {
                    var submitValue = $(searchIn).val().toLowerCase();
                    var notFound = true;
                    $.each(gme.addresses, function (i, address) {
                        $.each(address, function (index, val) {
                            if (typeof val == "string" && (index == "title" || index == "infoWindowContent") && submitValue != "") {
                                if (val.toLowerCase().indexOf(submitValue) != -1) {
                                    _this.focusAddress(_this.markers[i].uid, $element, gme);
                                    notFound = false;
                                }
                            }
                        });
                    });
                    $myForm.find('.js-gme-error').toggle(notFound);
                    return false;
                });
            }
        },

        _initializeBackendAddresses: function () {
            var _this = this,
                gme = this.data,
                $element = this.element,
                Route = this.route,
                infoWindow = this.infoWindow;

            // Add backend addresses
            if (gme.mapSettings.showRoute == 0) {
                $element.data("geocoder", new google.maps.Geocoder());
                if ($element.data("geocoder")) {
                    $.each(gme.addresses, function (index, address) {
                        _this.addMapPoint(address, Route, $element, infoWindow, gme);
                    });

                }
            }
        },

        _initializeRoute: function () {
            var _this = this,
                _map = this.map,
                gme = this.data,
                $element = this.element;

            // init Route function
            if (gme.mapSettings.showRoute == 1 || gme.mapSettings.calcRoute == 1) {
                var panelHtml = $('<div id="dPanel-' + gme.mapSettings.id + '"><\/div>'),
                    directionsService = new google.maps.DirectionsService(),
                    directionsDisplay = new google.maps.DirectionsRenderer();

                panelHtml.insertAfter($element);

                var renderRoute = function ($start, $end, $travelMode, $unitSystem) {
                    var unitSystem = _this.getUnitSystem($unitSystem),
                        request = {
                            origin: $start,
                            destination: $end,
                            travelMode: _this.getTravelMode($travelMode)
                        };

                    directionsDisplay.setMap(_map);
                    directionsDisplay.setPanel(document.getElementById("dPanel-" + gme.mapSettings.id));

                    if (unitSystem != 0) {
                        request.unitSystem = unitSystem;
                    }

                    directionsService.route(request, function (response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                        } else {
                            alert(gme.ll.alert);
                        }
                    });
                };
            }

            // show route from backend
            if (gme.mapSettings.showRoute == 1) {
                renderRoute(gme.addresses[0].address, gme.addresses[1].address, gme.mapSettings.travelMode, gme.mapSettings.unitSystem);
            }

            // show route from frontend
            if (gme.mapSettings.showForm == 1) {
                var $mapForm = $('#' + gme.mapSettings.id + '-form');

                $mapForm.submit(function () {
                    var formStartAddress = $mapForm.find('.js-gme-saddress').val(),
                        endAddressIndex = $mapForm.find('.js-gme-eaddress option:selected').val(),
                        formEndAddress = endAddressIndex ?
                            gme.addresses[parseInt(endAddressIndex)].address :
                            gme.addresses[0].address,
                        formTravelMode = $mapForm.find('.js-gme-travelmode').val(),
                        formUnitSystem = $mapForm.find('.js-gme-unitsystem').val();

                    if (formStartAddress == null) {
                        formStartAddress = gme.addresses[0].address;
                        formEndAddress = gme.addresses[1].address;
                    }

                    if (formTravelMode == null) {
                        formTravelMode = gme.mapSettings.travelMode;
                    } else {
                        formTravelMode = parseInt(formTravelMode);
                    }
                    if (formUnitSystem == null) {
                        formUnitSystem = gme.mapSettings.unitSystem;
                    } else {
                        formUnitSystem = parseInt(formUnitSystem);
                    }

                    renderRoute(formStartAddress, formEndAddress, formTravelMode, formUnitSystem);
                    return false;
                });
            }
        },

        _initializeResizeListener: function () {
            var _this = this;

            // eventHandler resize can be used
            this.element.bind('mapresize', function () {
                _this.resize();
            });
        },

        _initializeCheckboxListener: function () {
            var _this = this;

            // categories checkboxes
            $('.js-gme-cat').change(function () {
                var selectedCats = $('.js-gme-cat:checked').map(function () {
                    return this.value;
                });
                _this.setCategories(selectedCats);
            });
        },

        _initializeAddressListener: function () {
            var _this = this,
                $element = this.element,
                gme = this.gme;

            $('.js-gme-address').click(function () {
                var selectedAddress = [$(this).attr('data-address')];
                _this.focusAddress(selectedAddress, $element, gme);
                return false;
            });
        }
    };

    // create a new Google Map
    $.fn.gomapsext = function (gme) {
        var $element = $(this);
        if (!$element.data('gomapsextcontroller')) {
            $element.data('gomapsextcontroller', new GoMapsExt.Controller($element, gme));
        }
    };
}(jQuery));