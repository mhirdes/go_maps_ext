<?php

namespace Clickstorm\GoMapsExt\Domain\Model;

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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Map extends AbstractEntity
{
    /**
     * Title* (without space character, special character!)
     *
     * @var \string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title;
    /**
     * in px or %
     *
     * @var \string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $width;
    /**
     * in px or %
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $height;
    /**
     * zoom
     *
     * @var int
     */
    protected $zoom;
    /**
     * zoomMin
     *
     * @var int
     */
    protected $zoomMin;
    /**
     * zoomMax
     *
     * @var int
     */
    protected $zoomMax;
    /**
     * addresses
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Address>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $addresses;
    /**
     * kmlUrl
     *
     * @var \string
     */
    protected $kmlUrl;
    /**
     * kmlPreserveViewport
     *
     * @var bool
     */
    protected $kmlPreserveViewport = false;
    /**
     * kmlLocal
     *
     * @var bool
     */
    protected $kmlLocal = false;
    /**
     * showAddresses
     *
     * @var bool
     */
    protected $showAddresses = false;
    /**
     * showCategories
     *
     * @var bool
     */
    protected $showCategories = false;
    /**
     * scrollZoom
     *
     * @var bool
     */
    protected $scrollZoom = false;
    /**
     * draggable
     *
     * @var bool
     */
    protected $draggable = false;
    /**
     * doubleClickZoom
     *
     * @var bool
     */
    protected $doubleClickZoom = false;
    /**
     * markerCluster
     *
     * @var bool
     */
    protected $markerCluster = false;
    /**
     * markerClusterZoom
     *
     * @var int
     */
    protected $markerClusterZoom;
    /**
     * markerClusterSize
     *
     * @var int
     */
    protected $markerClusterSize;
    /**
     * markerClusterStyle
     *
     * @var \string
     */
    protected $markerClusterStyle;
    /**
     * markerSearch
     *
     * @var bool
     */
    protected $markerSearch = false;
    /**
     * defaultType
     *
     * @var int
     */
    protected $defaultType;
    /**
     * previewImage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $previewImage;
    /**
     * scaleControl
     *
     * @var bool
     */
    protected $scaleControl = false;
    /**
     * streetviewControl
     *
     * @var bool
     */
    protected $streetviewControl = false;
    /**
     * fullscreenControl
     *
     * @var bool
     */
    protected $fullscreenControl = false;
    /**
     * zoomControl
     *
     * @var bool
     */
    protected $zoomControl = false;
    /**
     * mapTypeControl
     *
     * @var bool
     */
    protected $mapTypeControl = false;
    /**
     * mapTypes
     *
     * @var \string
     */
    protected $mapTypes;
    /**
     * showRoute
     *
     * @var bool
     */
    protected $showRoute = false;
    /**
     * calcRoute
     *
     * @var bool
     */
    protected $calcRoute = false;
    /**
     * travelMode
     *
     * @var int
     */
    protected $travelMode;
    /**
     * unitSystem
     *
     * @var int
     */
    protected $unitSystem;
    /**
     * styledMapName
     *
     * @var \string
     */
    protected $styledMapName;
    /**
     * styledMapCode
     *
     * @var \string
     */
    protected $styledMapCode;
    /**
     * showForm
     *
     * @var bool
     */
    protected $showForm = false;
    /**
     * travelModes
     *
     * @var \array
     */
    protected $travelModes = [];
    /**
     * unitSystems
     *
     * @var \array
     */
    protected $unitSystems = [];
    /**
     * latitude
     *
     * @var \float
     */
    protected $latitude;
    /**
     * longitude
     *
     * @var \float
     */
    protected $longitude;
    /**
     * geolocation
     *
     * @var bool
     */
    protected $geolocation = false;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->addresses = new ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return \string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param \string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the width
     */
    public function getWidth()
    {
        return is_numeric($this->width) ? $this->width . 'px' : $this->width;
    }

    /**
     * Sets the width
     *
     * @param \string $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Returns the height
     *
     * @return \string $height
     */
    public function getHeight()
    {
        return is_numeric($this->height) ? $this->height . 'px' : $this->height;
    }

    /**
     * Sets the height
     *
     * @param \string $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Returns the zoom
     *
     * @return int $zoom
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * Sets the zoom
     *
     * @param int $zoom
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
    }

    /**
     * Returns the zoomMin
     *
     * @return int $zoomMin
     */
    public function getZoomMin()
    {
        return $this->zoomMin;
    }

    /**
     * Sets the zoomMin
     *
     * @param int $zoomMin
     */
    public function setZoomMin($zoomMin)
    {
        $this->zoomMin = $zoomMin;
    }

    /**
     * Returns the zoomMax
     *
     * @return int $zoomMax
     */
    public function getZoomMax()
    {
        return $this->zoomMax;
    }

    /**
     * Sets the zoomMax
     *
     * @param int $zoomMax
     */
    public function setZoomMax($zoomMax)
    {
        $this->zoomMax = $zoomMax;
    }

    /**
     * Adds a Address
     *
     * @param \Clickstorm\GoMapsExt\Domain\Model\Address $address
     */
    public function addAddress(Address $address)
    {
        $this->addresses->attach($address);
    }

    /**
     * Removes a Address
     *
     * @param \Clickstorm\GoMapsExt\Domain\Model\Address $addressToRemove The Address to be removed
     */
    public function removeAddress(Address $addressToRemove)
    {
        $this->addresses->detach($addressToRemove);
    }

    /**
     * Returns the addresses
     *
     * @return ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Address> $addresses
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Sets the addresses
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Address> $addresses
     */
    public function setAddresses(ObjectStorage $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * Returns the kmlUrl
     *
     * @return \string $kmlUrl
     */
    public function getKmlUrl()
    {
        return $this->kmlUrl;
    }

    /**
     * Sets the kmlUrl
     *
     * @param \string $kmlUrl
     */
    public function kmlUrl($kmlUrl)
    {
        $this->kmlUrl = $kmlUrl;
    }

    /**
     * Returns the kmlPreserveViewport
     *
     * @return bool $kmlPreserveViewport
     */
    public function getKmlPreserveViewport()
    {
        return $this->kmlPreserveViewport;
    }

    /**
     * Returns the boolean state of kmlPreserveViewport
     *
     * @return bool
     */
    public function isKmlPreserveViewport()
    {
        return $this->getKmlPreserveViewport();
    }

    /**
     * Sets the kmlPreserveViewport
     *
     * @param bool $kmlPreserveViewport
     */
    public function setKmlPreserveViewport($kmlPreserveViewport)
    {
        $this->kmlPreserveViewport = $kmlPreserveViewport;
    }

    /**
     * Returns the kmlLocal
     *
     * @return bool $kmlLocal
     */
    public function getKmlLocal()
    {
        return $this->kmlLocal;
    }

    /**
     * Returns the boolean state of kmlLocal
     *
     * @return bool
     */
    public function isKmlLocal()
    {
        return $this->getKmlLocal();
    }

    /**
     * Sets the kmlLocal
     *
     * @param bool $kmlLocal
     */
    public function setKmlLocal($kmlLocal)
    {
        $this->kmlLocal = $kmlLocal;
    }

    /**
     * Returns the showAddresses
     *
     * @return bool $showAddresses
     */
    public function getShowAddresses()
    {
        return $this->showAddresses;
    }

    /**
     * Sets the showAddresses
     *
     * @param bool $showAddresses
     */
    public function setShowAddresses($showAddresses)
    {
        $this->showAddresses = $showAddresses;
    }

    /**
     * Returns the showCategories
     *
     * @return bool $showCategories
     */
    public function getShowCategories()
    {
        return $this->showCategories;
    }

    /**
     * Returns the boolean state of showCategories
     *
     * @return bool
     */
    public function isShowCategories()
    {
        return $this->getShowCategories();
    }

    /**
     * Sets the showCategories
     *
     * @param bool $showCategories
     */
    public function setShowCategories($showCategories)
    {
        $this->showCategories = $showCategories;
    }

    /**
     * Returns the scrollZoom
     *
     * @return bool $scrollZoom
     */
    public function getScrollZoom()
    {
        return $this->scrollZoom;
    }

    /**
     * Returns the boolean state of scrollZoom
     *
     * @return bool
     */
    public function isScrollZoom()
    {
        return $this->getScrollZoom();
    }

    /**
     * Sets the scrollZoom
     *
     * @param bool $scrollZoom
     */
    public function setScrollZoom($scrollZoom)
    {
        $this->scrollZoom = $scrollZoom;
    }

    /**
     * Returns the draggable
     *
     * @return bool $draggable
     */
    public function getDraggable()
    {
        return $this->draggable;
    }

    /**
     * Returns the boolean state of draggable
     *
     * @return bool
     */
    public function isDraggable()
    {
        return $this->getDraggable();
    }

    /**
     * Sets the draggable
     *
     * @param bool $draggable
     */
    public function setDraggable($draggable)
    {
        $this->draggable = $draggable;
    }

    /**
     * Returns the doubleClickZoom
     *
     * @return bool $doubleClickZoom
     */
    public function getDoubleClickZoom()
    {
        return $this->doubleClickZoom;
    }

    /**
     * Returns the boolean state of doubleClickZoom
     *
     * @return bool
     */
    public function isDoubleClickZoom()
    {
        return $this->getDoubleClickZoom();
    }

    /**
     * Sets the doubleClickZoom
     *
     * @param bool $doubleClickZoom
     */
    public function setDoubleClickZoom($doubleClickZoom)
    {
        $this->doubleClickZoom = $doubleClickZoom;
    }

    /**
     * Returns the markerCluster
     *
     * @return bool $markerCluster
     */
    public function getMarkerCluster()
    {
        return $this->markerCluster;
    }

    /**
     * Returns the boolean state of markerCluster
     *
     * @return bool
     */
    public function isMarkerCluster()
    {
        return $this->getMarkerCluster();
    }

    /**
     * Sets the markerCluster
     *
     * @param bool $markerCluster
     */
    public function setMarkerCluster($markerCluster)
    {
        $this->markerCluster = $markerCluster;
    }

    /**
     * Returns the markerClusterZoom
     *
     * @return int $markerClusterZoom
     */
    public function getMarkerClusterZoom()
    {
        return $this->markerClusterZoom;
    }

    /**
     * Sets the markerClusterZoom
     *
     * @param int $markerClusterZoom
     */
    public function setMarkerClusterZoom($markerClusterZoom)
    {
        $this->markerClusterZoom = $markerClusterZoom;
    }

    /**
     * Returns the markerClusterSize
     *
     * @return int $markerClusterSize
     */
    public function getMarkerClusterSize()
    {
        return $this->markerClusterSize;
    }

    /**
     * Sets the markerClusterSize
     *
     * @param int $markerClusterSize
     */
    public function setMarkerClusterSize($markerClusterSize)
    {
        $this->markerClusterSize = $markerClusterSize;
    }

    /**
     * Returns the markerClusterStyle
     *
     * @return \string $markerClusterStyle
     */
    public function getMarkerClusterStyle()
    {
        return $this->markerClusterStyle;
    }

    /**
     * Sets the markerClusterStyle
     *
     * @param \string $markerClusterStyle
     */
    public function setMarkerClusterStyle($markerClusterStyle)
    {
        $this->markerClusterStyle = $markerClusterStyle;
    }

    /**
     * Returns the markerSearch
     *
     * @return bool $markerSearch
     */
    public function getMarkerSearch()
    {
        return $this->markerSearch;
    }

    /**
     * Returns the boolean state of markerSearch
     *
     * @return bool
     */
    public function isMarkerSearch()
    {
        return $this->getMarkerSearch();
    }

    /**
     * Sets the markerSearch
     *
     * @param bool $markerSearch
     */
    public function setMarkerSearch($markerSearch)
    {
        $this->markerSearch = $markerSearch;
    }

    /**
     * Returns the defaultType
     *
     * @return int $defaultType
     */
    public function getDefaultType()
    {
        return $this->defaultType;
    }

    /**
     * Sets the defaultType
     *
     * @param int $defaultType
     */
    public function setDefaultType($defaultType)
    {
        $this->defaultType = $defaultType;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getPreviewImage()
    {
        return $this->previewImage;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $previewImage
     */
    public function setPreviewImage($previewImage)
    {
        $this->previewImage = $previewImage;
    }

    /**
     * Returns the scaleControl
     *
     * @return bool $scaleControl
     */
    public function getScaleControl()
    {
        return $this->scaleControl;
    }

    /**
     * Returns the boolean state of scaleControl
     *
     * @return bool
     */
    public function isScaleControl()
    {
        return $this->getScaleControl();
    }

    /**
     * Sets the scaleControl
     *
     * @param bool $scaleControl
     */
    public function setScaleControl($scaleControl)
    {
        $this->scaleControl = $scaleControl;
    }

    /**
     * Returns the streetviewControl
     *
     * @return bool $streetviewControl
     */
    public function getStreetviewControl()
    {
        return $this->streetviewControl;
    }

    /**
     * Returns the boolean state of streetviewControl
     *
     * @return bool
     */
    public function isStreetviewControl()
    {
        return $this->getStreetviewControl();
    }

    /**
     * Sets the streetviewControl
     *
     * @param bool $streetviewControl
     */
    public function setStreetviewControl($streetviewControl)
    {
        $this->streetviewControl = $streetviewControl;
    }

    /**
     * Returns the fullscreenControl
     *
     * @return bool $fullscreenControl
     */
    public function getFullscreenControl()
    {
        return $this->fullscreenControl;
    }

    /**
     * Returns the boolean state of fullscreenControl
     *
     * @return bool
     */
    public function isFullscreenControl()
    {
        return $this->getFullscreenControl();
    }

    /**
     * Sets the fullscreenControl
     *
     * @param bool $fullscreenControl
     */
    public function setFullscreenControl($fullscreenControl)
    {
        $this->fullscreenControl = $fullscreenControl;
    }

    /**
     * Returns the zoomControl
     *
     * @return bool $zoomControl
     */
    public function getZoomControl()
    {
        return $this->zoomControl;
    }

    /**
     * Returns the boolean state of zoomControl
     *
     * @return bool
     */
    public function isZoomControl()
    {
        return $this->getZoomControl();
    }

    /**
     * Sets the zoomControl
     *
     * @param bool $zoomControl
     */
    public function setZoomControl($zoomControl)
    {
        $this->zoomControl = $zoomControl;
    }

    /**
     * Returns the mapTypeControl
     *
     * @return bool $mapTypeControl
     */
    public function getMapTypeControl()
    {
        return $this->mapTypeControl;
    }

    /**
     * Returns the boolean state of mapTypeControl
     *
     * @return bool
     */
    public function isMapTypeControl()
    {
        return $this->getMapTypeControl();
    }

    /**
     * Sets the mapTypeControl
     *
     * @param bool $mapTypeControl
     */
    public function setMapTypeControl($mapTypeControl)
    {
        $this->mapTypeControl = $mapTypeControl;
    }

    /**
     * Returns the mapTypes
     *
     * @return \string $mapTypes
     */
    public function getMapTypes()
    {
        return explode(',', $this->mapTypes);
    }

    /**
     * Sets the mapTypes
     *
     * @param \string $mapTypes
     */
    public function setMapTypes($mapTypes)
    {
        $this->mapTypes = $mapTypes;
    }

    /**
     * Returns the showRoute
     *
     * @return bool $showRoute
     */
    public function getShowRoute()
    {
        return $this->showRoute;
    }

    /**
     * Returns the boolean state of showRoute
     *
     * @return bool
     */
    public function isShowRoute()
    {
        return $this->getShowRoute();
    }

    /**
     * Sets the showRoute
     *
     * @param bool $showRoute
     */
    public function setShowRoute($showRoute)
    {
        $this->showRoute = $showRoute;
    }

    /**
     * Returns the styledMapName
     *
     * @return \string $styledMapName
     */
    public function getStyledMapName()
    {
        return $this->styledMapName;
    }

    /**
     * Sets the styledMapName
     *
     * @param \string $styledMapName
     */
    public function setStyledMapName($styledMapName)
    {
        $this->styledMapName = $styledMapName;
    }

    /**
     * Returns the styledMapCode
     *
     * @return \string $styledMapCode
     */
    public function getStyledMapCode()
    {
        return $this->styledMapCode;
    }

    /**
     * Sets the styledMapCode
     *
     * @param \string $styledMapCode
     */
    public function setStyledMapCode($styledMapCode)
    {
        $this->styledMapCode = $styledMapCode;
    }

    /**
     * Returns the setForm
     *
     * @return bool $showForm
     */
    public function getShowForm()
    {
        if ($this->getCalcRoute() == 1 || $this->getTravelMode() == 1 || $this->getUnitSystem() == 1) {
            return true;
        }
        return false;
    }

    /**
     * Returns the calcRoute
     *
     * @return bool $calcRoute
     */
    public function getCalcRoute()
    {
        return $this->calcRoute;
    }

    /**
     * Returns the boolean state of calcRoute
     *
     * @return bool
     */
    public function isCalcRoute()
    {
        return $this->getCalcRoute();
    }

    /**
     * Sets the calcRoute
     *
     * @param bool $calcRoute
     */
    public function setCalcRoute($calcRoute)
    {
        $this->calcRoute = $calcRoute;
    }

    /**
     * Returns the travelMode
     *
     * @return int $travelMode
     */
    public function getTravelMode()
    {
        return $this->travelMode;
    }

    /**
     * Sets the travelMode
     *
     * @param int $travelMode
     */
    public function setTravelMode($travelMode)
    {
        $this->travelMode = $travelMode;
    }

    /**
     * Returns the unitSystem
     *
     * @return int $unitSystem
     */
    public function getUnitSystem()
    {
        return $this->unitSystem;
    }

    /**
     * Sets the unitSystem
     *
     * @param int $unitSystem
     */
    public function setUnitSystem($unitSystem)
    {
        $this->unitSystem = $unitSystem;
    }

    /**
     * Returns the travelModes
     *
     * @return \array $travelModes
     */
    public function getTravelModes()
    {
        $travelModes = [];
        for ($i = 0; $i <= 4; $i++) {
            $travelModes[$i] = LocalizationUtility::translate(
                'tx_gomapsext_domain_model_map.travel_mode.' . $i,
                'go_maps_ext'
            );
        }

        return $travelModes;
    }

    /**
     * Returns the unitSystems
     *
     * @return \array $unitSystems
     */
    public function getUnitSystems()
    {
        for ($i = 2; $i <= 3; $i++) {
            $unitSystems[$i] = LocalizationUtility::translate(
                'tx_gomapsext_domain_model_map.unit_system.' . $i,
                'go_maps_ext'
            );
        }

        return $unitSystems;
    }

    /**
     * Returns the latitude
     *
     * @return \float $latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     *
     * @param \float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Returns the longitude
     *
     * @return \float $longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     *
     * @param \float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Returns the geolocation
     *
     * @return bool $geolocation
     */
    public function getGeolocation()
    {
        return $this->geolocation;
    }

    /**
     * Returns the boolean state of geolocation
     *
     * @return bool
     */
    public function isGeolocation()
    {
        return $this->getGeolocation();
    }

    /**
     * Sets the geolocation
     *
     * @param bool $geolocation
     */
    public function setGeolocation($geolocation)
    {
        $this->geolocation = $geolocation;
    }
}
