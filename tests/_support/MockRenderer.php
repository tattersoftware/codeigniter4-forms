<?php

namespace Tests\Support;

use CodeIgniter\View\View;

class MockRenderer extends View
{
    /**
     * Sends back $data and $view serialized.
     */
    public function render(string $view, ?array $options = null, ?bool $saveData = null): string
    {
        return serialize(['view' => $view, 'data' => $this->tempData]);
    }
}
