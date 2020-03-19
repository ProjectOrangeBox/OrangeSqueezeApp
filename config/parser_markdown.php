<?php

return [
	'cache folder' => '/var/views/md',
	'forceCompile' => true,
	'search' => [
		'(.*)/views/(?<key>.*)\.md'
	],
	'merge' => true,
];
