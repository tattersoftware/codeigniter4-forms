<?php

use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Controllers\Factories;
use Tests\Support\FormsTestCase;
use Tests\Support\Models\FactoryModel;
use Tests\Support\PresenterTrait;

/**
 * ResourcePresenter Write Test Class
 *
 * Tests that affect the database
 * so must be reset between methods.
 *
 * @internal
 */
final class PresenterWriteTest extends FormsTestCase
{
    use DatabaseTestTrait;
    use PresenterTrait;

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
        $result->assertRedirectTo('factories');

        // Get the last Factory to confirm the response
        model(FactoryModel::class)->findAll();

        $expected = [
            [
                'class' => 'success',
                'text'  => 'New factory created successfully.',
            ],
        ];

        $result->assertSessionHas('alerts-queue', $expected);
    }

    public function testUpdate()
    {
        $factory = model(FactoryModel::class)->first();

        $_POST = ['name' => 'Banana Factory'];

        $result = $this->execute('update', $factory->id);
        $result->assertOK();
        $result->assertRedirectTo('factories/' . $factory->id);

        $factory = model(FactoryModel::class)->find($factory->id);
        $this->assertSame('Banana Factory', $factory->name);
    }

    public function testDelete()
    {
        $factory = model(FactoryModel::class)->first();

        $result = $this->execute('delete', $factory->id);

        $result->assertOK();
        $result->assertRedirectTo('factories');

        $factory = model(FactoryModel::class)->find($factory->id);
        $this->assertNull($factory);
    }
}
