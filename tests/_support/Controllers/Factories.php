<?php

namespace Tests\Support\Controllers;

use Tatter\Forms\Controllers\ResourcePresenter;
use Tests\Support\Models\FactoryModel;

class Factories extends ResourcePresenter
{
	protected $modelName = FactoryModel::class;
}
