<?php

use CodeIgniter\Controller;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Controllers\API\Factories;
use Tests\Support\FormsTestCase;
use Tests\Support\Models\FactoryModel;

/**
 * ResourceController Read Test Class
 *
 * Tests that do not change the database
 * so can afford the optimization of
 * setting up the database once.
 *
 * @property Factories $controller
 *
 * @internal
 */
final class ControllerReadTest extends FormsTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

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

    public function testIndex()
    {
        $result = $this->execute('index');

        $result->assertOK();
        $result->assertJSONExact($this->model->findAll());
    }

    public function testShow()
    {
        $result = $this->execute('show', 1);

        $result->assertOK();
        $result->assertJSONExact((array) $this->model->find(1));
    }

    public function testShowNull()
    {
        $result = $this->execute('show');

        $result->assertNotOK();
        $result->assertStatus(404);
    }

    public function testShowNonexistant()
    {
        $result = $this->execute('show', 42);

        $result->assertNotOK();
        $result->assertStatus(404);
    }

    public function testCreateFailed()
    {
        // Missing "name"
        $_POST = [
            'uid'     => 'bow',
            'class'   => 'ModuleTests\Rainbows\Factory',
            'icon'    => '',
            'summary' => '',
        ];

        $result = $this->execute('create');

        $result->assertNotOK();
        $result->assertStatus(422);

        $body = json_decode($result->response()->getBody());

        $this->assertSame('Create Failed', $body->error);
        $this->assertSame(['name' => 'The name field is required.'], (array) $body->messages);
    }

    public function testUpdateNull()
    {
        $result = $this->execute('update');

        $result->assertNotOK();
        $result->assertStatus(404);
    }

    public function testUpdateNonexistant()
    {
        $result = $this->execute('update', 42);

        $result->assertNotOK();
        $result->assertStatus(404);
    }

    public function testUpdateFailed()
    {
        $factory = model(FactoryModel::class)->first();

        $_POST = ['name' => 'This name exceeds the limit of 31 characters'];

        $result = $this->execute('update', $factory->id);

        $result->assertNotOK();
        $result->assertStatus(422);

        $body = json_decode($result->response()->getBody());

        $this->assertSame('Update Failed', $body->error);
        $this->assertSame(['name' => 'The name field cannot exceed 31 characters in length.'], (array) $body->messages);
    }

    public function testDeleteNull()
    {
        $result = $this->execute('delete');

        $result->assertNotOK();
        $result->assertStatus(404);
    }

    public function testDeleteNonexistant()
    {
        $result = $this->execute('delete', 42);

        $result->assertNotOK();
        $result->assertStatus(404);
    }

    public function testDeleteFailed()
    {
        // Mock the Model so all deletes fail
        $model = new class () extends FactoryModel {
            protected function doDelete($id = null, bool $purge = false)
            {
                return false;
            }
        };
        $this->controller->setModel($model);

        $factory = model(FactoryModel::class)->first();
        $result  = $this->execute('delete', $factory->id);

        $result->assertNotOK();
        $result->assertStatus(400);

        $body = json_decode($result->response()->getBody());

        $this->assertSame('Delete Failed', $body->error);
    }
}
