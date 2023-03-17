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

// Google Polygon (https://developers.google.com/maps/documentation/javascript/overlays)
document.addEventListener("DOMContentLoaded", () => {
	// Get element with ID (title) of the Map
	const element = document.querySelector('#Example');
	const polygonCoords = [];

	// get positions of markers
	for (const marker of element.gomapsext.markers) {
		polygonCoords.push(marker.getPosition());
	}

	// configure the polygon
	const polygon = new google.maps.Polygon({
		paths: polygonCoords,
		strokeColor: "#FF0000",
		strokeOpacity: 1.0,
		strokeWeight: 2,
		fillColor: "#FF0000",
		fillOpacity: 0.35
	});

	// add the polygon to the map
	polygon.setMap(element.gomapsext.map);
});
