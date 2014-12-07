<?php
namespace Clickstorm\GoMapsExt\Domain\Repository;

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
class AddressRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Finds all addresses by the specified map or the storage pid
	 *
	 * @param \Clickstorm\GoMapsExt\Domain\Model\Map $map The map
	 * @param \integer $pid The Storage Pid
	 * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface The addresses
	 */
	function findAllAddresses(\Clickstorm\GoMapsExt\Domain\Model\Map $map, $pid) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->getQuerySettings()->setRespectSysLanguage(FALSE);

        $or = array();
        $and = array();

        $or[] = $query->equals('pid', $pid);
        if($map) {
            $or[] = $query->contains('map', $map);
        }
        $and[] = $query->logicalOr($or);

        return $query->matching(
            $query->logicalAnd(
                $and
            )
        )
            ->execute();
	}
}
?>