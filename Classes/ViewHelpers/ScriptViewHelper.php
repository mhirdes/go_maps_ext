<?php

namespace Clickstorm\GoMapsExt\ViewHelpers;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
/**
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
*/
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Renders a HTML-script value by moving it into a temporary file and adding it to the page
 *
 * == Examples ==
 *
 * <code title="Default parameters">
 * <gomapsext:script>'foo <b>bar</b>.'</gomapsext:script>
 * </code>
 * <output>
 * <script type="text/javascript">
 *        foo <b>bar<\/b>
 * </script>
 *
 * <code title="Inline notation">
 * {someText -> gomapsext:script}
 * </code>
 * <output>
 * <script type="text/javascript">
 *  someText
 * </script>
 * </output>
 */
class ScriptViewHelper extends AbstractViewHelper
{
    public function render()
    {
        GeneralUtility::makeInstance(PageRenderer::class)
              ->addJsFooterFile(
                  GeneralUtility::writeJavaScriptContentToTemporaryFile($this->renderChildren())
              );
    }
}
