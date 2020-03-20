<?php

namespace application\controllers;

use projectorangebox\common\Injectable;

class acl extends Injectable
{

	public function test(): void
	{
		echo '<pre>';

		$data = [
			'key' => 'test::folder/folder/file',
			'description' => 'Test Item',
			'group' => 'Test',
		];

		$this->acl->permission->insert($data);

		var_dump('permission', $this->acl->permission->errors());

		$permission = $this->acl->permissions->getBy(['key' => 'test::folder/folder/file']);

		var_dump('permission', $permission);

		$data = [
			'name' => 'Head-Dude',
			'description' => 'Head Person',
		];

		$this->acl->role->insert($data);

		var_dump('role', $this->acl->role->errors());

		$role = $this->acl->roles->getBy(['name' => 'Head-Dude']);

		var_dump('role', $role);

		$user = $this->acl->users->getBy(['email' => 'pbowman@quadratec.com']);

		var_dump('user', $user);

		$this->acl->users->addRole($user['id'], $role['id']);

		$userFull = $this->acl->getUser($user['id']);

		var_dump('userFull', $userFull);
	}
} /* end class */
