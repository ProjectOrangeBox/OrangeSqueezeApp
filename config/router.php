<?php

return [
	'routes' => [
		'/acl' => ['application\controllers\acl', 'test'],
		'/notifications' => ['application\controllers\main', 'notify'],
		'/test' => ['application\controllers\test', 'index'],
		'/test(<number>.*)' => ['application\controllers\test', 'test$number'],
		'/view' => ['application\controllers\main', 'view'],
		'/filtervalidate' => ['application\controllers\filtervalidate', 'index'],
		'/filtervalidate/(<number>.*)' => ['application\controllers\filtervalidate', 'test$number'],
		'/login' => ['application\controllers\login', 'index'],
		'@post/login/process' => ['application\controllers\login', 'process'],
		'/logout' => ['application\controllers\login', 'logout'],
		'/admin(.*)' => ['application\controllers\admin', 'index'],
		'/notify' => ['application\controllers\main', 'notify'],
		'@/' => ['application\controllers\main', 'index'],
		'@/(.*)' => ['application\controllers\main', 'fourohfour'],
	]
];
