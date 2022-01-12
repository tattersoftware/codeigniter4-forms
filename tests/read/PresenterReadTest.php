<?php

use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Controllers\Factories;
use Tests\Support\FormsTestCase;
use Tests\Support\Models\FactoryModel;
use Tests\Support\PresenterTrait;

/**
 * ResourcePresenter Read Test Class
 *
 * Tests that do not change the database
 * so can afford the optimization of
 * setting up the database once.
 *
 * @internal
 */
final class PresenterReadTest extends FormsTestCase
{
	use DatabaseTestTrait;
	use PresenterTrait;

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

		$this->assertSame('factories/new', $result->view);
	}

	public function testNewAjax()
	{
		$result = $this->asAjax()->call('new');
		$result->response->assertOK();

		$this->assertSame('factories/form', $result->view);
	}

	public function testIndex()
	{
		$data = [
			'factories' => model(FactoryModel::class)->findAll(),
		];

		$result = $this->call('index');
		$result->response->assertOK();

		$this->assertSame('factories/index', $result->view);
		$this->assertSame($data, $result->data);
	}

	public function testShow()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->call('show', $factory->id);
		$result->response->assertOK();

		$this->assertSame('factories/show', $result->view);
		$this->assertSame(['factory' => $factory], $result->data);
	}

	public function testEdit()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->call('edit', $factory->id);
		$result->response->assertOK();

		$this->assertSame('factories/edit', $result->view);
		$this->assertSame(['factory' => $factory], $result->data);
	}

	public function testEditAjax()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->asAjax()->call('edit', $factory->id);
		$result->response->assertOK();

		$this->assertSame('factories/form', $result->view);
		$this->assertSame(['factory' => $factory], $result->data);
	}

	public function testRemove()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->call('remove', $factory->id);
		$result->response->assertOK();

		$this->assertSame('factories/remove', $result->view);
		$this->assertSame(['factory' => $factory], $result->data);
	}

	public function testRemoveAjax()
	{
		$factory = model(FactoryModel::class)->first();

		$result = $this->asAjax()->call('remove', $factory->id);
		$result->response->assertOK();

		$this->assertSame('factories/confirm', $result->view);
		$this->assertSame(['factory' => $factory], $result->data);
	}
}
