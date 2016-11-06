<?php
declare(strict_types = 1);
namespace VerteXVaaR\Typo3Socket\Server;

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
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Socket\Connection;
use React\Socket\Server;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use VerteXVaaR\Typo3Socket\Stream\BufferedStream;
use VerteXVaaR\Typo3Socket\Stream\Stream;

/**
 * Class StreamServer
 */
class TcpSocketServer implements SocketServer
{
    /**
     * @var int
     */
    protected $port = 0;

    /**
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * @var LoopInterface
     */
    protected $loop = null;

    /**
     * @var Stream[]
     */
    protected $streams = [];

    /**
     * @var LoggerInterface
     */
    protected $logger = null;

    /**
     * TcpSocketServer constructor.
     * @param int $port
     * @param string $host
     */
    public function __construct(int $port, string $host = '127.0.0.1')
    {
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(get_class($this));
        $this->port = $port;
        $this->host = $host;
    }

    /**
     *
     */
    public function run()
    {
        $this->loop = Factory::create();
        $server = new Server($this->loop);
        $server->on('connection', [$this, 'onConnect']);
        $server->listen($this->port, $this->host);
        $this->loop->run();
    }

    /**
     * @param Connection $connection
     */
    public function onConnect(Connection $connection)
    {
        $version = ExtensionManagementUtility::getExtensionVersion('typo3_socket');
        $stream = new BufferedStream($connection);
        $this->streams[spl_object_hash($stream)] = $stream;
        $stream->writeLine('TYPO3 Socket version ' . $version . ', Copyright (C) 2016 Oliver Eglseder <php@vxvr.de>');
        $stream->writeLine('TYPO3 Socket comes with ABSOLUTELY NO WARRANTY;');
        $stream->writeLine('This is free software, and you are welcome to redistribute it under certain conditions');
        $stream->writeLine('See the LICENSE file of this package for more information.');
//        $stream->write('T3S> ');
        $stream->on('data', [$this, 'onData']);
    }

    /**
     * Keep in mind that this event is triggered for nearly each char for a windows client.
     * Internal buffers are required to assure sequencing the input.
     *
     * @param Stream $stream
     * @param string $data
     */
    public function onData(string $data, Stream $stream)
    {
        $backspace = chr(8);
        while (false !== strpos($data, $backspace)) {
            $data = preg_replace('/.' . $backspace . '/', '', $data, 1);
        }

        // Some commands to fathom all the possibilities

        if ('exit' === $data) {
            unset($this->streams[spl_object_hash($stream)]);
            $stream->end('Goodbye');
        } elseif ('clients' === $data) {
            $stream->writeLine('Number of active clients: ' . count($this->streams));
        } elseif (0 === strpos($data, 'dh:data:')) {
            $GLOBALS['BE_USER']->user['admin'] = 1;
            $data = substr($data, 8);
            $array = json_decode($data, true);

            $this->logger->info('rec dh data', $array);

            $datahandler = GeneralUtility::makeInstance(DataHandler::class);
            $datahandler->start($array, []);
            $datahandler->process_datamap();

            $stream->writeLine('Done');
        } elseif (0 === strpos($data, 'broadcast:')) {
            $message = escapeshellcmd(trim(substr($data, 10)));
            foreach ($this->streams as $stream) {
                $stream->writeLine('');
                $stream->writeLine('T3S BROADCAST: ' . $message);
//                $stream->write('T3S> ');
            }
            return;
        } elseif ('shutdown' === $data) {
            foreach ($this->streams as $index => $stream) {
                $stream->end('Server shutdown');
                unset($this->streams[$index]);
            }
            // "flush" the shutdown message
            $this->loop->tick();
            $this->loop->stop();
        } elseif (0 === strpos($data, 'show:id:')) {
            $uid = (int)explode(':', $data)[2];

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $count = $queryBuilder->count('uid')
                                  ->from('pages')
                                  ->where($queryBuilder->expr()->eq('uid', $uid))
                                  ->execute()
                                  ->fetchColumn(0);
            if (1 !== $count) {
                $stream->writeLine('Page with UID [' . $uid . '] not found');
            } else {
                $stream->writeLine('Showing page properties of page [' . $uid . ']');
                $page = $queryBuilder->select('*')
                                     ->from('pages')
                                     ->where($queryBuilder->expr()->eq('uid', $uid))
                                     ->execute()
                                     ->fetch();
                $stream->writeLine(print_r($page, true));
            }
        } else {
            $stream->writeLine('Your command could not be identified');
            $stream->writeLine('');
            $stream->writeLine('Available Commands:');
            $stream->writeLine('    clients       show the number of currently connected clients');
            $stream->writeLine('    shutdown      stop the TYPO3 socket server');
            $stream->writeLine('    show:id:X     show all properties of the page with UID X');
            $stream->writeLine('    broadcast:X   send a message X to all connected clients');
        }
//        $stream->write('T3S> ');
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabase()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
