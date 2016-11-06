<?php
declare(strict_types = 1);
namespace VerteXVaaR\Typo3Socket\Hooks;

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

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use VerteXVaaR\Typo3Socket\Domain\Model\Configuration;
use VerteXVaaR\Typo3Socket\Domain\Repository\ConfigurationRepository;

/**
 * Class DataHook
 */
class DataHook
{
    /**
     * @var Configuration
     */
    protected $configuration = null;

    /**
     * DataHook constructor.
     */
    public function __construct()
    {
        $this->configuration = GeneralUtility::makeInstance(ConfigurationRepository::class)->get();
    }

    /**
     * @param DataHandler $dataHandler
     */
    public function processDatamap_afterAllOperations(DataHandler $dataHandler)
    {
        $handle = fsockopen($this->configuration->getHost(), $this->configuration->getPort());

        if (!empty($dataHandler->datamap)) {
            $dataString = 'dh:data:' . json_encode($dataHandler->datamap);
            fwrite($handle, $dataString . PHP_EOL);
        }

        fclose($handle);
    }
}
