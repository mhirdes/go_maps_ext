<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
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
        'security' => [
            'ignorePageTypeRestriction' => true,
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
					--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
					hidden, --palette--;;time',
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
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'group',
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
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.title',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:title.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'required' => true,
                'eval' => 'trim'
            ],
        ],
        'width' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.width',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:width.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'required' => true,
            ],
        ],
        'height' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.height',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:height.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'required' => true,
            ],
        ],
        'zoom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.zoom',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:zoom.description',
            'config' => [
                'type' => 'number',
            ],
        ],
        'zoom_min' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.zoom_min',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:zoom_min.description',
            'config' => [
                'type' => 'number',
            ],
        ],
        'zoom_max' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.zoom_max',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:zoom_max.description',
            'config' => [
                'type' => 'number',
            ],
        ],
        'preview_image' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.preview_image',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:preview_image.description',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'common-image-types'
            ],
        ],
        'addresses' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.addresses',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:addresses.description',
            'config' => [
                'type' => 'group',
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
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:kml_url.description',
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
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:kml_local.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'kml_preserve_viewport' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.kml_preserve_viewport',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:kml_preserve_viewport.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'show_addresses' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.show_addresses',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:show_addresses.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'show_categories' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.show_categories',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:show_categories.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'scroll_zoom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.scroll_zoom',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:scroll_zoom.description',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'draggable' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.draggable',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:draggable.description',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'double_click_zoom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.double_click_zoom',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:double_click_zoom.description',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'marker_cluster' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.marker_cluster',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:marker_cluster.description',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'marker_cluster_zoom' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.marker_cluster_zoom',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:marker_cluster_zoom.description',
            'config' => [
                'type' => 'number',
            ],
        ],
        'marker_cluster_size' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.marker_cluster_size',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:marker_cluster_size.description',
            'config' => [
                'type' => 'number',
            ],
        ],
        'marker_cluster_style' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.marker_cluster_style',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:marker_cluster_style.description',
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
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:marker_search.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'default_type' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.default_type',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:default_type.description',
            'config' => [
                'type' => 'radio',
                'items' => [
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.0',
                        'value' => 0
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.1',
                        'value' => 1
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.2',
                        'value' => 2
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.3',
                        'value' => 3
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.display.default.4',
                        'value' => 4
                    ],
                ],
                'eval' => '',
                'default' => 0
            ],
        ],
        'scale_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.scale_control',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:scale_control.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'streetview_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.streetview_control',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:streetview_control.description',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'fullscreen_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.fullscreen_control',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:fullscreen_control.description',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'zoom_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.zoom_control',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:zoom_control.description',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'map_type_control' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_type_control',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:map_type_control.description',
            'config' => [
                'type' => 'check',
                'default' => 1
            ],
        ],
        'map_types' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:map_types.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'items' => [
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.0',
                        'value' => 0
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.1',
                        'value' => 1
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.2',
                        'value' => 2
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.3',
                        'value' => 3
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.map_types.4',
                        'value' => 4
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
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:show_route.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'calc_route' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.calc_route',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:calc_route.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'travel_mode' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:travel_mode.description',
            'config' => [
                'type' => 'radio',
                'items' => [
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.0',
                        'value' => 0
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.1',
                        'value' => 1
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.2',
                        'value' => 2
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.3',
                        'value' => 3
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.travel_mode.4',
                        'value' => 4
                    ],
                ],
                'eval' => '',
                'default' => 0
            ],
        ],
        'unit_system' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:unit_system.description',
            'config' => [
                'type' => 'radio',
                'items' => [
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system.0',
                        'value' => 0
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system.1',
                        'value' => 1
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system.2',
                        'value' => 2
                    ],
                    [
                        'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.unit_system.3',
                        'value' => 3
                    ],
                ],
                'eval' => '',
                'default' => 2
            ],
        ],
        'styled_map_name' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.styled_map_name',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:styled_map_name.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'styled_map_code' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.styled_map_code',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:styled_map_code.description',
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
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:latitude.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,' . Clickstorm\GoMapsExt\Evaluation\Double6Evaluator::class
            ],
        ],
        'longitude' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.longitude',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:longitude.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,' . Clickstorm\GoMapsExt\Evaluation\Double6Evaluator::class
            ],
        ],
        'geolocation' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_db.xlf:tx_gomapsext_domain_model_map.geolocation',
            'description' => 'LLL:EXT:go_maps_ext/Resources/Private/Language/locallang_csh_tx_gomapsext_domain_model_map.xlf:geolocation.description',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
    ],
];
