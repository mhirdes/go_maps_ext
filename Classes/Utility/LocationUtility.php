<?php

namespace Clickstorm\GoMapsExt\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Xavier Perseguers <xavier@causal.ch>, Causal
 *  (c) 2015 Marc Hirdes <hirdes@clicsktorm.de>, clickstorm GmbH
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
class LocationUtility {

	/**
	 * Renders the Google map.
	 *
	 * @param array $PA
	 * @param t3lib_TCEforms $pObj
	 * @return string
	 */
	public function render(array &$PA, $pObj) {
		$version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
		$settings = $this->loadTS($PA['row']['pid']);
		$googleMapsLibrary = $settings['plugin.']['tx_gomapsext.']['settings.']['googleMapsLibrary'] ?
			htmlentities($settings['plugin.']['tx_gomapsext.']['settings.']['googleMapsLibrary']) :
			'//maps.google.com/maps/api/js?v=3.17&amp;sensor=false';

		$out = array();
		$latitude = (float)$PA['row'][$PA['parameters']['latitude']];
		$longitude = (float)$PA['row'][$PA['parameters']['longitude']];
		$address = $PA['row'][$PA['parameters']['address']];

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
		$updateLatitudeJs = sprintf(
			$updateJs,
			$PA['table'],
			$PA['row']['uid'],
			$PA['parameters']['latitude'],
			$latitudeField
		);
		$updateLongitudeJs = sprintf(
			$updateJs,
			$PA['table'],
			$PA['row']['uid'],
			$PA['parameters']['longitude'],
			$longitudeField
		);
		$updateAddressJs = sprintf(
			$updateJs,
			$PA['table'],
			$PA['row']['uid'],
			$PA['parameters']['address'],
			$addressField
		);

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

        // update fields
		TxClimbingSites.updateValue('{$latitudeField}', lat);
        TxClimbingSites.updateValue('{$longitudeField}', lng);

		// Update address
		TxClimbingSites.reverseGeocode(TxClimbingSites.marker.getPosition().lat(), TxClimbingSites.marker.getPosition().lng());
		
		// Update Position
		var position = document.getElementById("{$addressId}");
		position.value = lat + "," + lng;
		
		// Tell TYPO3 that fields were updated
		TxClimbingSites.positionChanged();
	});
	TxClimbingSites.geocoder = new google.maps.Geocoder();

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
		TxClimbingSites.updateValue('{$latitudeField}', lat);
        TxClimbingSites.updateValue('{$longitudeField}', lng);

		// Get Address
		TxClimbingSites.reverseGeocode(lat, lng);
	} else {
		TxClimbingSites.geocoder.geocode({'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				// Get Position
				lat = results[0].geometry.location.lat().toFixed(6);
				lng = results[0].geometry.location.lng().toFixed(6);

				formatedAddress = results[0].formatted_address
				
				// Update Map
				TxClimbingSites.map.setCenter(results[0].geometry.location);
				TxClimbingSites.marker.setPosition(results[0].geometry.location);
				
				// Update fields
                TxClimbingSites.updateValue('{$latitudeField}', lat);
                TxClimbingSites.updateValue('{$longitudeField}', lng);
                TxClimbingSites.updateValue('{$addressField}', formatedAddress);

                TxClimbingSites.positionChanged();
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}
}

TxClimbingSites.positionChanged = function() {
    {$updateLatitudeJs}
    {$updateLongitudeJs}
    {$updateAddressJs}
    TYPO3.FormEngine.Validation.validate();
}

TxClimbingSites.updateValue = function(fieldName, value) {
    var version = {$version};
    document[TBE_EDITOR.formname][fieldName].value = value;
    if(version < 7005000) {
        document[TBE_EDITOR.formname][fieldName + '_hr'].value = value;
    } else {
        TYPO3.jQuery('[data-formengine-input-name="' + fieldName + '"]').val(value);
    }
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
		    TxClimbingSites.updateValue('{$addressField}', results[1].formatted_address);
			TxClimbingSites.positionChanged();
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

            TxClimbingSites.updateValue('{$latitudeField}', lat);
            TxClimbingSites.updateValue('{$longitudeField}', lng);

			// Update visible fields
			addressInput.value = addressOld;
			
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

	protected function loadTS($pageUid) {
		$sysPageObj = \TYPO3\CMS\Core\Utility\GeneralUtility ::makeInstance(
			'TYPO3\\CMS\\Frontend\\Page\\PageRepository'
		);
		$rootLine = $sysPageObj->getRootLine($pageUid);
		$TSObj = \TYPO3\CMS\Core\Utility\GeneralUtility ::makeInstance(
			'TYPO3\\CMS\\Core\\TypoScript\\ExtendedTemplateService'
		);
		$TSObj->tt_track = 0;
		$TSObj->init();
		$TSObj->runThroughTemplates($rootLine);
		$TSObj->generateConfig();

		return $TSObj->setup;
	}
}

?>
