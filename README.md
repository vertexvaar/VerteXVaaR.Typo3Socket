# VerteXVaaR.Typo3Socket

## What's this?

This TYPO3 extension brings sockets to your TYPO3. The sockets capabilities can be configured in the backend through a module.
The socket will be created on the command line. You can choose if you want to create a UNIX or TCP socket. Each has its pros and cons.
A TYPO3 socket can be used to send data to the DataHandler, FileHandler or run custom code.

## Installation

`composer require vertexvaar/typo3_sockets`

## Usage

After installation and activation you can start the socket on the command line with following command (navigate to your TYPO3 webroot directory first):
`./typo3/cli_dispatch.phpsh socket`

Open another bash and type `telnet 127.0.0.1 8800`, now you have an interactive TYPO3 console. Press enter for command overview.
Open a bunch of additional CLIs and connect them with the telnet command, too. Try commands like `clients`, `exit` or write a message to all connected clients via `broadcast:Hello Clients!`.
You can also access data from the TYPO3 system. Currently this is limited to page properties. Type `show:id:1` to get all page properties of the page with UID 1.

Exchange the `$host` variable with your LAN IP address to connect with other computers to your TYPO3 socket.

## Documentation

TDB

## Use cases

* TBD
* interactive code execution in TYPO3 context
* Access to TYPO3 database without knowing credentials

## Future Features

* Unix socket
* Login with backend account
* Directly stream to DataHandler
* Manage data like users and groups
* runs in background, socket will be assured to be running by cronjob
* much, much more
