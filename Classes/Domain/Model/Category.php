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

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    /**
     * marker
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $gmeMarker;
    /**
     * imageSize
     *
     * @var bool
     */
    protected $gmeImageSize = false;
    /**
     * imageWidth
     *
     * @var int
     */
    protected $gmeImageWidth;
    /**
     * imageHeight
     *
     * @var int
     */
    protected $gmeImageHeight;

    /**
     * @var int
     */
    protected $sorting;

    /**
     * Returns the marker
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference gmeMarker
     */
    public function getGmeMarker()
    {
        return $this->gmeMarker;
    }

    /**
     * Sets the gmeMarker
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $gmeMarker
     * @return void
     */
    public function setGmeMarker(FileReference $gmeMarker)
    {
        $this->gmeMarker = $gmeMarker;
    }

    /**
     * Returns the imageSize
     *
     * @return bool $gmeImageSize
     */
    public function getGmeImageSize()
    {
        return $this->gmeImageSize;
    }

    /**
     * Returns the boolean state of imageSize
     *
     * @return bool
     */
    public function isGmeImageSize()
    {
        return $this->getGmeImageSize();
    }

    /**
     * Sets the imageSize
     *
     * @param bool $gmeImageSize
     * @return void
     */
    public function setGmeImageSize($gmeImageSize)
    {
        $this->gmeImageSize = $gmeImageSize;
    }

    /**
     * @return int
     */
    public function getGmeImageWidth()
    {
        return $this->gmeImageWidth;
    }

    /**
     * @param int $gmeImageWidth
     */
    public function setGmeImageWidth($gmeImageWidth)
    {
        $this->gmeImageWidth = $gmeImageWidth;
    }

    /**
     * @return int
     */
    public function getGmeImageHeight()
    {
        return $this->gmeImageHeight;
    }

    /**
     * @param int $gmeImageHeight
     */
    public function setGmeImageHeight($gmeImageHeight)
    {
        $this->gmeImageHeight = $gmeImageHeight;
    }

    /**
     * @return int
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * @param int $sorting
     */
    public function setSorting(int $sorting)
    {
        $this->sorting = $sorting;
    }
}
