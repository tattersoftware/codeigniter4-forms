<?php

namespace Tests\Support;

use CodeIgniter\HTTP\Request;
use CodeIgniter\Test\ControllerTestTrait;
use Config\Services;

/**
 * Presenter Trait
 *
 * Mixes together MockRenderer and the
 * ControllerTester to return metadata
 * from presenter endpoints rather than
 * processing their views.
 *
 * @mixin FormsTestCase
 *
 * @property Request $request Remove after https://github.com/codeigniter4/CodeIgniter4/pull/4503
 */
trait PresenterTrait
{
    use ControllerTestTrait;

    /**
     * Initializes routing and config.
     */
    protected function setUpPresenterTrait(): void
    {
        // Mock the renderer
        Services::injectMock('renderer', new MockRenderer(config('View'), config('Paths')->viewDirectory));
    }

    /**
     * Executes a method call and returns
     * its PresenterResponse.
     *
     * @param array $params
     */
    protected function call(string $method, ...$params): PresenterResponse
    {
        return new PresenterResponse($this->execute($method, ...$params));
    }

    /**
     * Sets the headers to trigger the next call
     * as an AJAX method.
     *
     * @return $this
     */
    protected function asAjax(): self
    {
        $this->request->setHeader('X-Requested-With', 'xmlhttprequest');

        return $this;
    }
}
