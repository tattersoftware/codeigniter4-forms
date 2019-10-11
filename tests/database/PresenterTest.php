<?php

/* Tatter/Forms Tests
 * Adapted from CodeIgniter 4 framework tests
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
		$output = ob_get_clean();
		
		$expected = json_encode($this->model->findAll());
		$this->assertEquals($expected, $output);
	}
/*
	public function testResourceShow()
	{
		$_SERVER['argv']           = [
			'index.php',
			'work',
			'show',
			'1',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/work/show/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = ob_get_clean();

		$this->assertContains(lang('RESTful.notImplemented', ['show']), $output);
	}

	public function testResourceNew()
	{
		$_SERVER['argv']           = [
			'index.php',
			'work',
			'new',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/work/new';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = ob_get_clean();

		$this->assertContains(lang('RESTful.notImplemented', ['new']), $output);
	}

	public function testResourceCreate()
	{
		$_SERVER['argv']           = [
			'index.php',
			'work',
			'create',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/work/create';
		$_SERVER['REQUEST_METHOD'] = 'POST';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = ob_get_clean();

		$this->assertContains(lang('RESTful.notImplemented', ['create']), $output);
	}

	public function testResourceRemove()
	{
		$_SERVER['argv']           = [
			'index.php',
			'work',
			'remove',
			'123',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/work/remove/123';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = ob_get_clean();

		$this->assertContains(lang('RESTful.notImplemented', ['remove']), $output);
	}

	public function testResourceDelete()
	{
		$_SERVER['argv']           = [
			'index.php',
			'work',
			'delete',
			'123',
		];
		$_SERVER['argc']           = 3;
		$_SERVER['REQUEST_URI']    = '/work/delete/123';
		$_SERVER['REQUEST_METHOD'] = 'POST';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = ob_get_clean();

		$this->assertContains(lang('RESTful.notImplemented', ['delete']), $output);
	}

	public function testResourceEdit()
	{
		$_SERVER['argv']           = [
			'index.php',
			'work',
			'edit',
			'1',
			'edit',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/work/edit/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = ob_get_clean();

		$this->assertContains(lang('RESTful.notImplemented', ['edit']), $output);
	}

	public function testResourceUpdate()
	{
		$_SERVER['argv']           = [
			'index.php',
			'work',
			'update',
			'123',
		];
		$_SERVER['argc']           = 4;
		$_SERVER['REQUEST_URI']    = '/work/update/123';
		$_SERVER['REQUEST_METHOD'] = 'POST';

		ob_start();
		$this->codeigniter->useSafeOutput(true)->run($this->routes);
		$output = ob_get_clean();

		$this->assertContains(lang('RESTful.notImplemented', ['update']), $output);
	}
*/
}
