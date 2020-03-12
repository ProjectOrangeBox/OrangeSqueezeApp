<?php

return [
	'default' => 'file',
	'caches' => [
		'dummy' => 'projectorangebox\cache\handlers\CacheDummy',
		'file' => 'projectorangebox\cache\handlers\CacheFile',
	],
	'path' => '/var/cache',
	'ttl' => 5,
];
