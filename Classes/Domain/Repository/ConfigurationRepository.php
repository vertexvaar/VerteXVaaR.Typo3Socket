<?php
declare(strict_types = 1);
namespace VerteXVaaR\Typo3Socket\Domain\Repository;

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

use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use VerteXVaaR\Typo3Socket\Domain\Model\Configuration;

/**
 * Class ConfigurationRepository
 */
class ConfigurationRepository
{
    /**
     * @var Registry
     */
    protected $registry = null;

    /**
     * ConfigurationRepository constructor.
     */
    public function __construct()
    {
        $this->registry = GeneralUtility::makeInstance(Registry::class);
    }

    /**
     * @return Configuration
     */
    public function get()
    {
        $defaultValue = Configuration::DEFAULT_SETTINGS;
        $settings = $this->registry->get('tx_typo3socket', 'configuration', $defaultValue);
        return GeneralUtility::makeInstance(Configuration::class, $settings);
    }

    /**
     * @param Configuration $configuration
     */
    public function set(Configuration $configuration)
    {
        $this->registry->set('tx_typo3socket', 'configuration', $configuration->toArray());
    }
}
