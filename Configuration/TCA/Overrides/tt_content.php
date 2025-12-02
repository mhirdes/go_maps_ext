<?php

defined('TYPO3') || die();

$_EXTKEY = 'go_maps_ext';

$plugins = [
    'show' => true,
];

$pluginPrefix = str_replace('_', '', $_EXTKEY);

foreach ($plugins as $pluginName => $hasFlexForm) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $_EXTKEY,
        \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($pluginName),
        'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xlf:plugin.' . $pluginName . '.title',
        'ext-' . $pluginPrefix . '-plugin-' . str_replace('_', '-', $pluginName),
        $pluginPrefix
    );

    $contentTypeName = $pluginPrefix . '_' . str_replace('_', '', $pluginName);

    $GLOBALS['TCA']['tt_content']['types'][$contentTypeName]['showitem'] = '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
    ';

    if ($hasFlexForm) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            '*',
            'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
            $contentTypeName
        );

        $GLOBALS['TCA']['tt_content']['types'][$contentTypeName]['showitem'] .= '
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin,
            pi_flexform,
        ';
    }

    $GLOBALS['TCA']['tt_content']['types'][$contentTypeName]['showitem'] .= '
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ';
}
