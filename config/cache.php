<?php

return [
	'default' => 'file',
	'caches' => [
		'memcache' => 'projectorangebox\cache\handlers\CacheMemcached',
		'redis' => 'projectorangebox\cache\handlers\CacheRedis',
		'apc' => 'projectorangebox\cache\handlers\CacheApc',
		'file' => 'projectorangebox\cache\handlers\CacheFile',
		'dummy' => 'projectorangebox\cache\handlers\CacheDummy',
	],
	'ttl' => 60,
	'file' => [
		'path' => '/var/cache',
	],
	'apc' => [],
	'redis' => [
		'socket_type' => 'tcp',
		'host' => '127.0.0.1',
		'password' => NULL,
		'port' => 6379,
		'timeout' => 0
	],
	'memcache' => [
		'servers' => [
			[
				'hostname' => '127.0.0.1',
				'port' => 11211,
				'weight' => 1,
			]
		]
	],
];
