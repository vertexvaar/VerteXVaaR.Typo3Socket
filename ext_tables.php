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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
    'tools',
    'sockets',
    '',
    '',
    [
        'routeTarget' => \VerteXVaaR\Typo3Socket\Controller\SocketController::class . '::mainAction',
        'access' => 'admin',
        'name' => 'tools_sockets',
        'icon' => 'EXT:typo3_socket/Resources/Public/Icons/Extension.svg',
        'labels' => 'LLL:EXT:typo3_socket/Resources/Private/Language/module.xlf'
    ]
);
