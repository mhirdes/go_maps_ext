<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY title',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,tooltip_title',
        'iconfile' => 'EXT:go_maps_ext/Resources/Public/Icons/tx_gomapsext_domain_model_map.svg'
    ],
    'types' => [
        '0' => [
            'showitem' => 'title,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.size;size,
					addresses,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.kml;kml,
					--div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.tab.initial,default_type,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.zoom;zoom,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.coordinates;coordinates,
                    --palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.geolocation;geolocation,
					preview_image,
                    --div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.tab.display,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.interaction;interaction,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.address_interaction;address_interaction,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.cluster;cluster,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.additional;additional,
					--div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.tab.controls,
					--palette--;;map_control,--palette--;;controls,
					--div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.tab.route,
					calc_route, travel_mode, unit_system, show_route,
					--div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.tab.style,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.styled_map;styled_map,
					--palette--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.palettes.styled_cluster;styled_cluster,
					--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
					--div--;LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.tab.others,
					hidden, --palette--;;time'
        ]
    ],
    'palettes' => [
        'address_interaction' => ['showitem' => 'marker_search, show_addresses, show_categories'],
        'cluster' => ['showitem' => 'marker_cluster, --linebreak--, marker_cluster_zoom, marker_cluster_size'],
        'controls' => ['showitem' => 'zoom_control, scale_control, streetview_control, fullscreen_control'],
        'coordinates' => ['showitem' => 'latitude, longitude'],
        'geolocation' => ['showitem' => 'geolocation'],
        'interaction' => ['showitem' => 'scroll_zoom, draggable, double_click_zoom'],
        'kml' => ['showitem' => 'kml_url, --linebreak--, kml_preserve_viewport, kml_local'],
        'language' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource'],
        'map_control' => ['showitem' => 'map_type_control, --linebreak--, map_types'],
        'size' => ['showitem' => 'width, height'],
        'styled_map' => ['showitem' => 'styled_map_name, --linebreak--, styled_map_code'],
        'styled_cluster' => ['showitem' => 'marker_cluster_style'],
        'time' => ['showitem' => 'starttime, endtime'],
        'zoom' => ['showitem' => 'zoom, --linebreak--, zoom_min, zoom_max'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_gomapsext_domain_model_map',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
                'default' => 0,
            ],
        ],
        'l10n_source' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => ''
            ]
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ]
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly'
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly'
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'width' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.width',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'required'
            ],
        ],
        'height' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.height',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'required'
            ],
        ],
        'zoom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.zoom',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ],
        ],
        'zoom_min' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.zoom_min',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ],
        ],
        'zoom_max' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.zoom_max',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ],
        ],
        'preview_image' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.preview_image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'preview_image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            'foreign_types' => [
                                '0' => [
                                    'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                                ],
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                                    'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                                ],
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                    'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                                ],
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                                    'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                                ],
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                    'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                                ],
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                                    'showitem' => '
                        --palette--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                                ]
                            ],
                        ]
                    ],
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'addresses' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.addresses',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_gomapsext_domain_model_address',
                'foreign_table' => 'tx_gomapsext_domain_model_address',
                'MM' => 'tx_gomapsext_map_address_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                ],
            ]
        ],
        'kml_url' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.kml_url',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'max' => 500,
                'default' => ''
            ],
        ],
        'kml_local' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.kml_local',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'kml_preserve_viewport' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.kml_preserve_viewport',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'show_addresses' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.show_addresses',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'show_categories' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.show_categories',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'scroll_zoom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.scroll_zoom',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'draggable' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.draggable',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'double_click_zoom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.double_click_zoom',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'marker_cluster' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.marker_cluster',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'marker_cluster_zoom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.marker_cluster_zoom',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ],
        ],
        'marker_cluster_size' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.marker_cluster_size',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ],
        ],
        'marker_cluster_style' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.marker_cluster_style',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 10,
                'eval' => 'trim'
            ],
        ],
        'marker_search' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.marker_search',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'default_type' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.default_type',
            'config' => [
                'type' => 'radio',
                'items' => [
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.0',
                        0
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.1',
                        1
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.2',
                        2
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.3',
                        3
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.4',
                        4
                    ],
                ],
                'eval' => '',
                'default' => 0
            ],
        ],
        'scale_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.scale_control',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'streetview_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.streetview_control',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'fullscreen_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.fullscreen_control',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'zoom_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.zoom_control',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'map_type_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_type_control',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'map_types' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'items' => [
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.0',
                        0
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.1',
                        1
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.2',
                        2
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.3',
                        3
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.4',
                        4
                    ],
                ],
                'size' => 5,
                'default' => '0,1,2',
                'maxitems' => 5,
                'eval' => '',
            ],
        ],
        'show_route' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.show_route',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'calc_route' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.calc_route',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'travel_mode' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode',
            'config' => [
                'type' => 'radio',
                'items' => [
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.0',
                        0
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.1',
                        1
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.2',
                        2
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.3',
                        3
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.4',
                        4
                    ],
                ],
                'eval' => '',
                'default' => 0
            ],
        ],
        'unit_system' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system',
            'config' => [
                'type' => 'radio',
                'items' => [
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system.0',
                        0
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system.1',
                        1
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system.2',
                        2
                    ],
                    [
                        'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system.3',
                        3
                    ],
                ],
                'eval' => '',
                'default' => 2
            ],
        ],
        'styled_map_name' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.styled_map_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'styled_map_code' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.styled_map_code',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'latitude' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.latitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,' . Clickstorm\GoMapsExt\Evaluation\Double6Evaluator::class
            ],
        ],
        'longitude' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.longitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,' . Clickstorm\GoMapsExt\Evaluation\Double6Evaluator::class
            ],
        ],
        'geolocation' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.geolocation',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
    ],
];
