<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Xavier Perseguers <xavier@causal.ch>, Causal S� rl
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

/**
 * Google map.
 *
 * @package climbing_sites
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class tx_gomapsext_tca {

	/**
	 * Renders the Google map.
	 *
	 * @param array $PA
	 * @param t3lib_TCEforms $pObj
	 * @return string
	 */
	public function render(array &$PA, t3lib_TCEforms $pObj) {
		$version = t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version);
		$this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['go_maps_ext']);
		$googleMapsLibrary = $this->extConf['googleMapsLibrary'] ? $this->extConf['googleMapsLibrary'] :'http://maps.google.com/maps/api/js?v=3.12&amp;sensor=false';
		if ($version < 4006000) {
			$PA['parameters'] = array(
				'latitude' => 'latitude',
				'longitude' => 'longitude',
				'address' => 'address'
			);
		}

		$out = array();
		$latitude = (float) $PA['row'][$PA['parameters']['latitude']];
		$longitude = (float) $PA['row'][$PA['parameters']['longitude']];
		$address =  $PA['row'][$PA['parameters']['address']];
		
		$baseElementId = isset($PA['itemFormElID']) ? $PA['itemFormElID'] : $PA['table'] . '_map';
		$addressId = $baseElementId . '_address';
		$mapId = $baseElementId . '_map';

		if (!($latitude && $longitude)) {
			$latitude = 0;
			$longitude = 0;
		};
		$dataPrefix = 'data[' . $PA['table'] . '][' . $PA['row']['uid'] . ']';
		$latitudeField = $dataPrefix . '[' . $PA['parameters']['latitude'] . ']';
		$longitudeField = $dataPrefix . '[' . $PA['parameters']['longitude'] . ']';
		$addressField = $dataPrefix . '[' . $PA['parameters']['address'] . ']';

		$updateJs = "TBE_EDITOR.fieldChanged('%s','%s','%s','%s');";
		$updateLatitudeJs = sprintf($updateJs, $PA['table'], $PA['row']['uid'], $PA['parameters']['latitude'], $latitudeField);
		$updateLongitudeJs = sprintf($updateJs, $PA['table'], $PA['row']['uid'], $PA['parameters']['longitude'], $longitudeField);
		$updateAddressJs = sprintf($updateJs, $PA['table'], $PA['row']['uid'], $PA['parameters']['address'], $addressField);
		
		$out[] = '<script type="text/javascript" src="' . $googleMapsLibrary . '"></script>';
		$out[] = '<script type="text/javascript">';
		$out[] = <<<EOT
if (typeof TxClimbingSites == 'undefined') TxClimbingSites = {};

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ''); } 

