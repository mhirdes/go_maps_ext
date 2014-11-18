<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return array(
    'ctrl' => array(
        'title'	=> 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY title',
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
        'searchFields' => 'title,address,info_window_content',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('go_maps_ext') . 'Resources/Public/Icons/tx_gomapsext_domain_model_address.png'
    ),
	'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, categories,
                                  configuration_map, latitude, longitude, address, marker, image_size, image_width,
                                  image_height, shadow, shadow_size, shadow_width, shadow_height, info_window_content,
                                  info_window_link, close_by_click, open_by_click',
	),
	'types' => array (
		'0' => array('showitem' => 'title,configuration_map;;1,
					--div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.style,
					marker,image_size;;2, shadow, shadow_size;;3,
					--div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.info_window,
					info_window_content;;4;richtext[]:rte_transform[mode=ts_css|imgpath=uploads/tx_gomapsap/rte/], open_by_click, close_by_click, opened,
					--div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.others,
					sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;5,categories')
	),
	'palettes' => array (
		'1' => array('showitem' => 'latitude, longitude, address'),
		'2' => array('showitem' => 'image_width, image_height'),
		'3' => array('showitem' => 'shadow_width, shadow_height'),
		'4' => array('showitem' => 'info_window_link'),
        '5' => array('showitem' => 'starttime, endtime'),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_gomapsext_domain_model_address',
				'foreign_table_where' => 'AND tx_gomapsext_domain_model_address.pid=###CURRENT_PID### AND tx_gomapsext_domain_model_address.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
        'categories' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.categories',
            'config' => array(
                'type' => 'select',
                'internal_type' => 'db',
                'allowed' => 'tx_gomapsext_domain_model_category',
                'foreign_table' => 'tx_gomapsext_domain_model_category',
                'MM' => 'tx_gomapsext_address_category_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 1,
                'wizards' => array(
                    '_POSITION' => 'right',
                    '_PADDING' => 4,
                    '_VERTICAL' => 0,
                    '_DISTANCE' => 2,
                    'edit' => array(
                        'type' => 'popup',
                        'title' => 'Edit',
                        'script' => 'wizard_edit.php',
                        'icon' => 'edit2.gif',
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                    ),
                    'add' => Array(
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table' => 'tx_gomapsext_domain_model_category',
                            'setValue' => 'prepend'
                        ),
                        'script' => 'wizard_add.php',
                    ),
                ),
            ),
        ),
		'configuration_map' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.configuration_map',
			'config' => array(
				'type' => 'user',	
				'userFunc' => 'tx_gomapsext_tca->render',
				'parameters' => array(
					'longitude' => 'longitude',
					'latitude' => 'latitude',
					'address' => 'address',
				),
			),
		),
		'latitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.latitude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double,trim,required'
			),
		),
		'longitude' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.longitude',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double,trim,required'
			),
		),
		'address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'marker' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.marker',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'uploadfolder' => 'uploads/tx_gomapsext',
				'show_thumbs' => 1,
				'size' => 1,
				'max' => 1,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'disallowed' => '',
			),
		),
		'image_size' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.image_size',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'image_width' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.image_width',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'image_height' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.image_height',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'shadow' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.shadow',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'uploadfolder' => 'uploads/tx_gomapsext',
				'show_thumbs' => 1,
				'size' => 1,
				'max' => 1,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'disallowed' => '',
			),
		),
		'shadow_size' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.shadow_size',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'shadow_width' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.shadow_width',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'shadow_height' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.shadow_height',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'info_window_content' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.info_window_content',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'script' => 'wizard_rte.php',
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
			'defaultExtras' => 'richtext[]',
		),
		'info_window_link' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.info_window_link',
			'config' => array(
				'type' => 'radio',
				'items' => array(
					Array('LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.info_window_link.0', 0),
                    Array('LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.info_window_link.1', 1),
                    Array('LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.info_window_link.2', 2)
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'close_by_click' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.close_by_click',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'open_by_click' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.open_by_click',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'opened' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_address.opened',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
        'map' => array(
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_gomapsext_domain_model_map',
                'MM' => 'tx_gomapsext_map_address_mm',
                'MM_opposite_field' => 'map',
            ),
        ),
	),
);

?>