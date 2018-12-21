<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Google Maps API Extbase',
    'description' => 'Google Maps Extension. Simply insert a google map Version 3 inc. jQuery, calculate a route,
	                  images for markers, style maps, KML, categories, responsive and many more.',
    'category' => 'plugin',
    'version' => '2.6.0',
    'state' => 'stable',
    'uploadfolder' => 1,
    'clearCacheOnLoad' => 1,
    'author' => 'Marc Hirdes',
    'author_email' => 'marc_hirdes@gmx.de',
    'author_company' => 'clickstorm GmbH',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0 - 8.7.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
