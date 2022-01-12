<?php

namespace Tatter\Forms\Traits;

use CodeIgniter\Model;
use Tatter\Forms\Exceptions\FormsException;

/**
 * @property Model $model
 * @mixin Tatter\Forms\Controllers\ResourcePresenter, Tatter\Forms\Controllers\ResourceController
 */
trait ResourceTrait
{
	// Convenience singular & plural names for entity variables
	protected $name;
	protected $names;

	// Extend the framework setModel to require a valid model and set names
	public function setModel($which = null)
	{
		parent::setModel($which);

		// Ensure we received a valid model
		if (! $this->model instanceof Model)
		{
			throw FormsException::forMissingModel(static::class);
		}

		// Set singular and plural names
		helper('inflector');

		// Check for overriding model property
		if (! empty($this->model->name))
		{
			$name = $this->model->name;
		}

		// Use the model class name
		// e.g. \App\Models\PhotoModel = photo(s)
		else {
			$name = strtolower($this->modelName);

			// Remove namespaces
			if ($offset = strrpos($name, '\\'))
			{
				 $name = substr($name, $offset + 1);
			}

			// Remove the word "model"
			$name = str_replace('model', '', $name);
		}

		$this->name  = singular($name);
		$this->names = plural($name);
	}
}
