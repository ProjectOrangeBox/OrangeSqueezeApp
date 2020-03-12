<?php

namespace application\controllers;

use projectorangebox\common\Injectable;

class main extends Injectable
{
	public function index(): string
	{
		return $this->view->vars(['name' => 'Johnny Appleseed', 'age' => 21])->build('main/index');
	}

	public function fourohfour(): void
	{
		$this->viewresponse->response(404)->view(['title' => 'Error!', 'body' => 'Page Not Found.'], 'show_error');
	}

	public function notify(): void
	{
		$this->viewresponse->response(200)->view(['json' => ['error' => $this->data->get('error')]], 'json');
	}
}/* end class */
