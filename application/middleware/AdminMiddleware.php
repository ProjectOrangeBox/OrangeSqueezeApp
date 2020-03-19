<?php

namespace application\middleware;

use projectorangebox\middleware\MiddlewareAbstract;
use projectorangebox\middleware\MiddlewareRequestInterface;

class AdminMiddleware extends MiddlewareAbstract implements MiddlewareRequestInterface
{

	public function request(): void
	{
		if (!$this->user->loggedIn()) {
			$this->data->set('error', ['status' => 'danger', 'msg' => 'Please Login First.'], true);

			redirect('/login');
		}
	}
}
