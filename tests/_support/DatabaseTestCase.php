<?php namespace ModuleTests\Support;
 
use CodeIgniter\Config\Services;
use Config\App;
use Tests\Support\MockCodeIgniter;

class DatabaseTestCase extends \CodeIgniter\Test\CIDatabaseTestCase
{
    /**
     * Should the database be refreshed before each test?
     *
     * @var boolean
     */
    protected $refresh = true;

    /**
     * The name of a seed file used for all tests within this test case.
     *
     * @var string
     */
    protected $seed = 'ModuleTests\Support\Database\Seeds\IndustrialSeeder';

    /**
     * The path to where we can find the test Seeds directory.
     *
     * @var string
     */
    protected $basePath = SUPPORTPATH . 'Database/';

    /**
     * The namespace to help us find the migration classes.
     *
     * @var string
     */
    protected $namespace = 'ModuleTests\Support';
    
	/**
	 * @var \CodeIgniter\CodeIgniter
	 */
	protected $codeigniter;

	/**
	 *
	 * @var \CodeIgniter\Router\RoutesCollection
	 */
	protected $routes;

	/**
	 *
	 * @var \Tatter\Forms\Config\Forms
	 */
	protected $config;

	protected function setUp(): void
	{
		parent::setUp();

		// Load the helpers (mocked codeignter can't find it)
		helper(['alerts', 'inflector']);
		
		Services::reset();

		$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';

		// Inject mock router
		$this->routes = Services::routes();
		
		$this->routes->presenter('factories', ['controller' => 'ModuleTests\Support\Controllers\Factories']);
		$this->routes->resource('api/factories', ['controller' => 'ModuleTests\Support\Controllers\API\Factories']);
		
		Services::injectMock('routes', $this->routes);

		// Inject mock router
		$view = Services::renderer(MODULESUPPORTPATH . 'Views');
		Services::injectMock('renderer', $view);
		
		$config            = new App();
		$this->codeigniter = new MockCodeIgniter($config);
		
		$this->config = new \Tatter\Forms\Config\Forms();
		$this->model  = new \ModuleTests\Support\Models\FactoryModel();
	}

	public function tearDown(): void
	{
		parent::tearDown();

		if (count(ob_list_handlers()) > 1)
		{
			ob_end_clean();
		}
	}
}
