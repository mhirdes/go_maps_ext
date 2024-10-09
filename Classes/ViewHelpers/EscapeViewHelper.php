<?php

namespace Clickstorm\GoMapsExt\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

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
    public function render(): string
    {
        $value = $this->renderChildren() ?? '';

        return str_replace("'", "\'", preg_replace("/\r\n|\r|\n/", '', $value));
    }
}
