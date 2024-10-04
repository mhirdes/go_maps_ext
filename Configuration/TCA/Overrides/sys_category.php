<?php

defined('TYPO3') or die();

$tempCols = [
    'sorting' => [
        'config' => [
            'type' => 'passthrough'
        ]
    ],
    'gme_marker' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.marker',
        'config' => [
            'type' => 'file',
            'maxitems' => 1,
            'allowed' => 'common-image-types'
        ],
    ],
    'gme_image_size' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.image_size',
        'config' => [
            'type' => 'check',
            'default' => 0
        ],
    ],
    'gme_image_width' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.image_width',
        'config' => [
            'type' => 'number',
        ],
    ],
    'gme_image_height' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.image_height',
        'config' => [
            'type' => 'number',
        ],
    ]
];

// add new fields
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_category', $tempCols);

// new palette
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'sys_category',
    'gme_marker',
    'gme_marker, --linebreak--, gme_image_size, gme_image_width, gme_image_height',
    ''
);

// add fields
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    '--div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:sys_category.tab.map,
	--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.palettes.marker;gme_marker'
);
