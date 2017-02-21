<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
	'tx_gomapsext_domain_model_address',
	'EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_address.xlf'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gomapsext_domain_model_address');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
	'tx_gomapsext_domain_model_map',
	'EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gomapsext_domain_model_map');


?>