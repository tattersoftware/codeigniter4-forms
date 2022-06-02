<?php

namespace Tests\Support;

use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\Mock\MockCodeIgniter;
use Config\Services;
use Tatter\Forms\Config\Forms as FormsConfig;
use Tests\Support\Database\Seeds\IndustrialSeeder;
use Tests\Support\Models\FactoryModel;

abstract class FormsTestCase extends CIUnitTestCase
{
    /**
     * The namespace to help us find the migration classes.
     *
     * @var string
     */
    protected $namespace = 'Tests\Support';

    /**
     * The name of a seed file used for all tests within this test case.
     *
     * @var string
     */
    protected $seed = IndustrialSeeder::class;

    /**
     * @var RouteCollection
     */
    protected $routes;

    protected FormsConfig $config;
    protected FactoryModel $model;
    protected MockCodeIgniter $codeigniter;

    /**
     * Initializes required helpers.
     *
     * @see app/Config/Events.php "post_controller_constructor"
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        helper(['inflector']);
    }

    /**
     * Initializes routing and config.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';

        // Set up Routes
        $routes = Services::routes();

        $routes->presenter('factories', ['controller' => 'Tests\Support\Controllers\Factories']);
        $routes->resource('api/factories', ['controller' => 'Tests\Support\Controllers\API\Factories']);

        Services::injectMock('routes', $routes);
        $this->routes = $routes;

        // Load the test classes
        $this->config      = config('Forms');
        $this->model       = new FactoryModel();
        $this->codeigniter = new MockCodeIgniter(config('App'));
    }
}
