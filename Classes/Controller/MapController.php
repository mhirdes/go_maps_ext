<?php
namespace Clickstorm\GoMapsExt\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Marc Hirdes <Marc_Hirdes@gmx.de>, clickstorm GmbH
 *  (c) 2013 Mathias Brodala <mbrodala@pagemachine.de>, PAGEmachine AG
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
class MapController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * mapRepository
	 *
	 * @var \Clickstorm\GoMapsExt\Domain\Repository\MapRepository
	 * @inject
	 */
	protected $mapRepository;

	/**
	 * addressRepository
	 *
	 * @var \Clickstorm\GoMapsExt\Domain\Repository\AddressRepository
	 * @inject
	 */
	protected $addressRepository;

	public function initializeAction() {
		$this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['go_maps_ext']);

		$pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
		$addJsMethod = 'addJs';

		if ($this->extConf['footerJS'] == 1) {
			$addJsMethod = 'addJsFooter';
		}
		$googleMapsLibrary = $this->settings['googleMapsLibrary'] ?
			$this->settings['googleMapsLibrary'] :
			'//maps.google.com/maps/api/js?v=3.27';

		if ($this->settings['apiKey']) {
			$googleMapsLibrary .= '&key=' . $this->settings['apiKey'];
		}
		if ($this->settings['language']) {
			$googleMapsLibrary .= '&language=' . $this->settings['language'];
		}

		$pageRenderer->{$addJsMethod . 'Library'}(
			'googleMaps',
			$googleMapsLibrary,
			'text/javascript',
			false,
			false,
			'',
			true
		);

		if ($this->extConf['include_library'] == 1) {
			$pageRenderer->{$addJsMethod . 'Library'}(
				'jQuery',
				\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath(
					$this->request->getControllerExtensionKey()
				) . 'Resources/Public/Scripts/jquery.min.js'
			);
		}

		if ($this->extConf['include_manually'] != 1) {
			$scripts[] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath(
					$this->request->getControllerExtensionKey()
				) . 'Resources/Public/Scripts/markerclusterer_compiled.js';

			$scripts[] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath(
					$this->request->getControllerExtensionKey()
				) . 'Resources/Public/Scripts/jquery.gomapsext.js';

			foreach ($scripts as $script) {
				$pageRenderer->{$addJsMethod . 'File'}($script);
			}
		}
	}

	/**
	 * action show
	 *
	 * @param \Clickstorm\GoMapsExt\Domain\Model\Map $map
	 * @return void
	 */
	public function showAction(\Clickstorm\GoMapsExt\Domain\Model\Map $map = null) {
		$categoriesArray = [];

		// get current map
		$map = $map ?: $this->mapRepository->findByUid($this->settings['map']);

		// find addresses
		$pid = $this->settings['storagePid'];
		if ($pid) {
			if ($pid == 'this'){
				$addresses = $this->addressRepository->findAllAddresses($map, $GLOBALS['TSFE']->id);
			} else {
				$addresses = $this->addressRepository->findAllAddresses($map, $pid);
			}
		} else {
			$addresses = $map->getAddresses();
		}

		// get categories
		if ($map->isShowCategories()) {
			foreach ($addresses as $address) {
				$addrCats = $address->getCategories();
				foreach ($addrCats as $addrCat) {
					$categoriesArray[$addrCat->getUid()] = $addrCat->getTitle();
				}
			}
		}

		$this->view->assignMultiple(
			[
				'request' => $this->request->getArguments(),
				'map' => $map,
				'addresses' => $addresses,
				'categories' => $categoriesArray
			]
		);
	}

}
