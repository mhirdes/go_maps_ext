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

/**
 *
 *
 * @package go_maps_ext
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Map extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Title* (without space character, special character!)
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * tooltipTitle
	 *
	 * @var \string
	 */
	protected $tooltipTitle;

	/**
	 * class
	 *
	 * @var \string
	 */
	protected $class;

	/**
	 * in px or %
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $width;

	/**
	 * in px or %
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $height;

	/**
	 * zoom
	 *
	 * @var \integer
	 */
	protected $zoom;

    /**
     * zoomMin
     *
     * @var \integer
     */
    protected $zoomMin;

    /**
     * zoomMax
     *
     * @var \integer
     */
    protected $zoomMax;
	
	/**
	 * addresses
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Address>
	 * @lazy
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
	 * @var boolean
	 */
	protected $kmlPreserveViewport = FALSE;
	
	/**
	 * kmlLocal
	 *
	 * @var boolean
	 */
	protected $kmlLocal = FALSE;

    /**
     * showCategories
     *
     * @var boolean
     */
    protected $showCategories = FALSE;

	/**
	 * scrollZoom
	 *
	 * @var boolean
	 */
	protected $scrollZoom = FALSE;

	/**
	 * draggable
	 *
	 * @var boolean
	 */
	protected $draggable = FALSE;

	/**
	 * doubleClickZoom
	 *
	 * @var boolean
	 */
	protected $doubleClickZoom = FALSE;
	
	/**
	 * markerCluster
	 *
	 * @var boolean
	 */
	protected $markerCluster = FALSE;
	
	/**
	 * markerClusterZoom
	 *
	 * @var \integer
	 */
	protected $markerClusterZoom;
	
	/**
	 * markerClusterSize
	 *
	 * @var \integer
	 */
	protected $markerClusterSize;
	
	/**
	 * markerSearch
	 *
	 * @var boolean
	 */
	protected $markerSearch = FALSE;

	/**
	 * defaultType
	 *
	 * @var \integer
	 */
	protected $defaultType;

	/**
	 * panControl
	 *
	 * @var boolean
	 */
	protected $panControl = FALSE;

	/**
	 * scaleControl
	 *
	 * @var boolean
	 */
	protected $scaleControl = FALSE;

	/**
	 * streetviewControl
	 *
	 * @var boolean
	 */
	protected $streetviewControl = FALSE;

	/**
	 * zoomControl
	 *
	 * @var boolean
	 */
	protected $zoomControl = FALSE;

	/**
	 * zoomControlType
	 *
	 * @var \string
	 */
	protected $zoomControlType;

	/**
	 * mapTypeControl
	 *
	 * @var boolean
	 */
	protected $mapTypeControl = FALSE;

	/**
	 * mapTypes
	 *
	 * @var \string
	 */
	protected $mapTypes;

	/**
	 * showRoute
	 *
	 * @var boolean
	 */
	protected $showRoute = FALSE;

	/**
	 * calcRoute
	 *
	 * @var boolean
	 */
	protected $calcRoute = FALSE;
	
	/**
	 * travelMode
	 *
	 * @var \integer
	 */
	protected $travelMode;
	
	/**
	 * unitSystem
	 *
	 * @var \integer
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
	 * @var boolean
	 */
	protected $showForm = FALSE;
	
	/**
	 * travelModes
	 *
	 * @var \array
	 */
	protected $travelModes = array();
	
	/**
	 * unitSystems
	 *
	 * @var \array
	 */
	protected $unitSystems = array();
	
	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->addresses = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the tooltipTitle
	 *
	 * @return \string $tooltipTitle
	 */
	public function getTooltipTitle() {
		return $this->tooltipTitle;
	}

	/**
	 * Sets the tooltipTitle
	 *
	 * @param \string $tooltipTitle
	 * @return void
	 */
	public function setTooltipTitle($tooltipTitle) {
		$this->tooltipTitle = $tooltipTitle;
	}

	/**
	 * Returns the class
	 *
	 * @return \string $class
	 */
	public function getClass() {
		return $this->class;
	}

	/**
	 * Sets the class
	 *
	 * @param \string $class
	 * @return void
	 */
	public function setClass($class) {
		$this->class = $class;
	}

	/**
	 * Returns the width
	 *
	 * @param \string integer $width
	 */
	public function getWidth() {
		return is_numeric($this->width)?$this->width.'px':$this->width;
	}

	/**
	 * Sets the width
	 *
	 * @param \string $width
	 * @return void
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * Returns the height
	 *
	 * @return \string $height
	 */
	public function getHeight() {
		return is_numeric($this->height)?$this->height.'px':$this->height;
	}

	/**
	 * Sets the height
	 *
	 * @param \string $height
	 * @return void
	 */
	public function setHeight($height) {
		$this->height = $height;
	}

	/**
	 * Returns the zoom
	 *
	 * @return \integer $zoom
	 */
	public function getZoom() {
		return $this->zoom;
	}

	/**
	 * Sets the zoom
	 *
	 * @param \integer $zoom
	 * @return void
	 */
	public function setZoom($zoom) {
		$this->zoom = $zoom;
	}

    /**
     * Returns the zoomMin
     *
     * @return \integer $zoomMin
     */
    public function getZoomMin() {
        return $this->zoomMin;
    }

    /**
     * Sets the zoomMin
     *
     * @param \integer $zoomMin
     * @return void
     */
    public function setZoomMin($zoomMin) {
        $this->zoomMin = $zoomMin;
    }

    /**
     * Returns the zoomMax
     *
     * @return \integer $zoomMax
     */
    public function getZoomMax() {
        return $this->zoomMax;
    }

    /**
     * Sets the zoomMax
     *
     * @param \integer $zoomMax
     * @return void
     */
    public function setZoomMax($zoomMax) {
        $this->zoomMax = $zoomMax;
    }
	
	/**
	 * Adds a Address
	 *
	 * @param \Clickstorm\GoMapsExt\Domain\Model\Address $address
	 * @return void
	 */
	public function addAddress(\Clickstorm\GoMapsExt\Domain\Model\Address $address) {
		$this->addresses->attach($address);
	}

	/**
	 * Removes a Address
	 *
	 * @param \Clickstorm\GoMapsExt\Domain\Model\Address $addressToRemove The Address to be removed
	 * @return void
	 */
	public function removeAddress(\Clickstorm\GoMapsExt\Domain\Model\Address $addressToRemove) {
		$this->addresses->detach($addressToRemove);
	}

	/**
	 * Returns the addresses
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Address> $addresses
	 */
	public function getAddresses() {
		return $this->addresses;
	}

	/**
	 * Sets the addresses
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Address> $addresses
	 * @return void
	 */
	public function setAddresses(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $addresses) {
		$this->addresses = $addresses;
	}

	/**
	 * Returns the kmlUrl
	 *
	 * @return \string $kmlUrl
	 */
	public function getKmlUrl() {
		return $this->kmlUrl;
	}

	/**
	 * Sets the kmlUrl
	 *
	 * @param \string $kmlUrl
	 * @return void
	 */
	public function kmlUrl($kmlUrl) {
		$this->kmlUrl = $kmlUrl;
	}
	
	/**
	 * Returns the kmlPreserveViewport
	 *
	 * @return boolean $kmlPreserveViewport
	 */
	public function getKmlPreserveViewport() {
		return $this->kmlPreserveViewport;
	}

	/**
	 * Sets the kmlPreserveViewport
	 *
	 * @param boolean $kmlPreserveViewport
	 * @return void
	 */
	public function setKmlPreserveViewport($kmlPreserveViewport) {
		$this->kmlPreserveViewport = $kmlPreserveViewport;
	}
	
	/**
	 * Returns the boolean state of kmlPreserveViewport
	 *
	 * @return boolean
	 */
	public function isKmlPreserveViewport() {
		return $this->getKmlPreserveViewport();
	}
	
	/**
	 * Returns the kmlLocal
	 *
	 * @return boolean $kmlLocal
	 */
	public function getKmlLocal() {
		return $this->kmlLocal;
	}

	/**
	 * Sets the kmlLocal
	 *
	 * @param boolean $kmlLocal
	 * @return void
	 */
	public function setKmlLocal($kmlLocal) {
		$this->kmlLocal = $kmlLocal;
	}
	
	/**
	 * Returns the boolean state of kmlLocal
	 *
	 * @return boolean
	 */
	public function isKmlLocal() {
		return $this->getKmlLocal();
	}

    /**
     * Returns the showCategories
     *
     * @return boolean $showCategories
     */
    public function getShowCategories() {
        return $this->showCategories;
    }

    /**
     * Sets the showCategories
     *
     * @param boolean $showCategories
     * @return void
     */
    public function setShowCategories($showCategories) {
        $this->showCategories = $showCategories;
    }

    /**
     * Returns the boolean state of showCategories
     *
     * @return boolean
     */
    public function isShowCategories() {
        return $this->getShowCategories();
    }

	/**
	 * Returns the scrollZoom
	 *
	 * @return boolean $scrollZoom
	 */
	public function getScrollZoom() {
		return $this->scrollZoom;
	}

	/**
	 * Sets the scrollZoom
	 *
	 * @param boolean $scrollZoom
	 * @return void
	 */
	public function setScrollZoom($scrollZoom) {
		$this->scrollZoom = $scrollZoom;
	}

	/**
	 * Returns the boolean state of scrollZoom
	 *
	 * @return boolean
	 */
	public function isScrollZoom() {
		return $this->getScrollZoom();
	}

	/**
	 * Returns the draggable
	 *
	 * @return boolean $draggable
	 */
	public function getDraggable() {
		return $this->draggable;
	}

	/**
	 * Sets the draggable
	 *
	 * @param boolean $draggable
	 * @return void
	 */
	public function setDraggable($draggable) {
		$this->draggable = $draggable;
	}

	/**
	 * Returns the boolean state of draggable
	 *
	 * @return boolean
	 */
	public function isDraggable() {
		return $this->getDraggable();
	}

	/**
	 * Returns the doubleClickZoom
	 *
	 * @return boolean $doubleClickZoom
	 */
	public function getDoubleClickZoom() {
		return $this->doubleClickZoom;
	}

	/**
	 * Sets the doubleClickZoom
	 *
	 * @param boolean $doubleClickZoom
	 * @return void
	 */
	public function setDoubleClickZoom($doubleClickZoom) {
		$this->doubleClickZoom = $doubleClickZoom;
	}

	/**
	 * Returns the boolean state of doubleClickZoom
	 *
	 * @return boolean
	 */
	public function isDoubleClickZoom() {
		return $this->getDoubleClickZoom();
	}
	
	/**
	 * Returns the markerCluster
	 *
	 * @return boolean $markerCluster
	 */
	public function getMarkerCluster() {
		return $this->markerCluster;
	}

	/**
	 * Sets the markerCluster
	 *
	 * @param boolean $markerCluster
	 * @return void
	 */
	public function setMarkerCluster($markerCluster) {
		$this->markerCluster = $markerCluster;
	}

	/**
	 * Returns the boolean state of markerCluster
	 *
	 * @return boolean
	 */
	public function isMarkerCluster() {
		return $this->getMarkerCluster();
	}
	
	/**
	 * Returns the markerClusterZoom
	 *
	 * @return \integer $markerClusterZoom
	 */
	public function getMarkerClusterZoom() {
		return $this->markerClusterZoom;
	}

	/**
	 * Sets the markerClusterZoom
	 *
	 * @param \integer $markerClusterZoom
	 * @return void
	 */
	public function setMarkerClusterZoom($markerClusterZoom) {
		$this->markerClusterZoom = $markerClusterZoom;
	}
	
	/**
	 * Returns the markerClusterSize
	 *
	 * @return \integer $markerClusterSize
	 */
	public function getMarkerClusterSize() {
		return $this->markerClusterSize;
	}

	/**
	 * Sets the markerClusterSize
	 *
	 * @param \integer $markerClusterSize
	 * @return void
	 */
	public function setMarkerClusterSize($markerClusterSize) {
		$this->markerClusterSize = $markerClusterSize;
	}
	
	/**
	 * Returns the markerSearch
	 *
	 * @return boolean $markerSearch
	 */
	public function getMarkerSearch() {
		return $this->markerSearch;
	}

	/**
	 * Sets the markerSearch
	 *
	 * @param boolean $markerSearch
	 * @return void
	 */
	public function setMarkerSearch($markerSearch) {
		$this->markerSearch = $markerSearch;
	}

	/**
	 * Returns the boolean state of markerSearch
	 *
	 * @return boolean
	 */
	public function isMarkerSearch() {
		return $this->getMarkerSearch();
	}

	/**
	 * Returns the defaultType
	 *
	 * @return \integer $defaultType
	 */
	public function getDefaultType() {
		return $this->defaultType;
	}

	/**
	 * Sets the defaultType
	 *
	 * @param \integer $defaultType
	 * @return void
	 */
	public function setDefaultType($defaultType) {
		$this->defaultType = $defaultType;
	}

	/**
	 * Returns the panControl
	 *
	 * @return boolean $panControl
	 */
	public function getPanControl() {
		return $this->panControl;
	}

	/**
	 * Sets the panControl
	 *
	 * @param boolean $panControl
	 * @return void
	 */
	public function setPanControl($panControl) {
		$this->panControl = $panControl;
	}

	/**
	 * Returns the boolean state of panControl
	 *
	 * @return boolean
	 */
	public function isPanControl() {
		return $this->getPanControl();
	}

	/**
	 * Returns the scaleControl
	 *
	 * @return boolean $scaleControl
	 */
	public function getScaleControl() {
		return $this->scaleControl;
	}

	/**
	 * Sets the scaleControl
	 *
	 * @param boolean $scaleControl
	 * @return void
	 */
	public function setScaleControl($scaleControl) {
		$this->scaleControl = $scaleControl;
	}

	/**
	 * Returns the boolean state of scaleControl
	 *
	 * @return boolean
	 */
	public function isScaleControl() {
		return $this->getScaleControl();
	}

	/**
	 * Returns the streetviewControl
	 *
	 * @return boolean $streetviewControl
	 */
	public function getStreetviewControl() {
		return $this->streetviewControl;
	}

	/**
	 * Sets the streetviewControl
	 *
	 * @param boolean $streetviewControl
	 * @return void
	 */
	public function setStreetviewControl($streetviewControl) {
		$this->streetviewControl = $streetviewControl;
	}

	/**
	 * Returns the boolean state of streetviewControl
	 *
	 * @return boolean
	 */
	public function isStreetviewControl() {
		return $this->getStreetviewControl();
	}

	/**
	 * Returns the zoomControl
	 *
	 * @return boolean $zoomControl
	 */
	public function getZoomControl() {
		return $this->zoomControl;
	}

	/**
	 * Sets the zoomControl
	 *
	 * @param boolean $zoomControl
	 * @return void
	 */
	public function setZoomControl($zoomControl) {
		$this->zoomControl = $zoomControl;
	}

	/**
	 * Returns the boolean state of zoomControl
	 *
	 * @return boolean
	 */
	public function isZoomControl() {
		return $this->getZoomControl();
	}

	/**
	 * Returns the zoomControlType
	 *
	 * @return \string $zoomControlType
	 */
	public function getZoomControlType() {
		return $this->zoomControlType;
	}

	/**
	 * Sets the zoomControlType
	 *
	 * @param \string $zoomControlType
	 * @return void
	 */
	public function setZoomControlType($zoomControlType) {
		$this->zoomControlType = $zoomControlType;
	}

	/**
	 * Returns the mapTypeControl
	 *
	 * @return boolean $mapTypeControl
	 */
	public function getMapTypeControl() {
		return $this->mapTypeControl;
	}

	/**
	 * Sets the mapTypeControl
	 *
	 * @param boolean $mapTypeControl
	 * @return void
	 */
	public function setMapTypeControl($mapTypeControl) {
		$this->mapTypeControl = $mapTypeControl;
	}

	/**
	 * Returns the boolean state of mapTypeControl
	 *
	 * @return boolean
	 */
	public function isMapTypeControl() {
		return $this->getMapTypeControl();
	}

	/**
	 * Returns the mapTypes
	 *
	 * @return \string $mapTypes
	 */
	public function getMapTypes() {
		return explode(",", $this->mapTypes);
	}

	/**
	 * Sets the mapTypes
	 *
	 * @param \string $mapTypes
	 * @return void
	 */
	public function setMapTypes($mapTypes) {
		$this->mapTypes = $mapTypes;
	}
	
	/**
	 * Returns the showRoute
	 *
	 * @return boolean $showRoute
	 */
	public function getShowRoute() {
		return $this->showRoute;
	}

	/**
	 * Sets the showRoute
	 *
	 * @param boolean $showRoute
	 * @return void
	 */
	public function setShowRoute($showRoute) {
		$this->showRoute = $showRoute;
	}

	/**
	 * Returns the boolean state of showRoute
	 *
	 * @return boolean
	 */
	public function isShowRoute() {
		return $this->getShowRoute();
	}

	/**
	 * Returns the calcRoute
	 *
	 * @return boolean $calcRoute
	 */
	public function getCalcRoute() {
		return $this->calcRoute;
	}

	/**
	 * Sets the calcRoute
	 *
	 * @param boolean $calcRoute
	 * @return void
	 */
	public function setCalcRoute($calcRoute) {
		$this->calcRoute = $calcRoute;
	}

	/**
	 * Returns the boolean state of calcRoute
	 *
	 * @return boolean
	 */
	public function isCalcRoute() {
		return $this->getCalcRoute();
	}
	
	/**
	 * Returns the travelMode
	 *
	 * @return \integer $travelMode
	 */
	public function getTravelMode() {
		return $this->travelMode;
	}

	/**
	 * Sets the travelMode
	 *
	 * @param \integer $travelMode
	 * @return void
	 */
	public function setTravelMode($travelMode) {
		$this->travelMode = $travelMode;
	}
	
	/**
	 * Returns the unitSystem
	 *
	 * @return \integer $unitSystem
	 */
	public function getUnitSystem() {
		return $this->unitSystem;
	}

	/**
	 * Sets the unitSystem
	 *
	 * @param \integer $travelMode
	 * @return void
	 */
	public function setUnitSystem($unitSystem) {
		$this->unitSystem = $unitSystem;
	}
	
	/**
	 * Returns the styledMapName
	 *
	 * @return \string $styledMapName
	 */
	public function getStyledMapName() {
		return $this->styledMapName;
	}

	/**
	 * Sets the styledMapName
	 *
	 * @param \string $styledMapName
	 * @return void
	 */
	public function setStyledMapName($styledMapName) {
		$this->styledMapName = $styledMapName;
	}

	/**
	 * Returns the styledMapCode
	 *
	 * @return \string $styledMapCode
	 */
	public function getStyledMapCode() {
		return $this->styledMapCode;
	}

	/**
	 * Sets the styledMapCode
	 *
	 * @param \string $styledMapCode
	 * @return void
	 */
	public function setStyledMapCode($styledMapCode) {
		$this->styledMapCode = $styledMapCode;
	}
	
	/**
	 * Returns the setForm
	 *
	 * @return boolean $showForm
	 */
	public function getShowForm() {
		if($this->getCalcRoute() == 1 || $this->getTravelMode() == 1 ||  $this->getUnitSystem() == 1) {
			return true; 
		} else {
			return false;
		}
	}
	
	/**
	 * Returns the travelModes
	 *
	 * @return \array $travelModes
	 */
	public function getTravelModes() {
		for($i=0; $i<=4; $i++) { 
			$travelModes[$i] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_gomapsext_domain_model_map.travel_mode.' . $i, 'go_maps_ext');
		}
		return $travelModes;
	}
	
	/**
	 * Returns the unitSystems
	 *
	 * @return \array $unitSystems
	 */
	public function getUnitSystems() {
		for($i=2; $i<=3; $i++) { 
			$unitSystems[$i] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_gomapsext_domain_model_map.unit_system.' . $i, 'go_maps_ext');
		}
		return $unitSystems;
	}
}
?>