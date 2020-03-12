<?php

/*
Send in page values for ALL pages arrays of values also supported

meta
	'meta'=>['attr'=>'','name'=>'','content'=>'']

script
	'script'=>'alert("Welcome!");'

domready
	'domready'=>'alert("Page Loaded");'

title
	'title'=>''

style
	'style'=>'* {font-family: roboto}'

js
	'js'=>'/assets/javascript.js'

css
	'css'=>'/assets/application.css'

body_class
	'body_class'=>'app'


On DOM ready: document.addEventListener("DOMContentLoaded",function(e){
	<?=pear::var('domready') ?>
});',

*/

return [
	'cache folder' => '/var/views/page',
	'forceCompile' => true,
	'search' => ['(.*)/views/(?<key>.*)\.php'],
	'script attributes' => ['src' => '', 'type' => 'text/javascript', 'charset' => 'utf-8'],
	'link attributes' => ['href' => '', 'type' => 'text/css', 'rel' => 'stylesheet'],
	'define' => [
		'PAGEMIN' => ((ENVIRONMENT == 'production') ? '' : '.min'),
	],
	'page_prefix' => 'page_',
	'page_' => [
		'title' => ['SkyNet'],
		'add' => [
			['css', '<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">'],
			['css', '<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">'],
			['css', '<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">'],
		],
		'css' => [
			'/dist/css/bundle.css'
		],
		'js' => [
			'/dist/js/bundle.js'
		],
		'domready' => ['document.getElementById("container").classList.remove("hide-until-domready");
		var getNotifications = new XMLHttpRequest();

getNotifications.open(\'GET\', \'/notifications\', true);

getNotifications.onload = function() {
  if (this.status >= 200 && this.status < 400) {
    var data = JSON.parse(this.response);
		document.getElementById("notify").innerHTML = \'<div class="alert alert-\' + data.errors.status + \'" role="alert">\' + data.errors.msg + \'</div>\';
  }
};

getNotifications.send();'],
	],
];
