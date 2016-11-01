<?php

/**
 * TYPO3 Socket; Copyright (C) 2016 Oliver Eglseder <php@vxvr.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Sockets',
    'description' => 'Creates Sockets for fast interaction with TYPO3',
    'category' => 'services',
    'state' => 'experimental',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Oliver Eglseder',
    'author_email' => 'php@vxvr.de',
    'author_company' => 'vxvr.de',
    'version' => '0.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.11-8.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
