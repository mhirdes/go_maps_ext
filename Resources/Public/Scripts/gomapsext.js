const GoMapsExt = window.GoMapsExt = window.GoMapsExt || {};

GoMapsExt.Data = {
  mapSettings: {
    markerSearch: null,
    defaultZoom: null,
    doubleClickZoom: null,
    scrollZoom: null,
    scaleControl: null,
    streetviewControl: null,
    fullscreenControl: null,
    zoomControl: null,
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
    showForm: null,
    lat: null,
    lng: null,
    geolocation: null,
  },
  zoomTypes: [],
  defaultMapTypes: [],
  addresses: [],
};

class GoMapsExtController {
  constructor(element, gme) {
    this.element = element;
    this.gme = gme;
    this.data = gme;
  }

  initialize() {
    this.route = [];
    this.infoWindow = new google.maps.InfoWindow();
    this.bounds = new google.maps.LatLngBounds();
    this.markers = [];
    let {gme, element} = this;

    this.map = new google.maps.Map(
      document.getElementById(this.gme.mapSettings.id),
      this.#createMapOptions());

    this.#initializeCss();
    this.#initializeData();
    this.#initializeKmlImport();
    this.#initializeGeolocation();

    this.#initializeSearch();
    this.#initializeBackendAddresses();
    this.#initializeRoute();
    this.#initializeResizeListener();
    this.#initializeCheckboxListener();
    this.#initializeAddressListener();

    // open info window
    setTimeout(() => {
      // Select element and dispatch custom event
      element.dispatchEvent(new Event('openinfo'));
    }, 2000);

    this.setCategoriesFromRequest();
    this.focusAddressFromRequest();

    // trigger mapcreated on map
    element.dispatchEvent(new Event('mapcreated'));

    this.refreshMap(element, this.gme);
  }

  // categories checkboxes
  setCategories(selectedCats) {
    const {gme, element} = this;

    this.markers.forEach(marker => {
      let showMarker;

      if (selectedCats.length > 0) {
        marker.setVisible(false);
        let matches = 0;
        marker.categories.forEach(category => {
          if (selectedCats.includes(category)) {
            matches += 1;
          }
        });
        showMarker = (matches > 0);
        if (gme.mapSettings.logicalAnd) {
          showMarker = (matches === selectedCats.length);
        }
      } else {
        showMarker = true;
      }
      if (showMarker) {
        marker.setVisible(true);
        const addressEl = document.querySelector(`#gme-address${marker.uid}`);
        if (addressEl && addressEl.parentElement.tagName.toLowerCase() === 'del') {
          addressEl.parentElement.replaceWith(addressEl);
        }
        return true;
      } else {
        const addressEl = document.querySelector(`#gme-address${marker.uid}`);
        if (addressEl && addressEl.parentElement.tagName.toLowerCase() !== 'del') {
          const delEl = document.createElement('del');
          addressEl.parentNode.insertBefore(delEl, addressEl);
          delEl.appendChild(addressEl);
        }
      }
    });

    // Repaint marker cluster if it exists
    if (element.markerCluster) {
      element.markerCluster.repaint();
    }
  }

  setCategoriesFromRequest() {
    // set categories
    const getCats = this.getURLParameter('tx_gomapsext_show\\[cat\\]');
    if (getCats) {
      const selectedCats = getCats.split(',');
      this.setCategories(selectedCats);
      const checkboxList = document.querySelectorAll('.js-gme-cat');
      checkboxList.forEach(checkbox => {
        if (selectedCats.includes(checkbox.value)) {
          checkbox.checked = true;
        }
      });
    }
  }

  focusAddressFromRequest() {
    const getAddress = parseInt(this.getURLParameter('tx_gomapsext_show\\[address\\]'));
    const {gme, element} = this;
    if (getAddress > 0) {
      this.focusAddress(getAddress, element, gme);
    }
  }

  addMapPoint(pointDescription, Route, element, infoWindow, gme) {
    const latitude = pointDescription.latitude;
    const longitude = pointDescription.longitude;
    const geocoder = element.gomapsext.geocoder;
    const _this = this;

    Route.push(pointDescription.address);

    if (Math.round(latitude) === 0 && Math.round(longitude) === 0) {
      geocoder.geocode({'address': pointDescription.address},
        function(point, status) {
          const latitude = point[0].geometry.location.lat();
          const longitude = point[0].geometry.location.lng();
          const position = new google.maps.LatLng(latitude, longitude);
          _this.setMapPoint(pointDescription, Route, element, infoWindow,
            position, gme);
        });
      return;
    }

    const position = new google.maps.LatLng(latitude, longitude);

    this.setMapPoint(pointDescription, Route, element, infoWindow, position,
      gme);
  }

  focusAddress(addressUid, element, gme) {
    const _this = this;
    this.markers.forEach((marker) => {
      if (marker.uid === addressUid) {
        element.gomapsext.center = marker.position;
        if (marker.infoWindow) {
          marker.infoWindow.setContent(marker.infoWindowContent);
          marker.infoWindow.open(_this.map, marker);
        }
        _this.refreshMap(element, gme);
        return true;
      }
    });
    if (element.markerCluster) {
      element.markerCluster.repaint();
    }
  }

  getURLParameter(name) {
    const uri = decodeURI(location.search);
    return (new RegExp(`[?|&]${name}=([^&;]+?)(&|#|;|$)`).exec(uri) ||
      ['', ''])[1].replace(/\+/g, '%20') || null;
  }

  getTravelMode(travelModeInput) {
    let travelMode = google.maps.TravelMode.DRIVING;
    switch (travelModeInput) {
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

  getUnitSystem(unitSystemInput) {
    let unitSystem = 0;
    switch (unitSystemInput) {
      case 2:
        unitSystem = google.maps.UnitSystem.METRIC;
        break;
      case 3:
        unitSystem = google.maps.UnitSystem.IMPERIAL;
        break;
    }
    return unitSystem;
  }

  setMapPoint(pointDescription, Route, $element, infoWindow, position, gme) {
    const map = this.map;
    const markerOptions = {
      position: position,
      map: map,
      title: pointDescription.title,
    };
    if (pointDescription.marker !== '') {
      if (pointDescription.imageSize === 1) {
        const Icon = {
          url: pointDescription.marker,
          size: new google.maps.Size(pointDescription.imageWidth * 2,
            pointDescription.imageHeight * 2),
          scaledSize: new google.maps.Size(pointDescription.imageWidth,
            pointDescription.imageHeight),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(pointDescription.imageWidth / 2,
            pointDescription.imageHeight),
        };

        const Shape = {
          type: 'rect',
          coord: [
            0,
            0,
            pointDescription.imageWidth,
            pointDescription.imageHeight],
        };

        const anchorPoint = new google.maps.Point(0,
          -pointDescription.imageHeight);

        Object.assign(markerOptions,
          {icon: Icon, shape: Shape, anchorPoint: anchorPoint});
      } else {
        Object.assign(markerOptions, {icon: pointDescription.marker});
      }
    }

    const marker = new google.maps.Marker(markerOptions);

    if (gme.mapSettings.markerCluster == 1 && $element.markerCluster) {
      google.maps.event.addListener(marker, 'visible_changed', () => {
        if (marker.getVisible()) {
          $element.markerCluster.addMarker(marker, true);
        } else {
          $element.markerCluster.removeMarker(marker, true);
        }
      });
    }

    if (pointDescription.infoWindowContent !== '' ||
      pointDescription.infoWindowLink > 0) {
      let infoWindowContent = pointDescription.infoWindowContent;
      if (pointDescription.infoWindowLink > 0) {
        const daddr = (pointDescription.infoWindowLink === 2)
          ? pointDescription.latitude + ', ' + pointDescription.longitude
          : pointDescription.address;
        infoWindowContent += '<p class="routeLink"><a href="//www.google.com/maps/dir/?api=1&destination=' +
          encodeURI(daddr) + '" target="_blank">' + gme.ll.infoWindowLinkText +
          '<\/a><\/p>';
      }
      infoWindowContent = '<div class="gme-info-window">' + infoWindowContent +
        '</div>';

      if (pointDescription.openByClick) {
        google.maps.event.addListener(marker, 'click', () => {
          if (!infoWindow.getMap() || gme.infoWindow !== marker.getPosition()) {
            infoWindow.setContent(infoWindowContent);
            infoWindow.open(map, marker);
            gme.infoWindow = marker.getPosition();
          }
        });
      } else {
        google.maps.event.addListener(marker, 'mouseover', () => {
          if (!infoWindow.getMap() || gme.infoWindow !== marker.getPosition()) {
            infoWindow.setContent(infoWindowContent);
            infoWindow.open(map, marker);
            gme.infoWindow = marker.getPosition();
          }
        });
      }
      if (!pointDescription.closeByClick) {
        google.maps.event.addListener(marker, 'mouseout', () => {
          infoWindow.close();
        });
      }
      if (pointDescription.opened) {
        $element.removeEventListener('openinfo', null);
        $element.addEventListener('openinfo', () => {
          infoWindow.setContent(infoWindowContent);
          infoWindow.open(map, marker);
        });
        gme.infoWindow = marker.getPosition();
      }

      infoWindow.setContent(infoWindowContent);
      marker.infoWindowContent = infoWindowContent;
      marker.infoWindow = infoWindow;
    }
    marker.categories = pointDescription.categories.split(',');
    marker.uid = pointDescription.uid;
    this.markers.push(marker);
    this.bounds.extend(position);
  }

  resize() {
    const _map = this.map;
    const gme = this.data;

    google.maps.event.trigger(_map, 'resize');
    _map.fitBounds(this.bounds);
    if (gme.mapSettings.zoom > 0) {
      _map.setZoom(gme.mapSettings.zoom);
    }
    this.refreshMap(this.element, gme);
    google.maps.event.trigger(this.infoWindow, 'content_changed');
  }

  refreshMap(element, gme) {
    const _map = this.map;
    if (gme.mapSettings.zoom > 0 || gme.addresses.length == 1) {
      const zoomChangeBoundsListener = google.maps.event.addListener(_map,
        'zoom_changed', () => {
          const boundsChangeBoundsListener = google.maps.event.addListener(_map,
            'bounds_changed', () => {
              if (_map.initZoom == 1) {
                _map.setZoom((gme.mapSettings.zoom > 0)
                  ? gme.mapSettings.zoom
                  : gme.mapSettings.defaultZoom);
                _map.initZoom = 0;
              }
              google.maps.event.removeListener(boundsChangeBoundsListener);
            });
        });
      _map.initZoom = 1;
    }

    if (element.gomapsext.center) {
      _map.setCenter(element.gomapsext.center);
    } else if (gme.mapSettings.lat && gme.mapSettings.lng) {
      _map.setCenter(
        new google.maps.LatLng(gme.mapSettings.lat, gme.mapSettings.lng));
      _map.setZoom(gme.mapSettings.zoom);
    } else {
      _map.fitBounds(this.bounds);
    }

    this.refreshCluster(element, gme);
  }

  refreshCluster(element, gme) {
    if (gme.mapSettings.markerCluster == 1) {
      if (element.markerCluster != null) {
        element.markerCluster.clearMarkers();
      }
      element.markerCluster = new MarkerClusterer(this.map, this.markers, {
        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
        styles: gme.mapSettings.markerClusterStyle,
        maxZoom: gme.mapSettings.markerClusterZoom,
        gridSize: gme.mapSettings.markerClusterSize,
      });
    }
  }

  #initializeCss() {
    this.element.style.width = this.gme.mapSettings.width;
    this.element.style.height = this.gme.mapSettings.height;
  }

  #initializeData() {
    const element = this.element;
    const gme = this.data;
    const map = this.map;

    element.gomapsext.map = map;

    // styled map
    if (gme.mapSettings.styledMapName) {
      const myStyle = gme.mapSettings.styledMapCode;
      const styledMapOptions = {
        name: gme.mapSettings.styledMapName,
        alt: gme.mapSettings.tooltipTitle,
      };
      const myMapType = new google.maps.StyledMapType(
        myStyle,
        styledMapOptions,
      );
      map.mapTypes.set(gme.mapSettings.styledMapName, myMapType);
    }

    if (gme.mapSettings.defaultType == 3 && gme.mapSettings.styledMapName) {
      map.setMapTypeId(gme.mapSettings.styledMapName);
    }
  }

  #createMapOptions() {
    const gme = this.gme;
    return {
      zoom: gme.mapSettings.defaultZoom,
      minZoom: gme.mapSettings.minZoom,
      maxZoom: gme.mapSettings.maxZoom,
      center: new google.maps.LatLng(0, 0),
      geolocation: gme.mapSettings.geolocation,
      draggable: gme.mapSettings.draggable,
      disableDoubleClickZoom: gme.mapSettings.doubleClickZoom,
      gestureHandling: gme.mapSettings.scrollZoom ? 'auto' : 'none',
      scaleControl: gme.mapSettings.scaleControl,
      streetViewControl: gme.mapSettings.streetviewControl,
      fullscreenControl: gme.mapSettings.fullscreenControl,
      zoomControl: gme.mapSettings.zoomControl,
      mapTypeId: gme.defaultMapTypes[gme.mapSettings.defaultType],
      mapTypeControl: gme.mapSettings.mapTypeControl,
      mapTypeControlOptions: {mapTypeIds: gme.mapSettings.mapTypes},
    };
  }

