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

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use VerteXVaaR\Typo3Socket\Domain\Model\Configuration;
use VerteXVaaR\Typo3Socket\Domain\Repository\ConfigurationRepository;

/**
 * Class SocketController
 */
class SocketController extends ActionController
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
     * SocketController constructor.
     */
    public function __construct()
    {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        $this->configurationRepo = GeneralUtility::makeInstance(ConfigurationRepository::class);
        parent::__construct();
    }

    /**
     * @param Configuration $configuration
     */
    public function configureAction(Configuration $configuration = null)
    {
        if (null === $configuration) {
            $configuration = $this->configurationRepo->get();
        } else {
            $this->configurationRepo->set($configuration);
        }
        $this->view->assign('configuration', $configuration);
    }
}
