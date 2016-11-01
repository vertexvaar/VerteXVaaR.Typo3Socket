<?php
declare(strict_types = 1);
namespace VerteXVaaR\Typo3Socket\Socket;

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

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use VerteXVaaR\Typo3Socket\Server\TcpSocketServer;

/**
 * Class SocketManager
 */
class SocketManager
{
    /**
     * @var LoggerInterface
     */
    protected $logger = null;

    /**
     * SocketManager constructor.
     */
    public function __construct()
    {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(get_class($this));
    }

    /**
     *
     */
    public function run()
    {
        $port = 8800;
        $host = '127.0.0.1';
        $this->logger->info('Creating TCP socket server on tcp://' . $host . ':' . $port);
        $tcpSocketServer = new TcpSocketServer($port, $host);
        $tcpSocketServer->run();
    }
}
