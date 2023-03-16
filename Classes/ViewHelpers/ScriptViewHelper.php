<?php

namespace Clickstorm\GoMapsExt\ViewHelpers;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
