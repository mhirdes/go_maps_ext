<?php

namespace Clickstorm\GoMapsExt\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    protected ?FileReference $gmeMarker = null;
    protected bool $gmeImageSize = false;
    protected int $gmeImageWidth = 0;
    protected int $gmeImageHeight = 0;
    protected int $sorting = 0;

    public function getGmeMarker(): ?FileReference
    {
        return $this->gmeMarker;
    }

    public function setGmeMarker(FileReference $gmeMarker): void
    {
        $this->gmeMarker = $gmeMarker;
    }

    public function getGmeImageSize(): bool
    {
        return $this->gmeImageSize;
    }

    public function isGmeImageSize(): bool
    {
        return $this->getGmeImageSize();
    }

    public function setGmeImageSize(bool $gmeImageSize): void
    {
        $this->gmeImageSize = $gmeImageSize;
    }

    public function getGmeImageWidth(): int
    {
        return $this->gmeImageWidth;
    }

    public function setGmeImageWidth(int $gmeImageWidth): void
    {
        $this->gmeImageWidth = $gmeImageWidth;
    }

    public function getGmeImageHeight(): int
    {
        return $this->gmeImageHeight;
    }

    public function setGmeImageHeight(int $gmeImageHeight): void
    {
        $this->gmeImageHeight = $gmeImageHeight;
    }

    public function getSorting(): int
    {
        return $this->sorting;
    }

    public function setSorting(int $sorting): void
    {
        $this->sorting = $sorting;
    }
}
