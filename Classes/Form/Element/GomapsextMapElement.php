<?php

namespace Clickstorm\GoMapsExt\Form\Element;

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

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Google map.
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class GomapsextMapElement extends AbstractFormElement
{

    /**
     * Renders the Google map
     */
    public function render(): array
    {
        $resultArray = $this->initializeResultArray();

        $pluginSettings = static::getSettings();

        $googleMapsLibrary = $pluginSettings['googleMapsLibrary'] ?? ' //maps.google.com/maps/api/js?v=weekly';

        if (isset($pluginSettings['apiKey']) && !empty($pluginSettings['apiKey'])) {
            $googleMapsLibrary .= '&key=' . $pluginSettings['apiKey'];
        }

        $out = [];
        $latitude = (float)$this->data['databaseRow'][$this->data['parameterArray']['fieldConf']['config']['parameters']['latitude']];
        $longitude = (float)$this->data['databaseRow'][$this->data['parameterArray']['fieldConf']['config']['parameters']['longitude']];
        $address = $this->data['databaseRow'][$this->data['parameterArray']['fieldConf']['config']['parameters']['address']];

        $baseElementId = isset($this->data['databaseRow']['uid']) ? $this->data['databaseRow']['uid'] : $this->data['tableName'] . '_map';
        $addressId = $baseElementId . '_address';
        $mapId = $baseElementId . '_map';

        if (!($latitude && $longitude)) {
            $latitude = 0;
            $longitude = 0;
        }
        $dataPrefix = 'data[' . $this->data['tableName'] . '][' . $this->data['databaseRow']['uid'] . ']';
        $latitudeField = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['latitude'] . ']';
        $longitudeField = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['longitude'] . ']';
        $addressField = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['address'] . ']';
        $streetFieldName = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['street'] . ']';
        $zipFieldName = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['zip'] . ']';
        $cityFieldName = $dataPrefix . '[' . $this->data['parameterArray']['fieldConf']['config']['parameters']['city'] . ']';

        $updateJs = 'document.querySelector(\'[name="data[%s][%s][%s]"]\').dispatchEvent(new Event(\'change\', {bubbles: true, cancelable: true}));';
        $updateLatitudeJs = sprintf(
            $updateJs,
            $this->data['tableName'],
            $this->data['databaseRow']['uid'],
            'latitude'
        );
        $updateLongitudeJs = sprintf(
            $updateJs,
            $this->data['tableName'],
            $this->data['databaseRow']['uid'],
            'longitude'
        );
        $updateAddressJs = sprintf(
            $updateJs,
            $this->data['tableName'],
            $this->data['databaseRow']['uid'],
            'address'
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
	
	if(document.getElementsByName("{$streetFieldName}")[0] && 
	    document.getElementsByName("{$streetFieldName}")[0] && 
	    document.getElementsByName("{$streetFieldName}")[0]) {
	    var button = document.getElementById('gme-btn-address').style.display = 'inline-block';
	}
	
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

TxClimbingSites.localize = function(address) {
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
		TxClimbingSites.localize(address);
	}
}

TxClimbingSites.codeByAddress = function() {
	var street = document.getElementsByName("{$streetFieldName}")[0].value,
	    zip = document.getElementsByName("{$zipFieldName}")[0].value,
	    city = document.getElementsByName("{$cityFieldName}")[0].value,
	    address = street + ',' + zip + ' ' + city;
	    	
    TxClimbingSites.localize(address);
}

TxClimbingSites.positionChanged = function() {
    {$updateLatitudeJs}
    {$updateLongitudeJs}
    {$updateAddressJs}
    TYPO3.FormEngine.Validation.validate();
}

TxClimbingSites.updateValue = function(fieldName, value) {
    document['editform'][fieldName].value = value;
    document.querySelector('[data-formengine-input-name="' + fieldName + '"]').value = value;
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
			<input type="text" 
			       class="form-control" 
			       value="' . $address . '" 
			       id="' . $addressId . '" 
			       style="display:inline-block;width:300px">
			<input type="button" 
			       value="' . LocalizationUtility::translate('update_by_position', 'go_maps_ext') . '" 
			       class="btn btn-sm btn-default"
			       onclick="TxClimbingSites.codeAddress()">
			<input id="gme-btn-address"
			       type="button" 
			       value="' . LocalizationUtility::translate('update_by_address', 'go_maps_ext') . '" 
			       class="btn btn-sm btn-default"
			       style="display:none;"
			       onclick="TxClimbingSites.codeByAddress()">
		';
        $out[] = '<div id="' . $mapId . '" style="height:400px;margin:10px 0;width:400px"></div>';
        $out[] = '</div>'; // id=$baseElementId

        $resultArray['html'] = implode('', $out);

        return $resultArray;
    }

    /**
     * Get definitive TypoScript Settings from
     * plugin.tx_gomapsext.settings.
     */
    private static function getSettings(): array
    {
        return GeneralUtility::makeInstance(ConfigurationManagerInterface::class)
            ->getConfiguration(
                ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
            )['plugin.']['tx_gomapsext.']['settings.'] ?? [];
    }
}
