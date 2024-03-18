<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Google Maps API Extbase',
    'description' => 'Google Maps Extension. Simply insert a Google Map Version 3 without jQuery, calculate a route,
	                  images for markers, style maps, KML, categories, responsive and many more.',
    'category' => 'plugin',
    'version' => '6.1.2-dev',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Marc Hirdes',
    'author_email' => 'marc_hirdes@gmx.de',
    'author_company' => 'clickstorm GmbH',
    'constraints' => [
        'depends' => [
            'typo3' => '11.0.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