TxClimbingSites.init = function() {
	TxClimbingSites.origin = new google.maps.LatLng({$latitude}, {$longitude});
	var myOptions = {
		zoom: 12,
		center: TxClimbingSites.origin,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	TxClimbingSites.map = new google.maps.Map(document.getElementById("{$mapId}"), myOptions);
	TxClimbingSites.marker = new google.maps.Marker({
		map: TxClimbingSites.map,
		position: TxClimbingSites.origin,
		draggable: true
	});
	google.maps.event.addListener(TxClimbingSites.marker, 'dragend', function() {
		var lat = TxClimbingSites.marker.getPosition().lat().toFixed(6);
		var lng = TxClimbingSites.marker.getPosition().lng().toFixed(6);

		// Update visible fields
		document[TBE_EDITOR.formname]['{$latitudeField}_hr'].value = lat;
		document[TBE_EDITOR.formname]['{$longitudeField}_hr'].value = lng;

		// Update hidden (real) fields
		document[TBE_EDITOR.formname]['{$latitudeField}'].value = lat;
		document[TBE_EDITOR.formname]['{$longitudeField}'].value = lng;

		// Update address
		TxClimbingSites.reverseGeocode(TxClimbingSites.marker.getPosition().lat(), TxClimbingSites.marker.getPosition().lng());
		
		// Update Position
		var position = document.getElementById("{$addressId}");
		position.value = lat + "," + lng;
		
		// Tell TYPO3 that fields were updated
		{$updateLatitudeJs}
		{$updateLongitudeJs}
		{$updateAddressJs}
	});
	TxClimbingSites.geocoder = new google.maps.Geocoder();

	// Make sure to refresh Google Map if corresponding tab is not yet active
	TxClimbingSites.tabPrefix = Ext.fly('{$mapId}').findParentNode('[id$="-DIV"]').id;
	TxClimbingSites.tabPrefix = Ext.util.Format.substr(TxClimbingSites.tabPrefix, 0, TxClimbingSites.tabPrefix.length - 4);
	if (Ext.fly(TxClimbingSites.tabPrefix + '-DIV').getStyle('display') == 'none') {
		Ext.fly(TxClimbingSites.tabPrefix + '-MENU').on('click', TxClimbingSites.refreshMap);
	}
};

TxClimbingSites.refreshMap = function() {
	google.maps.event.trigger(TxClimbingSites.map, 'resize');
	TxClimbingSites.map.setCenter(TxClimbingSites.marker.getPosition());
	// No need to do it again
	Ext.fly(TxClimbingSites.tabPrefix + '-MENU').un('click', TxClimbingSites.refreshMap);
}
/***************************/
TxClimbingSites.codeAddress = function() {
	var address = document.getElementById("{$addressId}").value;
	var lat = 0;
	var lng = 0;
	if(address.match(/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/)) {
		// Get Position
		lat = address.substr(0, address.lastIndexOf(',')).trim();
		lng = address.substr(address.lastIndexOf(',')+1).trim();
		position = new google.maps.LatLng(lat, lng);
		
		// Update Map
		TxClimbingSites.map.setCenter(position);
		TxClimbingSites.marker.setPosition(position);
		
		// Update visible fields
		document[TBE_EDITOR.formname]['{$latitudeField}_hr'].value = lat;
		document[TBE_EDITOR.formname]['{$longitudeField}_hr'].value = lng;
				
		// Update hidden (real) fields
		document[TBE_EDITOR.formname]['{$latitudeField}'].value = lat;
		document[TBE_EDITOR.formname]['{$longitudeField}'].value = lng;
		
		// Get Address
		TxClimbingSites.reverseGeocode(lat, lng);
	} else {
		TxClimbingSites.geocoder.geocode({'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				// Get Position
				lat = TxClimbingSites.marker.getPosition().lat().toFixed(6);
				lng = TxClimbingSites.marker.getPosition().lng().toFixed(6);
				formatedAddress = results[0].formatted_address
				
				// Update Map
				TxClimbingSites.map.setCenter(results[0].geometry.location);
				TxClimbingSites.marker.setPosition(results[0].geometry.location);
				
				// Update visible fields
				document[TBE_EDITOR.formname]['{$latitudeField}_hr'].value = lat;
				document[TBE_EDITOR.formname]['{$longitudeField}_hr'].value = lng;
				document[TBE_EDITOR.formname]['{$addressField}_hr'].value = formatedAddress;
				
				// Update hidden (real) fields
				document[TBE_EDITOR.formname]['{$latitudeField}'].value = lat;
				document[TBE_EDITOR.formname]['{$longitudeField}'].value = lng;
				document[TBE_EDITOR.formname]['{$addressField}'].value = formatedAddress;
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}
	{$updateLatitudeJs}
	{$updateLongitudeJs}
	{$updateAddressJs}
}

TxClimbingSites.setMarker = function(lat, lng) {
	var addressInput = document.getElementById("{$addressId}");
	var latlng = new google.maps.LatLng(lat, lng);
	TxClimbingSites.geocoder.geocode({'latLng': latlng}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			TxClimbingSites.map.setCenter(results[0].geometry.location);
			TxClimbingSites.marker.setPosition(results[0].geometry.location);
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
}

TxClimbingSites.reverseGeocode = function(latitude, longitude) {
	var latlng = new google.maps.LatLng(latitude, longitude);
	TxClimbingSites.geocoder.geocode({'latLng': latlng}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK && results[1]) {
			document[TBE_EDITOR.formname]['{$addressField}'].value = results[1].formatted_address;
			document[TBE_EDITOR.formname]['{$addressField}_hr'].value = results[1].formatted_address;
		}
	});
}

TxClimbingSites.convertAddress = function(addressOld) {
	addressInput = document.getElementById("{$addressId}");
	
	TxClimbingSites.geocoder.geocode({'address':addressOld}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			TxClimbingSites.map.setCenter(results[0].geometry.location);
			TxClimbingSites.marker.setPosition(results[0].geometry.location);
			var lat = TxClimbingSites.marker.getPosition().lat().toFixed(6);
			var lng = TxClimbingSites.marker.getPosition().lng().toFixed(6);

			// Update visible fields
			document[TBE_EDITOR.formname]['{$latitudeField}_hr'].value = lat;
			document[TBE_EDITOR.formname]['{$longitudeField}_hr'].value = lng;
			addressInput.value = addressOld;
			
			// Update hidden (real) fields
			document[TBE_EDITOR.formname]['{$latitudeField}'].value = lat;
			document[TBE_EDITOR.formname]['{$longitudeField}'].value = lng;
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
}

window.onload = TxClimbingSites.init;
EOT;
		$out[] = '</script>';
		$out[] = '<div id="' . $baseElementId . '">';
		$out[] = '
			<input id="' . $addressId . '" type="textbox" value="' . $address . '" style="width:300px">
			<input type="button" value="Update" onclick="TxClimbingSites.codeAddress()">
		';
		$out[] = '<div id="' . $mapId . '" style="height:400px;margin:10px 0;width:400px"></div>';
		$out[] = '</div>'; // id=$baseElementId

		return implode('', $out);
	}
}

?>