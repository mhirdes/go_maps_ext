<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Show',
	'Google Map'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_show';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature]='code,layout,select_key,pages,recursive';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_show.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Google Maps API Extbase');

t3lib_extMgm::addLLrefForTCAdescr('tx_gomapsext_domain_model_address', 'EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_address.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_gomapsext_domain_model_address');
$TCA['tx_gomapsext_domain_model_address'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xml:tx_gomapsext_domain_model_address',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,configuration_map,latitude,longitude,address,marker,image_size,image_width,image_height,shadow,shadow_size,shadow_width,shadow_height,info_window_content,info_window_link,close_by_click,open_by_click,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Address.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_gomapsext_domain_model_address.png'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_gomapsext_domain_model_map', 'EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_gomapsext_domain_model_map');
$TCA['tx_gomapsext_domain_model_map'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xml:tx_gomapsext_domain_model_map',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,tooltip_title,class,width,height,zoom,addresses,show_route,calc_route,scroll_zoom,draggable,doubleclick_zoom,default_type,pan_control,scale_control,streetview_control,zoom_control,zoom_control_type,map_type_control,map_types,styled_map_name,styled_map_code,adresses,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Map.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_gomapsext_domain_model_map.png'
	),
);

//include_once(t3lib_extMgm::extPath($_EXTKEY).'class.tx_gomapsext_tca.php'); 

?>