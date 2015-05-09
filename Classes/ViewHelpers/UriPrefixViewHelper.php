<?php
namespace Clickstorm\GoMapsExt\ViewHelpers;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View Helper to integrate URI prefix (aka config.absRefPrefix).
 *
 * Example usage:
 * + {gomapsext:uriPrefix()}
 * + <gomapsext:uriPrefix />
 *
 * @package Clickstorm\GoMapsExt\ViewHelpers
 * @author Oliver Hader <oliver@typo3.org>
 */
class UriPrefixViewHelper extends AbstractViewHelper {

	/**
	 * Renders value of TypoScript Setting config.absRefPrefix.
	 *
	 * @return string
	 */
	public function render() {
		$frontendController = $this->getFrontendController();
		return (!empty($frontendController) ? $frontendController->absRefPrefix : '');
	}

	/**
	 * @return TypoScriptFrontendController
	 */
	protected function getFrontendController() {
		return $GLOBALS['TSFE'];
	}

}
