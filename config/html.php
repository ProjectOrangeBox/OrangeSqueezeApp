<?php

return [
	'script attributes' => ['src' => '', 'type' => 'text/javascript', 'charset' => 'utf-8'],
	'link attributes' => ['href' => '', 'type' => 'text/css', 'rel' => 'stylesheet'],
	'elements' => [
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
