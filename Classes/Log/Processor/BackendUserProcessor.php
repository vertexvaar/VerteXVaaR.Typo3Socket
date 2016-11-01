<?php
declare(strict_types = 1);
namespace VerteXVaaR\Typo3Socket\Log\Processor;

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

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Log\LogRecord;
use TYPO3\CMS\Core\Log\Processor\AbstractProcessor;

/**
 * Class BackendUserProcessor
 */
class BackendUserProcessor extends AbstractProcessor
{
    /**
     * @param LogRecord $logRecord
     * @return LogRecord
     */
    public function processLogRecord(LogRecord $logRecord)
    {
        if (null !== $backendUser = $this->getBackendUser()) {
            $logRecord->addData(['backend_user' => $backendUser->user['uid']]);
        }
        return $logRecord;
    }

    /**
     * @return BackendUserAuthentication|null
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'] ?? null;
    }
}
