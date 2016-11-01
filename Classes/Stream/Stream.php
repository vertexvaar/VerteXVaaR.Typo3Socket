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
use React\Socket\Connection;

/**
 * Interface Stream
 */
interface Stream
{
    /**
     * Connection to the client
     *
     * Stream constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection);
    /**
     * Outputs a line with CRLF to the client
     *
     * @param string $data
     * @return void
     */
    public function writeLine(string $data);

    /**
     * Outputs a line without line ending or carriage return to the client
     *
     * @param string $data
     * @return void
     */
    public function write(string $data);

    /**
     * @param string|null $data
     * @return void
     */
    public function end(string $data = null);
}
