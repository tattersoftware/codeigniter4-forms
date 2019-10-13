<?php

/* Tatter/Forms Tests
 * Adapted from CodeIgniter 4 RESTful tests
 * tests/system/RESTful/ResourcePresenterTest.php
 * tests/system/RESTful/ResourceControllerTest.php
 */

class ControllerTest extends ModuleTests\Support\DatabaseTestCase
{

	public function testResourceGet()
	{
		$_SERVER['argv']           = [
			'index.php',
			'api',
			'factories',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/factories';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = json_decode(ob_get_clean());
		
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
			'api',
			'factories',
			'show',
			'1',
		];
		$_SERVER['argc']           = 5;
		$_SERVER['REQUEST_URI']    = '/api/factories/show/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = json_decode(ob_get_clean());
		
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
			'api',
			'factories',
			'new',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/api/factories/new';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = json_decode(ob_get_clean());
		
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
			'api',
			'factories',
			'create',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/api/factories/create';
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
			'api',
			'factories',
			'remove',
			'1',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/api/factories/remove/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = json_decode(ob_get_clean());
		
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
			'api',
			'factories',
			'delete',
			'3',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/api/factories/delete/3';
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
			'api',
			'factories',
			'edit',
			'1',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/api/factories/edit/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = json_decode(ob_get_clean());
		
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
			'api',
			'factories',
			'update',
			'1',
		];
		$_SERVER['argc']           = 5;
		$_SERVER['REQUEST_URI']    = '/api/factories/update/1';
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
		
		$factory = $this->model->find(1);
		$this->assertEquals($_POST['name'], $factory->name);	
	}
}
