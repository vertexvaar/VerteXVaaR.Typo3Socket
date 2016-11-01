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

$GLOBALS['TYPO3_CONF_VARS']['LOG']['VerteXVaaR']['Typo3Socket'] = [
    'writerConfiguration' => [
        \TYPO3\CMS\Core\Log\LogLevel::DEBUG => [
            \TYPO3\CMS\Core\Log\Writer\DatabaseWriter::class => [
                'logTable' => 'tx_typo3socket_log',
            ],
        ],
    ],
    'processorConfiguration' => [
        \TYPO3\CMS\Core\Log\LogLevel::DEBUG => [
            \VerteXVaaR\Typo3Socket\Log\Processor\BackendUserProcessor::class => [],
        ],
        \TYPO3\CMS\Core\Log\LogLevel::WARNING => [
            \TYPO3\CMS\Core\Log\Processor\IntrospectionProcessor::class => [],
        ],
        \TYPO3\CMS\Core\Log\LogLevel::CRITICAL => [
            \TYPO3\CMS\Core\Log\Processor\IntrospectionProcessor::class => [
                'appendFullBackTrace' => true,
            ],
        ],
    ],
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['cliKeys']['socket'] = array(
    function () {
        $socketManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \VerteXVaaR\Typo3Socket\Socket\SocketManager::class
        );
        $socketManager->run();
    },
    '_CLI_socket',
);
