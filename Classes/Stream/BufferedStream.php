<?php
declare(strict_types = 1);
namespace VerteXVaaR\Typo3Socket\Stream;

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

use Evenement\EventEmitterTrait;
use React\Socket\Connection;

/**
 * Class BufferedStream
 */
class BufferedStream implements Stream
{
    use EventEmitterTrait;

    /**
     * @var Connection
     */
    protected $connection = null;

    /**
     * @var string
     */
    protected $buffer = '';

    /**
     * BufferedStream constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->on('data', [$this, 'onData']);
    }

    /**
     * @param string $data
     * @param Connection $connection
     * @throws \Exception
     */
    public function onData(string $data, Connection $connection)
    {
        if ($this->connection !== $connection) {
            throw new \Exception('Invalid connection');
        }
        $this->buffer .= $data;
        while (false !== strpos($this->buffer, "\n")) {
            list($sequence, $this->buffer) = explode("\n", $this->buffer, 2);
            $this->emit('data', [trim($sequence), $this]);
        }
    }

    /**
     * @param string $data
     */
    public function writeLine(string $data)
    {
        $this->connection->write(str_replace("\n", "\r\n", $data) . "\r\n");
    }

    /**
     * @param string $data
     */
    public function write(string $data)
    {
        $this->connection->write(str_replace("\n", "\r\n", $data));
    }

    /**
     * @param string|null $data
     */
    public function end(string $data = null)
    {
        $this->connection->end(str_replace("\n", "\r\n", $data) . "\r\n");
    }
}
