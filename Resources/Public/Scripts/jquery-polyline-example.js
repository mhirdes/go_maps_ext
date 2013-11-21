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

// Google Polylines (https://developers.google.com/maps/documentation/javascript/overlays?#Polylines)

// add the Polygon to go_maps_ext-Map
jQuery(document).ready(function() {
	// Get element with ID (title) of the Map
	var element = jQuery('#Example');
	var polylineCoords = [];
	
	// get positions of markers
	jQuery.each(element.data("markers"), function(key, marker) {
		polylineCoords.push(marker.getPosition());
	});
	
	// configure the polyline
	var polyline = new google.maps.Polyline({
		path: polylineCoords,
		strokeColor: "#FF0000",
		strokeOpacity: 1.0,
		strokeWeight: 2
	});
	
	// add the polyline to the map
	polyline.setMap(element.data("map"));
});