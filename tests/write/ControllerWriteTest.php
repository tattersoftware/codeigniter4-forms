<?php

use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Controllers\API\Factories;
use Tests\Support\FormsTestCase;
use Tests\Support\Models\FactoryModel;

/**
 * ResourceController Write Test Class
 *
 * Tests that affect the database
 * so must be reset between methods.
 *
 * @internal
 */
final class ControllerWriteTest extends FormsTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    /**
     * Sets up the Controller for testing.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->controller(Factories::class);
    }

    public function testCreate()
    {
        $_POST = [
            'name'    => 'Rainbow Factory',
            'uid'     => 'bow',
            'class'   => 'ModuleTests\Rainbows\Factory',
            'icon'    => '',
            'summary' => '',
        ];

        $result = $this->execute('create');

        $result->assertOK();
        $result->assertStatus(201);
        $this->assertSame('New Factory created successfully.', $result->response()->getReasonPhrase());

        // Get the last Factory to confirm the response
        $factories = model(FactoryModel::class)->findAll();
        $factory   = end($factories);

        $this->assertEquals($factory, json_decode($result->response()->getBody()));
    }

    public function testUpdate()
    {
        $factory = model(FactoryModel::class)->first();

        $_POST = ['name' => 'Banana Factory'];

        $result = $this->execute('update', $factory->id);

        $result->assertOK();
        $result->assertStatus(200);
        $this->assertSame('Factory updated successfully.', $result->response()->getReasonPhrase());

        $factory = model(FactoryModel::class)->find($factory->id);
        $this->assertEquals($factory, json_decode($result->response()->getBody()));
    }

    public function testDelete()
    {
        $factory = model(FactoryModel::class)->first();

        $result = $this->execute('delete', $factory->id);

        $result->assertOK();
        $result->assertStatus(200);
        $this->assertSame('Factory deleted successfully.', $result->response()->getReasonPhrase());

        $factory = model(FactoryModel::class)->find($factory->id);
        $this->assertNull($factory);
    }
}
