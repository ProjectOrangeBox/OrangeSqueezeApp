<?php

return [
	'default' => ['get', 'cli', 'post', 'put', 'delete'],

	'request' => [
		'/admin' => 'application\middleware\AdminMiddleware',
		'/admin/(.*)' => 'application\middleware\AdminMiddleware',
	],
];
