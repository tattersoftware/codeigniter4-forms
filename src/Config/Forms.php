<?php

namespace Tatter\Forms\Config;

use CodeIgniter\Config\BaseConfig;

class Forms extends BaseConfig
{
	/**
	 * Whether to continue instead of throwing exceptions
	 *
	 * @var bool
	 */
	public $silent = true;

	/**
	 * URL base for Resource controllers
	 *
	 * @var string
	 */
	public $apiUrl = 'api/';
}
