<?php
defined('TYPO3_MODE') or die();

$extKey = 'go_maps_ext';

// register plugin
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Clickstorm.' . $extKey,
	'Show',
	'Google Map'
);

// flexform
$pluginSignature = str_replace('_', '', $extKey) . '_show';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'code,layout,select_key,pages,recursive';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	$pluginSignature,
	'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_show.xml'
);