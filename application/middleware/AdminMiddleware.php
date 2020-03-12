<?php

namespace application\middleware;

use projectorangebox\middleware\Middleware;
use projectorangebox\middleware\MiddlewareRequestInterface;

class AdminMiddleware extends Middleware implements MiddlewareRequestInterface
{

	public function request(): void
	{
		if (!$this->user->loggedIn()) {
			$this->data->set('error', ['status' => 'danger', 'msg' => 'Please Login First.'], true);

			redirect('/login');
		}
	}
}
