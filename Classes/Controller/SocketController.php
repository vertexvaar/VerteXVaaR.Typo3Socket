<?php
declare(strict_types = 1);
namespace VerteXVaaR\Typo3Socket\Controller;

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

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class SocketController
 */
class SocketController
{
    /**
     * @var LoggerInterface
     */
    protected $logger = null;

    /**
     * SocketController constructor.
     */
    public function __construct()
    {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function mainAction(RequestInterface $request, ResponseInterface $response)
    {
        $this->logger->debug('asd');
    }
}
