<?php namespace Tatter\Forms\Config;

use CodeIgniter\Config\BaseConfig;

class Forms extends BaseConfig
{
	// Whether to continue instead of throwing exceptions
	public $silent = true;

	// URL base for Resource controllers
	public $apiUrl = site_url('api/');
}
