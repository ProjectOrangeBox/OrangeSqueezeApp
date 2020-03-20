<?php

return [
	'cookie' => [
		'lifetime' => 600,
		'path' => '/',
		'domain' => '/',
		'secure' => true,
		'httponly' => false,
	],
	'name' => 'application_state',
	'key length' => '64',
	'handler' => 'projectorangebox\session\handlers\FileSessionHandler',
	'file' => [
		'path' => '/var/sessions',
	],
	'database' => [
		'username' => '',
		'password' => '',
		'database' => '',
		'type' => '',
		'host' => '',
		'tablename' => 'session',
	],
	'memcache' => [
		'servers' => [
			['hostname' => '127.0.0.1', 'port' => 11211, 'weight' => 1]
		]
	],
	'redis' => [
		'socket_type' => 'tcp',
		'host' => '127.0.0.1',
		'password' => NULL,
		'port' => 6379,
		'timeout' => 0
	],
];
