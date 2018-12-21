.. include:: ../Includes.txt
.. include:: Images.txt

.. _user-manual:

Users Manual
============

- The extension has to types of records: map and address.

- A map can have a plurality of addresses.

- Each frontend plug in includes one map.

- The records can be saved on every page. Preferred is an extra
  SysFolder.

- Each plugin requires one Map.

|img-4|

Map
"""""

One Map represents one Google Map in the frontend.

|img-5|

The following table shows the main configurations of a map. Each
description is also shown as help text when you hover the title of a
field.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         title

   Description
         Will be used as ID (without space character, special character!).

         [required]


.. container:: table-row

   Property
         width

   Description
         Set the width of the map. Default in px, for percentages enter '%',
         e.g. '100%'.[required]


.. container:: table-row

   Property
         height

   Description
         Set the width of the map. Default in px, for percentages enter '%',
         e.g. '100%'.[required]


.. container:: table-row

   Property
         zoom

   Description
         Only needed when the default zoom is wrong. Number between 0 and 23. 0 is the lowest zoom (whole world).

.. container:: table-row

   Property
         zoom min

   Description
         The minimum zoom level which will be displayed on the map. If omitted, or set to null, the minimum
         zoom from the current map type is used instead.

.. container:: table-row

   Property
         zoom max

   Description
         The maximum zoom level which will be displayed on the map. If omitted, or set to null, the maximum
         zoom from the current map type is used instead.

.. container:: table-row

   Property
         addresses

   Description
         You can choose, create or edit an address. New addresses will be saved
         on the current page.

.. container:: table-row

   Property
         latitude

   Description
         If set this latitude will be used to center the map. Otherwise the center is calculated so that all
         addresses fit in the map.

.. container:: table-row

   Property
         longitude

   Description
         If set this longitude will be used to center the map. Otherwise the center is calculated so that all
         addresses fit in the map.

.. container:: table-row

   Property
         previewImage

   Description
         Define an image to show as preview of the current map. Otherwise the fallback image of the TypoScript constant
         will be displayed if defined. If both is not set, a link will be displayed.


.. container:: table-row

   Property
         kmlUrl

   Description
         Enter an URL of a KML file, e.g. `http://gmaps-
         samples.googlecode.com/svn/trunk/ggeoxml/cta.kml <http://gmaps-
         samples.googlecode.com/svn/trunk/ggeoxml/cta.kml>`_


.. container:: table-row

   Property
         kmlPreserveViewport

   Description
         The viewport of the kml file will be ignored. Set zoom and at least
         one address to configure the viewport.


.. container:: table-row

   Property
         kmlLocal

   Description
         The KML file is stored on this server. The specified path (kmlUrl) is
         relative. Only markers appear. Search and route are only available if
         the KML file is local.

.. container:: table-row

   Property
         defaultType

   Description
         Map type on the beginning.MAP, SATELLITE, HYBRID, TERRAIN and one
         individual type are possible.

.. container:: table-row

   Property
         scrollZoom

   Description
         Enables zoom with scroll wheel.


.. container:: table-row

   Property
         draggable

   Description
         Position of the map can be changed.


.. container:: table-row

   Property
         doubleClickZoom

   Description
         A double click on the map zooms in. Draggable map has to be enabled!


.. container:: table-row

   Property
         markerSearch

   Description
         Displays a form on the frontend, were the user can enter a search
         word. Searchs for InfoWindow content and title of a marker. The
         InfoWindow of the first found marker opens.


.. container:: table-row

   Property
         showAddresses

   Description
         Displays a list with all addresses incl. a link. If you click the
         selected address will be centered.


.. container:: table-row

   Property
         showCategories

   Description
         Display a checkbox for each visible category. On change the points on
         the map will be enabled/disabled.


.. container:: table-row

   Property
         markerCluster

   Description
         Many markers in the same region will be summarized and appear as a
         cluster. e.g.: `http://google-maps-utility-library-v3.googlecode.com/s
         vn/trunk/markerclusterer/examples/advanced\_example.html <http
         ://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclust
         erer/examples/advanced_example.html>`_


.. container:: table-row

   Property
         markerClusterZoom

   Description
         Up to this zoom level the Clusters are displayed. Take a look at the
         example link above.


.. container:: table-row

   Property
         markerClusterSize

   Description
         The size of the Clusters, like a radius. Take a look at the example
         link above.


.. container:: table-row

   Property
         scaleControl

   Description
         Displays a measure.


.. container:: table-row

   Property
         streetviewControl

   Description
         Shows an icon to enable the streetview.


.. container:: table-row

   Property
         fullscreenControl

   Description
         Shows an icon to enable fullscreen.


.. container:: table-row

   Property
         zoomControl

   Description
         Enable buttons to change the zoom.


.. container:: table-row

   Property
         mapTypeControl

   Description
         Shows a control to change the map type.


.. container:: table-row

   Property
         mapTypes

   Description
         Possible map types to choose. Map type control has to be enabled.MAP,
         SATELLITE, HYBRID, TERRAIN and one individual type are possible.


.. container:: table-row

   Property
         showRoute

   Description
         2 address records needed! Shows the route between the given points


.. container:: table-row

   Property
         calcRoute

   Description
         Only 1 address used as destination. Display an text input for enter a
         starting point.

         You can configure the rendering by set the
         plugin.tx\_gomapsext.view.layoutRoothPath, copy and edit the file
         Form.html.


.. container:: table-row

   Property
         travelMode

   Description
         Select a travel mode or let the frontend user select one.

         - Select by Frontend User (Creates a select box in the frontend. You can
           configure the rendering by set the
           plugin.tx\_gomapsext.view.layoutRoothPath, copy and edit the file
           Form.html.)

         - Bicycling (at the time only available in US)

         - Driving (Default)

         - Transit

         - Walking.

         You can configure the rendering by set the
         plugin.tx\_gomapsext.view.layoutRoothPath, copy and edit the file
         Form.html.


.. container:: table-row

   Property
         UnitSystem

   Description
         Select a unit system or let the frontend user select one.

         - Default (No fix value)

         - Select by Frontend User (Creates a select box in the frontend. You can
           configure the rendering by set the
           plugin.tx\_gomapsext.view.layoutRoothPath, copy and edit the file
           Form.html.)

         - Metric (kilometer)

         - Imperial (miles).


.. container:: table-row

   Property
         styledMapName

   Description
         Shown in the map type control.


.. container:: table-row

   Property
         styledMapCode

   Description
         JSON, e.g. from `https://mapstyle.withgoogle.com/ <https://mapstyle.withgoogle.com/>`_


.. container:: table-row

   Property
         markerClusterStyle

   Description
         JSON code for the cluster style, for more information look here `https://github.com/googlemaps/js-marker-clusterer <https://github.com/googlemaps/js-marker-clusterer>`_


.. ###### END~OF~TABLE ######


Google Maps Address
"""""""""""""""""""""

