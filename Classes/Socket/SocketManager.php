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
use VerteXVaaR\Typo3Socket\Domain\Repository\ConfigurationRepository;
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
     * @var ConfigurationRepository
     */
    protected $configurationRepo = null;

    /**
     * SocketManager constructor.
     */
    public function __construct()
    {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(get_class($this));
        $this->configurationRepo = GeneralUtility::makeInstance(ConfigurationRepository::class);
    }

    /**
     *
     */
    public function run()
    {
        $configuration = $this->configurationRepo->get();
        $this->logger->info(
            'Creating TCP socket server on tcp://' . $configuration->getHost() . ':' . $configuration->getPort()
        );
        $tcpSocketServer = new TcpSocketServer($configuration->getPort(), $configuration->getHost());
        $tcpSocketServer->run();
    }
}
