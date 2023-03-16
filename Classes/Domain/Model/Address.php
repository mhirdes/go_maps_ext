<?php

namespace Clickstorm\GoMapsExt\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Address extends AbstractEntity
{
    protected string $title = '';
    protected string $street = '';
    protected string $zip = '';
    protected string $city = '';
    protected string $configurationMap = '';
    protected float $latitude = 0;
    protected float $longitude = 0;
    protected string $address = '';
    protected ?FileReference $marker = null;
    protected bool $imageSize = false;
    protected int $imageWidth = 0;
    protected int $imageHeight = 0;
    protected string $infoWindowContent = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ?ObjectStorage $infoWindowImages = null;

    protected int $infoWindowLink = 0;
    protected bool $closeByClick = false;
    protected bool $openByClick = false;
    protected bool $opened = false;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Category>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ?ObjectStorage $categories = null;

    /**
     * map
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Map>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ?ObjectStorage $map = null;

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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getConfigurationMap(): string
    {
        return $this->configurationMap;
    }

    public function setConfigurationMap(string $configurationMap): void
    {
        $this->configurationMap = $configurationMap;
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

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getMarker(): ?FileReference
    {
        return $this->marker;
    }

    public function setMarker(FileReference $marker): void
    {
        $this->marker = $marker;
    }

    public function getImageSize(): bool
    {
        return $this->imageSize;
    }

    public function isImageSize(): bool
    {
        return $this->getImageSize();
    }

    public function setImageSize(bool $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageWidth(): int
    {
        return $this->imageWidth;
    }

    public function setImageWidth(int $imageWidth): void
    {
        $this->imageWidth = $imageWidth;
    }

    public function getImageHeight(): int
    {
        return $this->imageHeight;
    }

    public function setImageHeight(int $imageHeight): void
    {
        $this->imageHeight = $imageHeight;
    }

    public function getInfoWindowContent(): string
    {
        return $this->infoWindowContent;
    }

    public function setInfoWindowContent(string $infoWindowContent): void
    {
        $this->infoWindowContent = $infoWindowContent;
    }

    public function addInfoWindowImage(FileReference $infoWindowImage): void
    {
        $this->infoWindowImages->attach($infoWindowImage);
    }

    public function removeInfoWindowImage(FileReference $infoWindowImageToRemove): void
    {
        $this->infoWindowImages->detach($infoWindowImageToRemove);
    }

    /**
     * @return ObjectStorage<FileReference> $infoWindowImages
     */
    public function getInfoWindowImages(): ?ObjectStorage
    {
        return $this->infoWindowImages;
    }

    public function setInfoWindowImage(ObjectStorage $infoWindowImages): void
    {
        $this->infoWindowImages = $infoWindowImages;
    }

    public function getInfoWindowLink(): int
    {
        return $this->infoWindowLink;
    }

    public function setInfoWindowLink(int $infoWindowLink): void
    {
        $this->infoWindowLink = $infoWindowLink;
    }

    public function getCloseByClick(): bool
    {
        return $this->closeByClick;
    }

    public function isCloseByClick(): bool
    {
        return $this->getCloseByClick();
    }

    public function setCloseByClick(bool $closeByClick): void
    {
        $this->closeByClick = $closeByClick;
    }

    public function getOpenByClick(): bool
    {
        return $this->openByClick;
    }

    public function isOpenByClick(): bool
    {
        return $this->getOpenByClick();
    }

    public function setOpenByClick(bool $openByClick): void
    {
        $this->openByClick = $openByClick;
    }

    public function getOpened(): bool
    {
        return $this->opened;
    }

    public function isOpened(): bool
    {
        return $this->getOpened();
    }

    public function setOpened(bool $opened): void
    {
        $this->opened = $opened;
    }

    public function addCategories(Category $category): void
    {
        $this->categories->attach($category);
    }

    public function removeCategories(Category $categoryToRemove): void
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * @return ObjectStorage<Category>|null
     */
    public function getCategories(): ?ObjectStorage
    {
        return $this->categories;
    }

    /**
     * @param ObjectStorage<Category> $categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * Returns the Map
     *
     * @return ObjectStorage<Map>|null $map
     */
    public function getMap(): ?ObjectStorage
    {
        return $this->map;
    }

    /**
     * Sets the Map
     *
     * @param ObjectStorage<Map> $map
     */
    public function setMap(ObjectStorage $map): void
    {
        $this->map = $map;
    }
}
