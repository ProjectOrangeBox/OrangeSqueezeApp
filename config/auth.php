<?php

return [
	'admin user' => 1,
	'guest user' => 2,

	'admin role' => 1,
	'everyone role' => 2,

	'empty fields error' => 'Missing Required Field.',
	'general error' => 'Login Error.',
	'incorrect password error' => 'Login Error.',
	'not activated error' => 'Your user is not active.',

	'table' => 'orange_users',
	'username column' => 'email',
	'password column' => 'password',
	'is active column' => 'is_active',

	'user table' => 'orange_users',
	'role table' => 'orange_roles',
	'permission table' => 'orange_permissions',
	'user role table' => 'orange_user_role',
	'role permission table' => 'orange_role_permission',
];
