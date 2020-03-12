<?php

namespace application\controllers;

use projectorangebox\html\Html;
use projectorangebox\common\Injectable;
use projectorangebox\data\Data;

class test extends Injectable
{

	public function test1()
	{
		$this->html->js('bbb.js', Html::PRIORITY_LOWEST);
		$this->html->js('aaa.js', Html::PRIORITY_HIGHEST);
		$this->html->js('ccc.js', Html::PRIORITY_LOW);

		var_dump($this->html);

		var_dump($this->html->get('js'));
	}

	public function test2()
	{
		$data = [
			'name' => 'Johnny Appleseed',
			'age' => 23,
		];

		$this->html->js('foobar.js', Html::PRIORITY_HIGHEST);

		return $this->view->parse('test11', $data);
	}

	public function test3()
	{
		$data = [
			'name' => 'Johnny Appleseed',
			'age' => 23,
		];

		return $this->view->parse('main/index', $data);
	}

	public function test4()
	{
		$data = [
			'name' => 'Johnny Appleseed',
			'age' => 23,
		];

		return $this->view->hbs->parse('main/index', $data);
	}

	public function test5()
	{

		$this->simpleq->push(['welcome' => 'Hello World'], 'cats');

		$record = $this->simpleq->pull('cats');

		//$record->complete();
	}

	public function test6()
	{
		echo '<pre>';

		$config = ['sessionService' => service('session')];
		$data = new \projectorangebox\data\Data($config);

		$data->set('name', 'Johnny Appleseed', true);
		$data->set('foo.firstname', 'Johnny');
		$data->set('foo.lastname', 'Appleseed');
		$data->push('user.age', 23);
		$data->push('user.age', 21);
		$data->push('user.age', 18);

		$dot = $data->all(true);

		var_dump($dot['foo']['lastname']);
	}

	public function test7()
	{
		echo \password_hash('password', PASSWORD_DEFAULT);
	}
} /* end class */
