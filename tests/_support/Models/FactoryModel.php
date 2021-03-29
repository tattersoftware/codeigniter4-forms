<?php namespace Tests\Support\Models;

use CodeIgniter\Model;

class FactoryModel extends Model
{
	protected $table      = 'factories';
	protected $primaryKey = 'id';
	protected $returnType = 'object';

	protected $useTimestamps  = true;
	protected $useSoftDeletes = false;
	protected $skipValidation = false;

	protected $allowedFields   = ['name', 'uid', 'class', 'icon', 'summary'];
	protected $validationRules = [
		'name' => 'required|max_length[31]',
		'uid'  => 'required|max_length[31]',
	];
}
