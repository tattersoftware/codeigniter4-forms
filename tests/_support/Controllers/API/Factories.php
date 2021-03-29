<?php namespace Tests\Support\Controllers\API;

use Tatter\Forms\Controllers\ResourceController;
use Tests\Support\Models\FactoryModel;

class Factories extends ResourceController
{
	protected $modelName = FactoryModel::class;
}
