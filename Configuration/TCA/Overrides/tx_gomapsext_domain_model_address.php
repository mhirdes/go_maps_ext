<?php

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    'go_maps_ext',
    'tx_gomapsext_domain_model_address',
    'categories',
    [
        // Set a custom label
        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.categories',
        // Override generic configuration, e.g. sort by title rather than by sorting
        'fieldConfiguration' => [
            'foreign_table_where' => ' AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.title ASC',
        ],
        // string (keyword), see TCA reference for details
        'l10n_mode' => 'exclude',
        // list of keywords, see TCA reference for details
        'l10n_display' => 'hideDiff',
    ]
);
