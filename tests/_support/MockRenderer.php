<?php namespace ModuleTests\Support;

class MockRenderer extends \CodeIgniter\View\View
{
	// Sends back $data and $view
	// Serializes return to be compatible with RendererInterface
	public function render(string $view, array $options = null, bool $saveData = null): string
	{
		return serialize(['view' => $view, 'data' => $this->data]);
	}
}
