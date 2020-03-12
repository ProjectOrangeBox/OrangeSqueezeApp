<?php

return [
	'routes' => [
		'/notifications' => ['\quadratec\controllers\notifications', 'index'],
		'/test' => ['\application\controllers\test', 'index'],
		'/test(<number>.*)' => ['\application\controllers\test', 'test$number'],
		'/view' => ['\quadratec\controllers\main', 'view'],
		'/filtervalidate' => ['\quadratec\controllers\filtervalidate', 'index'],
		'/filtervalidate/(<number>.*)' => ['\quadratec\controllers\filtervalidate', 'test$number'],
		'/login' => ['\application\controllers\login', 'index'],
		'@post/login/process' => ['\application\controllers\login', 'process'],
		'/logout' => ['\application\controllers\login', 'logout'],
		'/admin(.*)' => ['\application\controllers\admin', 'index'],
		'/notify' => ['\application\controllers\main', 'notify'],
		'@/' => ['\application\controllers\main', 'index'],
		'@/(.*)' => ['\application\controllers\main', 'fourohfour'],
	]
];
