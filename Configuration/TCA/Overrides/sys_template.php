<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
	'go_maps_ext',
	'Configuration/TypoScript',
	'Google Maps API Extbase'
);