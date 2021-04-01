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

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Address extends AbstractEntity
{
    /**
     * title
     *
     * @var \string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title;
    /**
     * street
     *
     * @var \string
     */
    protected $street;
    /**
     * zip
     *
     * @var \string
     */
    protected $zip;
    /**
     * city
     *
     * @var \string
     */
    protected $city;
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
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $marker;
    /**
     * imageSize
     *
     * @var bool
     */
    protected $imageSize = false;
    /**
     * imageWidth
     *
     * @var int
     */
    protected $imageWidth;
    /**
     * imageHeight
     *
     * @var int
     */
    protected $imageHeight;
    /**
     * infoWindowContent
     *
     * @var \string
     */
    protected $infoWindowContent;
    /**
     * infoWindowImages
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $infoWindowImages;
    /**
     * infoWindowLink
     *
     * @var int
     */
    protected $infoWindowLink;
    /**
     * closeByClick
     *
     * @var bool
     */
    protected $closeByClick = false;
    /**
     * openByClick
     *
     * @var bool
     */
    protected $openByClick = false;
    /**
     * opened
     *
     * @var bool
     */
    protected $opened = false;
    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Category>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $categories;
    /**
     * map
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Map>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $map;

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
        $this->infoWindowImages = new ObjectStorage();
        $this->categories = new ObjectStorage();
        $this->map = new ObjectStorage();
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
     * @param string $title
     * @return \void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the configurationMap
     *
     * @return \string $configurationMap
     */
    public function getConfigurationMap()
    {
        return $this->configurationMap;
    }

    /**
     * Sets the configurationMap
     *
     * @param string $configurationMap
     * @return \void
     */
    public function setConfigurationMap($configurationMap)
    {
        $this->configurationMap = $configurationMap;
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
     * Returns the address
     *
     * @return \string $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     *
     * @param \string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns the marker
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference marker
     */
    public function getMarker()
    {
        return $this->marker;
    }

    /**
     * Sets the marker
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $marker
     */
    public function setMarker(FileReference $marker)
    {
        $this->marker = $marker;
    }

    /**
     * Returns the imageSize
     *
     * @return bool $imageSize
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Returns the boolean state of imageSize
     *
     * @return bool
     */
    public function isImageSize()
    {
        return $this->getImageSize();
    }

    /**
     * Sets the imageSize
     *
     * @param bool $imageSize
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;
    }

    /**
     * Returns the imageWidth
     *
     * @return int $imageWidth
     */
    public function getImageWidth()
    {
        return $this->imageWidth;
    }

    /**
     * Sets the imageWidth
     *
     * @param int $imageWidth
     */
    public function setImageWidth($imageWidth)
    {
        $this->imageWidth = $imageWidth;
    }

    /**
     * Returns the imageHeight
     *
     * @return int $imageHeight
     */
    public function getImageHeight()
    {
        return $this->imageHeight;
    }

    /**
     * Sets the imageHeight
     *
     * @param int $imageHeight
     */
    public function setImageHeight($imageHeight)
    {
        $this->imageHeight = $imageHeight;
    }

    /**
     * Returns the infoWindowContent
     *
     * @return \string $infoWindowContent
     */
    public function getInfoWindowContent()
    {
        return $this->infoWindowContent;
    }

    /**
     * Sets the infoWindowContent
     *
     * @param \string $infoWindowContent
     */
    public function setInfoWindowContent($infoWindowContent)
    {
        $this->infoWindowContent = $infoWindowContent;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $infoWindowImage
     */
    public function addInfoWindowImage(FileReference $infoWindowImage)
    {
        $this->infoWindowImages->attach($infoWindowImage);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $infoWindowImageToRemove The FileReference to be removed
     */
    public function removeInfoWindowImage(FileReference $infoWindowImageToRemove)
    {
        $this->infoWindowImages->detach($infoWindowImageToRemove);
    }

    /**
     * Returns the infoWindowImages
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $infoWindowImages
     */
    public function getInfoWindowImages()
    {
        return $this->infoWindowImages;
    }

    /**
     * Sets the infoWindowImages
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $infoWindowImages
     */
    public function setInfoWindowImage(ObjectStorage $infoWindowImages)
    {
        $this->infoWindowImages = $infoWindowImages;
    }

    /**
     * Returns the infoWindowLink
     *
     * @return int $infoWindowLink
     */
    public function getInfoWindowLink()
    {
        return $this->infoWindowLink;
    }

    /**
     * Sets the infoWindowLink
     *
     * @param int $infoWindowLink
     */
    public function setInfoWindowLink($infoWindowLink)
    {
        $this->infoWindowLink = $infoWindowLink;
    }

    /**
     * Returns the closeByClick
     *
     * @return bool $closeByClick
     */
    public function getCloseByClick()
    {
        return $this->closeByClick;
    }

    /**
     * Returns the boolean state of closeByClick
     *
     * @return bool
     */
    public function isCloseByClick()
    {
        return $this->getCloseByClick();
    }

    /**
     * Sets the closeByClick
     *
     * @param bool $closeByClick
     */
    public function setCloseByClick($closeByClick)
    {
        $this->closeByClick = $closeByClick;
    }

    /**
     * Returns the openByClick
     *
     * @return bool $openByClick
     */
    public function getOpenByClick()
    {
        return $this->openByClick;
    }

    /**
     * Returns the boolean state of openByClick
     *
     * @return bool
     */
    public function isOpenByClick()
    {
        return $this->getOpenByClick();
    }

    /**
     * Sets the openByClick
     *
     * @param bool $openByClick
     */
    public function setOpenByClick($openByClick)
    {
        $this->openByClick = $openByClick;
    }

    /**
     * Returns the opened
     *
     * @return bool $opened
     */
    public function getOpened()
    {
        return $this->opened;
    }

    /**
     * Returns the boolean state of opened
     *
     * @return bool
     */
    public function isOpened()
    {
        return $this->getOpened();
    }

    /**
     * Sets the opened
     *
     * @param bool $opened
     */
    public function setOpened($opened)
    {
        $this->opened = $opened;
    }

    /**
     * Adds a Category
     *
     * @param \Clickstorm\GoMapsExt\Domain\Model\Category $category
     */
    public function addCategories(Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param \Clickstorm\GoMapsExt\Domain\Model\Category $categoryToRemove The Category to be removed
     */
    public function removeCategories(Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the Categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Category> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the Categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Category> $categories
     */
    public function setCategories(ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Returns the Map
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Map> $map
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Sets the Map
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Map> $map
     */
    public function setMap(ObjectStorage $map)
    {
        $this->map = $map;
    }
}
