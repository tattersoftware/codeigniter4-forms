<?php

use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Controllers\Factories;
use Tests\Support\FormsTestCase;
use Tests\Support\PresenterTrait;
use Tests\Support\Models\FactoryModel;

/**
 * ResourcePresenter Read Test Class
 *
 * Tests that do not change the database
 * so can afford the optimization of
 * setting up the database once.
 */
class PresenterReadTest extends FormsTestCase
{
	use DatabaseTestTrait, PresenterTrait;

	protected $migrateOnce = true;
	protected $seedOnce    = true;

	/**
	 * Sets up the Controller for testing.
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$this->controller(Factories::class);
	}

	public function testNew()
	{
		$result = $this->call('new');
		$result->response->assertOK();

		$this->assertEquals('factories/new', $result->view);
	}

	public function testNewAjax()
	{
		$result = $this->asAjax()->call('new');
		$result->response->assertOK();

		$this->assertEquals('factories/form', $result->view);
	}

	public function testIndex()
	{
		$data = [
			'factories' => model(FactoryModel::class)->findAll(),
		];

		$result = $this->call('index');
		$result->response->assertOK();

		$this->assertEquals('factories/index', $result->view);
		$this->assertEquals($data, $result->data);
	}

	public function testShow()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->call('show', $factory->id);
		$result->response->assertOK();

		$this->assertEquals('factories/show', $result->view);
		$this->assertEquals(['factory' => $factory], $result->data);
	}

	public function testEdit()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->call('edit', $factory->id);
		$result->response->assertOK();

		$this->assertEquals('factories/edit', $result->view);
		$this->assertEquals(['factory' => $factory], $result->data);
	}

	public function testEditAjax()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->asAjax()->call('edit', $factory->id);
		$result->response->assertOK();

		$this->assertEquals('factories/form', $result->view);
		$this->assertEquals(['factory' => $factory], $result->data);
	}

	public function testRemove()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->call('remove', $factory->id);
		$result->response->assertOK();

		$this->assertEquals('factories/remove', $result->view);
		$this->assertEquals(['factory' => $factory], $result->data);
	}

	public function testRemoveAjax()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->asAjax()->call('remove', $factory->id);
		$result->response->assertOK();

		$this->assertEquals('factories/confirm', $result->view);
		$this->assertEquals(['factory' => $factory], $result->data);
	}
}
