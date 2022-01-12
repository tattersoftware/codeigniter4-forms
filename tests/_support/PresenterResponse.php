<?php

namespace Tests\Support;

use CodeIgniter\Test\TestResponse;
use RuntimeException;
use Throwable;

/**
 * Presenter Response Class
 *
 * Extracts metadata from a MockRenderer
 * response to represent a comprehensive,
 * accessible result.
 */
class PresenterResponse
{
    /**
     * @var TestResponse
     */
    public $response;

    /**
     * The View file that would have been called.
     *
     * @var string
     */
    public $view;

    /**
     * Any data which would have been passed to the View.
     *
     * @var array
     */
    public $data;

    /**
     * Extracts the body and saves results.
     */
    public function __construct(TestResponse $response)
    {
        if (! $body = $response->response()->getBody()) {
            throw new RuntimeException('Empty body from ' . $response->request()->uri);
        }

        try {
            $result = unserialize($body);
        } catch (Throwable $e) {
            throw new RuntimeException('Invalid response ' . $body, $e->getCode(), $e);
        }

        if (! is_array($result)) {
            throw new RuntimeException('Indecipherable response ' . $body);
        }

        $this->response = $response;
        $this->view     = $result['view'];
        $this->data     = $result['data'];
    }
}
