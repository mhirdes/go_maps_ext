<?php

namespace Clickstorm\GoMapsExt\ViewHelpers;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

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
    use CompileWithRenderStatic;

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): void {
        $value = $renderChildrenClosure() ?? '';

        GeneralUtility::makeInstance(PageRenderer::class)
            ->addJsFooterFile(
                GeneralUtility::writeJavaScriptContentToTemporaryFile($value)
            );
    }
}
