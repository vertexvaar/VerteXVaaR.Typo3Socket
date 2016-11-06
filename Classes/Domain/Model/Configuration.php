<?php
declare(strict_types = 1);
namespace VerteXVaaR\Typo3Socket\Domain\Model;

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

/**
 * Class Configuration
 */
class Configuration
{
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT = 8800;
    const DEFAULT_SETTINGS = ['host' => self::DEFAULT_HOST, 'port' => self::DEFAULT_PORT];

    /**
     * @var string
     */
    protected $host = self::DEFAULT_HOST;

    /**
     * @var int
     */
    protected $port = self::DEFAULT_PORT;

    /**
     * Configuration constructor.
     * @param array $config
     */
    public function __construct(array $config = null)
    {
        if (null !== $config) {
            $this->setHost($config['host']);
            $this->setPort($config['port']);
        }
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port)
    {
        $this->port = $port;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return ['host' => $this->host, 'port' => $this->port];
    }
}