A map represents addresses and/or a KML file. An address record mainly
consists of longitude, latitude and the address itself which are
configured via geocoding of the configuration map.

|img-6|

Of course there are some more options...

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         title

   Description
         Only for internal usage.

         [required]


.. container:: table-row

   Property
         configurationMap

   Description
         Shown as Position. For geocoding the latitude, longitude and address.
         Enter an address [street number, zip city] or coordinates [latitude,
         longitude] and press 'Update' or drag and drop the marker in the map.


.. container:: table-row

   Property
         latitude

   Description
         The latitude of the position. Configured via the position field.

         [required]


.. container:: table-row

   Property
         longitude

   Description
         The longitude of the position. Configured via the position
         field.[required]


.. container:: table-row

   Property
         address

   Description
         The address of the position. Configured via the position
         field.[required]


.. container:: table-row

   Property
         marker

   Description
         A costum image for the pin.


.. container:: table-row

   Property
         imageSize

   Description
         Check if the image of the marker has a different size then default. The image should be twice as large as indicated.


.. container:: table-row

   Property
         imageWidth

   Description
         Costum image width in pixel.


.. container:: table-row

   Property
         imageHeight

   Description
         Costum image height in pixel.


.. container:: table-row

   Property
         infoWindowContent

   Description
         This will be displayed in the InfoWindow of this marker.

.. container:: table-row

   Property
         infoWindowImages

   Description
         Extra field for fal images to show in the InfoWindow.


.. container:: table-row

   Property
         infoWindowLink

   Description
         Attachs an optional automatic generated link to calculate a route on
         Google Maps.


.. container:: table-row

   Property
         openByClick

   Description
         Open InfoWindow by click instead of mouse over.


.. container:: table-row

   Property
         closeByClick

   Description
         Close InfoWindow by click instead of mouse out.


.. container:: table-row

   Property
         opened

   Description
         The InfoWindow is opened when the map appears. For each map there will
         be only one opened InfoWindow.


.. container:: table-row

   Property
         categories

   Description
         Each category can be selected via GET parameters or checkboxes.


.. ###### END~OF~TABLE ######
