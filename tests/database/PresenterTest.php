<?php

/* Tatter/Forms Tests
 * Adapted from CodeIgniter 4 framework tests
 * tests/system/RESTful/ResourcePresenterTest.php
 * tests/system/RESTful/ResourceControllerTest.php
 */
 
use CodeIgniter\Config\Services;
use Config\App;
use Tests\Support\MockCodeIgniter;

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

		$this->assertEquals(lang('RESTful.notImplemented', ['index']), $output);
	}
}
