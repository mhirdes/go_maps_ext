<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Clickstorm.' . $_EXTKEY,
	'Show',
	'Google Map'
);

$pluginSignature = str_replace('_', '', $_EXTKEY) . '_show';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature]='code,layout,select_key,pages,recursive';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_show.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Google Maps API Extbase');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_gomapsext_domain_model_address', 'EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_address.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gomapsext_domain_model_address');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_gomapsext_domain_model_map', 'EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gomapsext_domain_model_map');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_gomapsext_domain_model_category', 'EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_category.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gomapsext_domain_model_category');

?>