  #initializeKmlImport() {
    const _this = this;
    const _map = this.map;
    const gme = this.data;
    const Route = this.route;
    const $element = this.element;

    // KML import
    if (gme.mapSettings.kmlUrl !== '' && gme.mapSettings.kmlLocal === 0) {
      const kmlLayer = new google.maps.KmlLayer(gme.mapSettings.kmlUrl,
        {preserveViewport: gme.mapSettings.kmlPreserveViewport});
      kmlLayer.setMap(_map);
    }

    // KML import local
    if (gme.mapSettings.kmlUrl !== '' && gme.mapSettings.kmlLocal === 1) {
      fetch(gme.mapSettings.kmlUrl).
        then(response => response.text()).
        then(data => {
          // loop through placemarks tags
          const parser = new DOMParser();
          const xmlDoc = parser.parseFromString(data, 'text/xml');
          const placemarks = xmlDoc.getElementsByTagName('Placemark');
          for (let i = 0; i < placemarks.length; i++) {
            const placemark = placemarks[i];
            // get coordinates and place name
            const coords = placemark.getElementsByTagName(
              'coordinates')[0].textContent;
            const place = placemark.getElementsByTagName('name')[0].textContent;
            const description = placemark.getElementsByTagName(
              'description')[0].textContent;
            const c = coords.split(',');
            const address = {
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
              categories: '',
            };
            _this.addMapPoint(address, Route, $element, _this.infoWindow, gme);
            gme.addresses.push(address);
          }
        }).
        catch(error => console.error(error));
    }
  }

  #initializeGeolocation() {
    const _this = this;
    const _map = this.map;
    const gme = this.data;

    // geolocation
    if (gme.mapSettings.geolocation === 1) {
      const myloc = new google.maps.Marker({
        clickable: false,
        icon: {
          path: google.maps.SymbolPath.CIRCLE,
          scale: 9,
          fillColor: '#408fff',
          fillOpacity: 1,
          strokeColor: 'white',
          strokeWeight: 3,
        },
        zIndex: 999,
        map: _map,
      });

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          pos => {
            const me = new google.maps.LatLng(pos.coords.latitude,
              pos.coords.longitude);
            myloc.setPosition(me);
            const mycenter = {
              lat: pos.coords.latitude,
              lng: pos.coords.longitude,
            };
            _map.setCenter(mycenter);
          },
          error => {
            console.error('could not get position');
          },
        );
      }
    }
  }

  #initializeSearch() {
    const _this = this;
    const gme = this.data;
    const $element = this.element;

    // Search
    if (gme.mapSettings.markerSearch === 1) {
      const $myForm = document.querySelector(`#${gme.mapSettings.id}-search`);
      const searchIn = $myForm.querySelector('.js-gme-sword');

      $myForm.querySelector('.js-gme-error').style.display = 'none';

      $myForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const submitValue = searchIn.value.toLowerCase();
        let notFound = true;
        gme.addresses.forEach((address, i) => {
          Object.entries(address).forEach(([index, val]) => {
            if (typeof val === 'string' &&
              (index === 'title' || index === 'infoWindowContent') &&
              submitValue !== '') {
              if (val.toLowerCase().includes(submitValue)) {
                _this.focusAddress(_this.markers[i].uid, $element, gme);
                notFound = false;
              }
            }
          });
        });
        $myForm.querySelector('.js-gme-error').style.display = notFound
          ? 'block'
          : 'none';
      });
    }
  }

  #initializeBackendAddresses() {
    const _this = this;
    const gme = this.data;
    const element = this.element;
    const Route = this.route;
    const infoWindow = this.infoWindow;

    // Add backend addresses
    if (gme.mapSettings.showRoute == 0) {
      element.gomapsext.geocoder = new google.maps.Geocoder();
      if (element.gomapsext.geocoder) {
        gme.addresses.forEach(address => {
          _this.addMapPoint(address, Route, element, infoWindow, gme);
        });
      }
    }
  }

  #initializeRoute() {
    const _this = this;
    const _map = this.map;
    const gme = this.data;
    const element = this.element;

    // init Route function
    if (gme.mapSettings.showRoute == 1 || gme.mapSettings.calcRoute == 1) {
      const panelHtml = document.createElement('div');
      panelHtml.id = `dPanel-${gme.mapSettings.id}`;
      const directionsService = new google.maps.DirectionsService();
      const directionsDisplay = new google.maps.DirectionsRenderer();

      element.parentNode.insertBefore(panelHtml, element.nextSibling);

      const renderRoute = function(start, end, travelMode, unitSystem) {
        const req = {
          origin: start,
          destination: end,
          travelMode: _this.getTravelMode(travelMode),
        };

        directionsDisplay.setMap(_map);
        directionsDisplay.setPanel(
          document.getElementById(`dPanel-${gme.mapSettings.id}`));

        if (_this.getUnitSystem(unitSystem) !== 0) {
          req.unitSystem = _this.getUnitSystem(unitSystem);
        }

        directionsService.route(req, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          } else {
            alert(gme.ll.alert);
          }
        });
      };

      // show route from backend
      if (gme.mapSettings.showRoute == 1) {
        renderRoute(gme.addresses[0].address, gme.addresses[1].address,
          gme.mapSettings.travelMode, gme.mapSettings.unitSystem);
      }

      // show route from frontend
      if (gme.mapSettings.calcRoute == 1) {
        const mapForm = document.getElementById(`${gme.mapSettings.id}-form`);

        mapForm.addEventListener('submit', function(event) {
          event.preventDefault();
          let formStartAddress = mapForm.querySelector('.js-gme-saddress').value;

          let options = mapForm.querySelectorAll('.js-gme-eaddress option');
          let endAddressIndex = '';

          options.forEach(option => {
            if(option.selected) {
              endAddressIndex = option.value;
            }
          });

          let formEndAddress = endAddressIndex ?
            gme.addresses[parseInt(endAddressIndex)].address :
            gme.addresses[0].address;

          const formTravelModeSelector =  mapForm.querySelector('.js-gme-travelmode');
          const formUnitSystemSelector =  mapForm.querySelector('.js-gme-unitsystem');

          let formTravelMode = formTravelModeSelector ? parseInt(formTravelModeSelector.value) : gme.mapSettings.travelMode;
          let formUnitSystem = formUnitSystemSelector ? parseInt(formUnitSystemSelector.value) : gme.mapSettings.unitSystem;

          if (formStartAddress == null) {
            formStartAddress = gme.addresses[0].address;
            formEndAddress = gme.addresses[1].address;
          }

          renderRoute(formStartAddress, formEndAddress, formTravelMode,
            formUnitSystem);
        });
      }
    }
  }

  #initializeResizeListener() {
    const _this = this;
    let width = this.element.offsetWidth;

    // eventHandler resize can be used
    this.element.addEventListener('mapresize', function() {
      // resize only when the window width changes, not while hiding a browser bar
      if (_this.element.offsetWidth !== width) {
        width = _this.element.offsetWidth;
        _this.resize();
      }
    });
  }

  #initializeCheckboxListener() {
    const _this = this;

    // categories checkboxes
    const checkboxes = document.querySelectorAll('.js-gme-cat');
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        let selectedCatsValues = [];
        checkboxes.forEach(checkbox => {
          if(checkbox.checked) {
            selectedCatsValues.push(checkbox.value);
          }
        });
        _this.setCategories(selectedCatsValues);
      });
    });
  }

  #initializeAddressListener() {
    const _this = this;
    const element = this.element;
    const gme = this.gme;

    const addresses = document.querySelectorAll('.js-gme-address');
    addresses.forEach(address => {
      address.addEventListener('click', function(event) {
        event.preventDefault();
        const selectedAddress = parseInt(this.getAttribute('data-address'));
        _this.focusAddress(selectedAddress, element, gme);
      });
    });
  }
}

// create a new Google Map
let goMapsExtControllerStorage = {};

HTMLElement.prototype.gomapsext = function(gme) {
  if (!goMapsExtControllerStorage[this.id]) {
    goMapsExtControllerStorage[this.id] = new GoMapsExtController(this, gme);
  }
};

function getGoMapsExtControllerById(id) {
  return goMapsExtControllerStorage ? goMapsExtControllerStorage[id] : undefined;
}

// add global callback function, see https://developers.google.com/maps/documentation/javascript/overview#Loading_the_Maps_API
window.goMapsExtLoaded = function() {
  const maps = document.querySelectorAll('.js-map');
  maps.forEach(function(el) {
    getGoMapsExtControllerById(el.id).initialize();

    if (goMapsExtController) {
      goMapsExtController.initialize();
    } else {
      // if no search controller loaded, then retry
      setTimeout(goMapsExtLoaded, 250);
    }
  });
};
