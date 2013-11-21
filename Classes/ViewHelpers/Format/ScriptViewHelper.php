<?php

/*                                                                                                    
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
*/

/**
 */

/**
 * Renders a HTML-script value by passing it in CDATA and escape closing tags for valid HTML.
 *
 * == Examples ==
 *
 * <code title="Default parameters">
 * <gomapsext:format.script>'foo <b>bar</b>.'</gomapsext:format.script>
 * </code>
 * <output>
 * <![CDATA[ 
 * 		foo <b>bar<\/b>
 * ]]>
 * </output>
 *
 * <code title="Inline notation">
 * {someText -> gomapsext:format.script}
 * </code>
 * <output>
 * /*<![CDATA[*\/ foo <b>bar<\/b>  /*]]>*\/
 * </output>
 *
 */

class Tx_GoMapsExt_ViewHelpers_Format_ScriptViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * @return The parsed string.
	 * @author Marc Hirdes <marc_hirdes@gmx.de>
	 */
	public function render() {
		$value = $this->renderChildren();
		
		return '/*<![CDATA[*/' . str_replace('</', '<\/', $value) . '/*]]>*/';
	}
}

?>