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
class Address extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * configurationMap
	 *
	 * @var \string
	 */
	protected $configurationMap;

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
	 * address
	 *
	 * @var \string
	 */
	protected $address;

	/**
	 * marker
	 *
	 * @var \string
	 */
	protected $marker;

	/**
	 * imageSize
	 *
	 * @var boolean
	 */
	protected $imageSize = FALSE;

	/**
	 * imageWidth
	 *
	 * @var \integer
	 */
	protected $imageWidth;

	/**
	 * imageHeight
	 *
	 * @var \integer
	 */
	protected $imageHeight;

	/**
	 * shadow
	 *
	 * @var \string
	 */
	protected $shadow;

	/**
	 * shadowSize
	 *
	 * @var boolean
	 */
	protected $shadowSize = FALSE;

	/**
	 * shadowWidth
	 *
	 * @var \integer
	 */
	protected $shadowWidth;

	/**
	 * shadowHeight
	 *
	 * @var \integer
	 */
	protected $shadowHeight;

	/**
	 * infoWindowContent
	 *
	 * @var \string
	 */
	protected $infoWindowContent;

	/**
	 * infoWindowLink
	 *
	 * @var \integer
	 */
	protected $infoWindowLink;

	/**
	 * closeByClick
	 *
	 * @var boolean
	 */
	protected $closeByClick = FALSE;

	/**
	 * openByClick
	 *
	 * @var boolean
	 */
	protected $openByClick = FALSE;
	
	/**
	 * opened
	 *
	 * @var boolean
	 */
	protected $opened = FALSE;

    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Category>
     * @lazy
     */
    protected $categories;

    /**
     * map
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Map>
     * @lazy
     */
    protected $map;

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
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->map = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * @param string $title
	 * @return \void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the configurationMap
	 *
	 * @return \string $configurationMap
	 */
	public function getConfigurationMap() {
		return $this->configurationMap;
	}

	/**
	 * Sets the configurationMap
	 *
	 * @param string $configurationMap
	 * @return \void
	 */
	public function setConfigurationMap($configurationMap) {
		$this->configurationMap = $configurationMap;
	}

	/**
	 * Returns the latitude
	 *
	 * @return \float $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * Sets the latitude
	 *
	 * @param \float $latitude
	 * @return void
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * Returns the longitude
	 *
	 * @return \float $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * Sets the longitude
	 *
	 * @param \float $longitude
	 * @return void
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	/**
	 * Returns the address
	 *
	 * @return \string $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param \string $address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns the marker
	 *
	 * @return \string $marker
	 */
	public function getMarker() {
		return $this->marker;
	}

	/**
	 * Sets the marker
	 *
	 * @param string $marker
	 * @return void
	 */
	public function setMarker($marker) {
		$this->marker = $marker;
	}

	/**
	 * Returns the imageSize
	 *
	 * @return boolean $imageSize
	 */
	public function getImageSize() {
		return $this->imageSize;
	}

	/**
	 * Sets the imageSize
	 *
	 * @param boolean $imageSize
	 * @return void
	 */
	public function setImageSize($imageSize) {
		$this->imageSize = $imageSize;
	}

	/**
	 * Returns the boolean state of imageSize
	 *
	 * @return boolean
	 */
	public function isImageSize() {
		return $this->getImageSize();
	}

	/**
	 * Returns the imageWidth
	 *
	 * @return \integer $imageWidth
	 */
	public function getImageWidth() {
		return $this->imageWidth;
	}

	/**
	 * Sets the imageWidth
	 *
	 * @param \integer $imageWidth
	 * @return void
	 */
	public function setImageWidth($imageWidth) {
		$this->imageWidth = $imageWidth;
	}

	/**
	 * Returns the imageHeight
	 *
	 * @return \integer $imageHeight
	 */
	public function getImageHeight() {
		return $this->imageHeight;
	}

	/**
	 * Sets the imageHeight
	 *
	 * @param \integer $imageHeight
	 * @return void
	 */
	public function setImageHeight($imageHeight) {
		$this->imageHeight = $imageHeight;
	}

	/**
	 * Returns the shadow
	 *
	 * @return \string $shadow
	 */
	public function getShadow() {
		return $this->shadow;
	}

	/**
	 * Sets the shadow
	 *
	 * @param \string $shadow
	 * @return void
	 */
	public function setShadow($shadow) {
		$this->shadow = $shadow;
	}

	/**
	 * Returns the shadowSize
	 *
	 * @return boolean $shadowSize
	 */
	public function getShadowSize() {
		return $this->shadowSize;
	}

	/**
	 * Sets the shadowSize
	 *
	 * @param boolean $shadowSize
	 * @return void
	 */
	public function setShadowSize($shadowSize) {
		$this->shadowSize = $shadowSize;
	}

	/**
	 * Returns the boolean state of shadowSize
	 *
	 * @return boolean
	 */
	public function isShadowSize() {
		return $this->getShadowSize();
	}

	/**
	 * Returns the shadowWidth
	 *
	 * @return \integer $shadowWidth
	 */
	public function getShadowWidth() {
		return $this->shadowWidth;
	}

	/**
	 * Sets the shadowWidth
	 *
	 * @param \integer $shadowWidth
	 * @return void
	 */
	public function setShadowWidth($shadowWidth) {
		$this->shadowWidth = $shadowWidth;
	}

	/**
	 * Returns the shadowHeight
	 *
	 * @return \integer $shadowHeight
	 */
	public function getShadowHeight() {
		return $this->shadowHeight;
	}

	/**
	 * Sets the shadowHeight
	 *
	 * @param \integer $shadowHeight
	 * @return void
	 */
	public function setShadowHeight($shadowHeight) {
		$this->shadowHeight = $shadowHeight;
	}

	/**
	 * Returns the infoWindowContent
	 *
	 * @return \string $infoWindowContent
	 */
	public function getInfoWindowContent() {
		return preg_replace("/\r\n|\r/", '</p><p class="bodytext">', $this->infoWindowContent);
	}

	/**
	 * Sets the infoWindowContent
	 *
	 * @param \string $infoWindowContent
	 * @return void
	 */
	public function setInfoWindowContent($infoWindowContent) {
		$this->infoWindowContent = $infoWindowContent;
	}

	/**
	 * Returns the infoWindowLink
	 *
	 * @return \integer $infoWindowLink
	 */
	public function getInfoWindowLink() {
		return $this->infoWindowLink;
	}

	/**
	 * Sets the infoWindowLink
	 *
	 * @param \integer $infoWindowLink
	 * @return void
	 */
	public function setInfoWindowLink($infoWindowLink) {
		$this->infoWindowLink = $infoWindowLink;
	}

	/**
	 * Returns the closeByClick
	 *
	 * @return boolean $closeByClick
	 */
	public function getCloseByClick() {
		return $this->closeByClick;
	}

	/**
	 * Sets the closeByClick
	 *
	 * @param boolean $closeByClick
	 * @return void
	 */
	public function setCloseByClick($closeByClick) {
		$this->closeByClick = $closeByClick;
	}

	/**
	 * Returns the boolean state of closeByClick
	 *
	 * @return boolean
	 */
	public function isCloseByClick() {
		return $this->getCloseByClick();
	}

	/**
	 * Returns the openByClick
	 *
	 * @return boolean $openByClick
	 */
	public function getOpenByClick() {
		return $this->openByClick;
	}

	/**
	 * Sets the openByClick
	 *
	 * @param boolean $openByClick
	 * @return void
	 */
	public function setOpenByClick($openByClick) {
		$this->openByClick = $openByClick;
	}

	/**
	 * Returns the boolean state of openByClick
	 *
	 * @return boolean
	 */
	public function isOpenByClick() {
		return $this->getOpenByClick();
	}
	
	/**
	 * Returns the opened
	 *
	 * @return boolean $opened
	 */
	public function getOpened() {
		return $this->opened;
	}

	/**
	 * Sets the opened
	 *
	 * @param boolean $opened
	 * @return void
	 */
	public function setOpened($opened) {
		$this->opened = $opened;
	}

	/**
	 * Returns the boolean state of opened
	 *
	 * @return boolean
	 */
	public function isOpened() {
		return $this->getOpened();
	}

    /**
     * Adds a Category
     *
     * @param \Clickstorm\GoMapsExt\Domain\Model\Category $category
     * @return void
     */
    public function addAddress(\Clickstorm\GoMapsExt\Domain\Model\Category $category) {
        $this->addresses->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param \Clickstorm\GoMapsExt\Domain\Model\Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeAddress(\Clickstorm\GoMapsExt\Domain\Model\Category $categoryToRemove) {
        $this->addresses->detach($categoryToRemove);
    }

    /**
     * Returns the Categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Category> $categories
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Sets the Categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Category> $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories) {
        $this->categories = $categories;
    }

    /**
     * Returns the Map
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Map> $map
     */
    public function getMap() {
        return $this->map;
    }

    /**
     * Sets the Map
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Map> $map
     * @return void
     */
    public function setMap(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $map) {
        $this->map = $map;
    }
}
?>