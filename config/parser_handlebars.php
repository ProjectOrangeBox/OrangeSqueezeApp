<?php

return [
	'cache folder' => '/var/views/handlebars',
	'forceCompile' => true,
	'search' => [
		'(.*)/views/(?<key>.*)\.hbs'
	],
	'helper search' => [
		'(.*)/hbsPlugins/(?<key>.*)\.hbs.php'
	],
];
