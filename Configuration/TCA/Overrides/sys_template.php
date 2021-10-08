<?php

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'go_maps_ext',
    'Configuration/TypoScript',
    'Google Maps API Extbase'
);
