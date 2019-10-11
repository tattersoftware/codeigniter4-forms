<?php

/* Tatter/Forms Tests
 * Adapted from CodeIgniter 4 framefactories tests
 * tests/system/RESTful/ResourcePresenterTest.php
 * tests/system/RESTful/ResourceControllerTest.php
 */

class PresenterTest extends ModuleTests\Support\DatabaseTestCase
{

	public function testResourceGet()
	{
		$_SERVER['argv']           = [
			'index.php',
			'factories',
		];
		$_SERVER['argc']           = 2;
		$_SERVER['REQUEST_URI']    = '/factories';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = unserialize(ob_get_clean());
		
		$expected = [
			'view' => 'factories/index',
			'data' => [
				'factories' => $this->model->findAll(),
			],
		];
		
		$this->assertEquals($expected, $output);
	}

	public function testResourceShow()
	{
		$_SERVER['argv']           = [
			'index.php',
			'factories',
			'show',
			'1',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/factories/show/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = unserialize(ob_get_clean());
		
		$expected = [
			'view' => 'factories/show',
			'data' => [
				'factory' => $this->model->find(1),
			],
		];
		
		$this->assertEquals($expected, $output);
	}

	public function testResourceNew()
	{
		$_SERVER['argv']           = [
			'index.php',
			'factories',
			'new',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/factories/new';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = unserialize(ob_get_clean());
		
		$expected = [
			'view' => 'factories/new',
			'data' => [],
		];
		
		$this->assertEquals($expected, $output);
	}

	public function testResourceCreate()
	{
		$_SERVER['argv']           = [
			'index.php',
			'factories',
			'create',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/factories/create';
		$_SERVER['REQUEST_METHOD'] = 'POST';
		
		$_POST['name']    = 'Rainbow Factory';
		$_POST['uid']     = 'bow';
		$_POST['class']   = 'ModuleTests\Rainbows\Factory';
		$_POST['icon']    = '';
		$_POST['summary'] = '';
		
		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = ob_get_clean();
		
		$this->assertEquals('', $output);
		
		$factory = $this->model->find(4);
		$this->assertEquals($_POST['name'], $factory->name);		
	}

	public function testResourceRemove()
	{
		$_SERVER['argv']           = [
			'index.php',
			'factories',
			'remove',
			'1',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/factories/remove/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = unserialize(ob_get_clean());
		
		$expected = [
			'view' => 'factories/remove',
			'data' => [
				'factory' => $this->model->find(1),
			],
		];
		
		$this->assertEquals($expected, $output);
	}

	public function testResourceDelete()
	{
		$this->assertNotNull($this->model->find(3));
		
		$_SERVER['argv']           = [
			'index.php',
			'factories',
			'delete',
			'3',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/factories/delete/3';
		$_SERVER['REQUEST_METHOD'] = 'POST';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = ob_get_clean();
		
		$this->assertEquals('', $output);
		
		$this->assertNull($this->model->find(3));
	}

	public function testResourceEdit()
	{
		$_SERVER['argv']           = [
			'index.php',
			'factories',
			'edit',
			'1',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/factories/edit/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = unserialize(ob_get_clean());
		
		$expected = [
			'view' => 'factories/edit',
			'data' => [
				'factory' => $this->model->find(1),
			],
		];
		
		$this->assertEquals($expected, $output);
	}

	public function testResourceUpdate()
	{
		$_SERVER['argv']           = [
			'index.php',
			'factories',
			'update',
			'1',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/factories/update/1';
		$_SERVER['REQUEST_METHOD'] = 'POST';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = unserialize(ob_get_clean());
		
		$expected = [
			'view' => 'factories/update',
			'data' => [],
		];
		
		$this->assertEquals($expected, $output);
	}
}
