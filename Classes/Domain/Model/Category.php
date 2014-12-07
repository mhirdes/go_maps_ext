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
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Name
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $name;
	
	/**
	 * addresses
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Clickstorm\GoMapsExt\Domain\Model\Address>
	 * @lazy
	 */
	protected $addresses;
	
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
	 * Returns the name
	 *
	 * @return \string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param \string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
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
}
?>