<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'go_maps_ext',
    'Show',
    [
        \Clickstorm\GoMapsExt\Controller\MapController::class => 'show, preview'
    ],
    // non-cacheable actions
    []
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cms']['db_layout']['addTables']['tx_gomapsext_domain_model_map'][0] = [
    'fList' => 'title,default_type',
    'icon' => true
];

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cms']['db_layout']['addTables']['tx_gomapsext_domain_model_address'][0] = [
    'fList' => 'title, info_window_content',
    'icon' => true
];

// here we register "tx_gomapsext_double6"
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals'][\Clickstorm\GoMapsExt\Evaluation\Double6Evaluator::class] = '';

// add costum backend form elements
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1580467607] = [
    'nodeName' => 'GomapsextMapElement',
    'priority' => 40,
    'class' => \Clickstorm\GoMapsExt\Form\Element\GomapsextMapElement::class
];
