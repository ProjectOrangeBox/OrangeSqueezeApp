<?php

namespace application\controllers;

use projectorangebox\common\Injectable;

class admin extends Injectable
{
	public function index(): string
	{
		return '<div>Welcome Admin!</div><a href="/logout">Logout</a>';
	}
}
