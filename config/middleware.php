<?php

return [

	'request' => [
		'/admin' => '\application\middleware\AdminMiddleware',
		'/admin/(.*)' => '\application\middleware\AdminMiddleware',
	],

];
