<?php

namespace Clickstorm\GoMapsExt\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Map extends AbstractEntity
{
    /**
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $title = '';

    /**
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $width = '';

    /**
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $height = '';

    protected int $zoom = 0;
    protected int $zoomMin = 0;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getWidth(): string
    {
        return is_numeric($this->width) ? $this->width . 'px' : $this->width;
    }

    public function setWidth(string $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): string
    {
        return is_numeric($this->height) ? $this->height . 'px' : $this->height;
    }

    public function setHeight(string $height): void
    {
        $this->height = $height;
    }

    public function getZoom(): int
    {
        return $this->zoom;
    }

    public function setZoom(int $zoom): void
    {
        $this->zoom = $zoom;
    }

    public function getZoomMin(): int
    {
        return $this->zoomMin;
    }

    public function setZoomMin(int $zoomMin): void
    {
        $this->zoomMin = $zoomMin;
    }

    public function getZoomMax(): int
    {
        return $this->zoomMax;
    }

    public function setZoomMax(int $zoomMax): void
    {
        $this->zoomMax = $zoomMax;
    }

    public function addAddress(Address $address): void
    {
        $this->addresses->attach($address);
    }

    public function removeAddress(Address $addressToRemove): void
    {
        $this->addresses->detach($addressToRemove);
    }

    /**
     * @return ObjectStorage<Address>|null $addresses
     */
    public function getAddresses(): ?ObjectStorage
    {
        return $this->addresses;
    }

    /**
     * @param ObjectStorage<Address> $addresses
     */
    public function setAddresses(ObjectStorage $addresses)
    {
        $this->addresses = $addresses;
    }

    public function getKmlUrl(): string
    {
        return $this->kmlUrl;
    }

    public function kmlUrl(string $kmlUrl): void
    {
        $this->kmlUrl = $kmlUrl;
    }

    public function getKmlPreserveViewport(): bool
    {
        return $this->kmlPreserveViewport;
    }

    public function isKmlPreserveViewport(): bool
    {
        return $this->getKmlPreserveViewport();
    }

    public function setKmlPreserveViewport(bool $kmlPreserveViewport): void
    {
        $this->kmlPreserveViewport = $kmlPreserveViewport;
    }

    public function getKmlLocal(): bool
    {
        return $this->kmlLocal;
    }

    public function isKmlLocal(): bool
    {
        return $this->getKmlLocal();
    }

    public function setKmlLocal(bool $kmlLocal): void
    {
        $this->kmlLocal = $kmlLocal;
    }

    public function getShowAddresses(): bool
    {
        return $this->showAddresses;
    }

    public function setShowAddresses(bool $showAddresses): void
    {
        $this->showAddresses = $showAddresses;
    }

    public function getShowCategories(): bool
    {
        return $this->showCategories;
    }

    public function isShowCategories(): bool
    {
        return $this->getShowCategories();
    }

    public function setShowCategories(bool $showCategories): void
    {
        $this->showCategories = $showCategories;
    }

    public function getScrollZoom(): bool
    {
        return $this->scrollZoom;
    }

    public function isScrollZoom(): bool
    {
        return $this->getScrollZoom();
    }

    public function setScrollZoom(bool $scrollZoom): void
    {
        $this->scrollZoom = $scrollZoom;
    }

    public function getDraggable(): bool
    {
        return $this->draggable;
    }

    public function isDraggable(): bool
    {
        return $this->getDraggable();
    }

    public function setDraggable(bool $draggable): void
    {
        $this->draggable = $draggable;
    }

    public function getDoubleClickZoom(): bool
    {
        return $this->doubleClickZoom;
    }

    public function isDoubleClickZoom(): bool
    {
        return $this->getDoubleClickZoom();
    }

    public function setDoubleClickZoom(bool $doubleClickZoom): void
    {
        $this->doubleClickZoom = $doubleClickZoom;
    }

    public function getMarkerCluster(): bool
    {
        return $this->markerCluster;
    }

    public function isMarkerCluster(): bool
    {
        return $this->getMarkerCluster();
    }

    public function setMarkerCluster(bool $markerCluster): void
    {
        $this->markerCluster = $markerCluster;
    }

    public function getMarkerClusterZoom(): int
    {
        return $this->markerClusterZoom;
    }

    public function setMarkerClusterZoom(int $markerClusterZoom): void
    {
        $this->markerClusterZoom = $markerClusterZoom;
    }

    public function getMarkerClusterSize(): int
    {
        return $this->markerClusterSize;
    }

    public function setMarkerClusterSize(int $markerClusterSize): void
    {
        $this->markerClusterSize = $markerClusterSize;
    }

    public function getMarkerClusterStyle(): string
    {
        return $this->markerClusterStyle;
    }

