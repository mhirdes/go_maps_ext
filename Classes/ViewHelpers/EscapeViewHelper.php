<?php

namespace Clickstorm\GoMapsExt\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Renders a HTML-script value by passing it and escape ' to pretend for errors.
 *
 * == Examples ==
 *
 * <code title="Default parameters">
 * <gomapsext:format.escape>function('');</gomapsext:format.escape>
 * </code>
 * <output>
 * function(\'\');
 * </output>
 *
 * <code title="Inline notation">
 * {some'Text' -> gomapsext:format.escape}
 * </code>
 * <output>
 * some\'Text\'
 * </output>
 */
class EscapeViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        $value = $renderChildrenClosure() ?? '';

        return str_replace("'", "\'", preg_replace("/\r\n|\r|\n/", '', $value));
    }
}
