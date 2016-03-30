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
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'code,layout,select_key,pages,recursive';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	$pluginSignature,
	'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_show.xml'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	$_EXTKEY,
	'Configuration/TypoScript',
	'Google Maps API Extbase'
);

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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    'go_maps_ext',
    'tx_gomapsext_domain_model_address',
    'categories',
    array(
        // Set a custom label
        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.categories',
        // Override generic configuration, e.g. sort by title rather than by sorting
        'fieldConfiguration' => array(
            'foreign_table_where' => ' AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.title ASC',
        ),
        // string (keyword), see TCA reference for details
        'l10n_mode' => 'exclude',
        // list of keywords, see TCA reference for details
        'l10n_display' => 'hideDiff',
    )
);


?>