    public function setMarkerClusterStyle(string $markerClusterStyle): void
    {
        $this->markerClusterStyle = $markerClusterStyle;
    }

    public function getMarkerSearch(): bool
    {
        return $this->markerSearch;
    }

    public function isMarkerSearch(): bool
    {
        return $this->getMarkerSearch();
    }

    public function setMarkerSearch(bool $markerSearch): void
    {
        $this->markerSearch = $markerSearch;
    }

    public function getDefaultType(): int
    {
        return $this->defaultType;
    }

    public function setDefaultType(int $defaultType): void
    {
        $this->defaultType = $defaultType;
    }

    public function getPreviewImage(): ?FileReference
    {
        return $this->previewImage;
    }

    public function setPreviewImage(FileReference $previewImage): void
    {
        $this->previewImage = $previewImage;
    }

    public function getScaleControl(): bool
    {
        return $this->scaleControl;
    }

    public function isScaleControl(): bool
    {
        return $this->getScaleControl();
    }

    public function setScaleControl(bool $scaleControl): void
    {
        $this->scaleControl = $scaleControl;
    }

    public function getStreetviewControl(): bool
    {
        return $this->streetviewControl;
    }

    public function isStreetviewControl(): bool
    {
        return $this->getStreetviewControl();
    }

    public function setStreetviewControl(bool $streetviewControl): void
    {
        $this->streetviewControl = $streetviewControl;
    }

    public function getFullscreenControl(): bool
    {
        return $this->fullscreenControl;
    }

    public function isFullscreenControl(): bool
    {
        return $this->getFullscreenControl();
    }

    public function setFullscreenControl(bool $fullscreenControl): void
    {
        $this->fullscreenControl = $fullscreenControl;
    }

    public function getZoomControl(): bool
    {
        return $this->zoomControl;
    }

    public function isZoomControl(): bool
    {
        return $this->getZoomControl();
    }

    public function setZoomControl(bool $zoomControl): void
    {
        $this->zoomControl = $zoomControl;
    }

    public function getMapTypeControl(): bool
    {
        return $this->mapTypeControl;
    }

    public function isMapTypeControl(): bool
    {
        return $this->getMapTypeControl();
    }

    public function setMapTypeControl(bool $mapTypeControl): void
    {
        $this->mapTypeControl = $mapTypeControl;
    }

    public function getMapTypes(): array
    {
        return explode(',', $this->mapTypes);
    }

    public function setMapTypes(string $mapTypes): void
    {
        $this->mapTypes = $mapTypes;
    }

    public function getShowRoute(): bool
    {
        return $this->showRoute;
    }

    public function isShowRoute(): bool
    {
        return $this->getShowRoute();
    }

    public function setShowRoute(bool $showRoute): void
    {
        $this->showRoute = $showRoute;
    }

    public function getStyledMapName(): string
    {
        return $this->styledMapName;
    }

    public function setStyledMapName(string $styledMapName): void
    {
        $this->styledMapName = $styledMapName;
    }

    public function getStyledMapCode(): string
    {
        return $this->styledMapCode;
    }

    public function setStyledMapCode(string $styledMapCode): void
    {
        $this->styledMapCode = $styledMapCode;
    }

    public function getShowForm(): bool
    {
        return $this->getCalcRoute() || $this->getTravelMode() === 1 || $this->getUnitSystem() === 1 || $this->getMarkerSearch();
    }

    public function getCalcRoute(): bool
    {
        return $this->calcRoute;
    }

    public function isCalcRoute(): bool
    {
        return $this->getCalcRoute();
    }

    public function setCalcRoute(bool $calcRoute): void
    {
        $this->calcRoute = $calcRoute;
    }

    public function getTravelMode(): int
    {
        return $this->travelMode;
    }

    public function setTravelMode(int $travelMode): void
    {
        $this->travelMode = $travelMode;
    }

    public function getUnitSystem(): int
    {
        return $this->unitSystem;
    }

    public function setUnitSystem(int $unitSystem): void
    {
        $this->unitSystem = $unitSystem;
    }

    public function getTravelModes(): array
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

    public function getUnitSystems(): array
    {
        $unitSystems = [];
        for ($i = 2; $i <= 3; $i++) {
            $unitSystems[$i] = LocalizationUtility::translate(
                'tx_gomapsext_domain_model_map.unit_system.' . $i,
                'go_maps_ext'
            );
        }

        return $unitSystems;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getGeolocation(): bool
    {
        return $this->geolocation;
    }

    public function isGeolocation(): bool
    {
        return $this->getGeolocation();
    }

    public function setGeolocation(bool $geolocation): void
    {
        $this->geolocation = $geolocation;
    }
}
