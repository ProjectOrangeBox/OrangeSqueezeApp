<?php

namespace application\controllers;

use Birke\Rememberme\Authenticator;
use Birke\Rememberme\Cookie\PHPCookie;
use projectorangebox\common\Injectable;
use Birke\Rememberme\Storage\FileStorage;

class login extends Injectable
{
	public function index(): string
	{
		$userId = $this->rememberme->get();

		if ($userId > 0) {
			$this->user->setUserId($userId);

			redirect('/admin');
		}

		return $this->view->build('main/login');
	}

	public function process(): void
	{
		if ($this->auth->login($this->request->request('username'), $this->request->request('password'))) {
			$this->user->setUserId($this->auth->userId());

			if ($this->request->request('remember') == '1') {
				$this->rememberme->save($this->auth->userId());
			}

			redirect('/admin');
		}

		$this->data->set('error', ['status' => 'danger', 'msg' => $this->auth->error()], true);

		redirect('/login');
	}

	public function logout(): void
	{
		if ($this->auth->logout()) {
			$this->user->setUserGuest();
			$this->rememberme->remove();
		}

		redirect('/login');
	}
} /* end class */
