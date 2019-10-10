<?php namespace Tatter\Forms\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use Tatter\Forms\Traits\ResourceTrait;

class ResourceController extends \CodeIgniter\RESTful\ResourceController
{
	use ResourceTrait;

	/************* CRUD METHODS *************/
	
	public function create()
	{
		$data = $this->request->getPost();

		if (! $id = $this->model->insert($data))
		{
			return $this->actionFailed('create', 422);
		}

		return $this->respondCreated(null, lang('Forms.created', [$this->name]));
	}

	public function index()
	{
		return $this->respond($this->model->findAll());
	}
	
	public function show($id = null)
	{
		if (($object = $this->ensureExists($id)) instanceof ResponseInterface)
		{
			return $object;
		}

		return $this->respond([$this->model->find($id)]);
	}
	
	public function update($id = null)
	{
		if (($object = $this->ensureExists($id)) instanceof ResponseInterface)
		{
			return $object;
		}

		$data = $this->request->getPost();

		if (! $this->model->update($id, $data))
		{
			return $this->actionFailed('update', 422);
		}

		return $this->respond(null, 200, lang('Forms.updated', [$this->name]));
	}

	public function delete($id = null)
	{
		if (($object = $this->ensureExists($id)) instanceof ResponseInterface)
		{
			return $object;
		}
		
		if (! $this->model->delete($id))
		{
			return $this->actionFailed('delete');
		}

		return $this->respondDeleted(null, lang('Forms.deleted', [$this->name]));
	}
	
	/************* SUPPORT METHODS *************/
	
	protected function ensureExists($id = null)
	{
		if ($object = $this->model->find($id))
		{
			return $object;
		}
		
		return $this->failNotFound('Not Found', null, lang('Forms.notFound', [$this->name]));
	}

	protected function actionFailed(string $action, int $status = 400)
	{
		$errors = $this->model->errors() ?? [lang("Forms.{$action}Failed", [$this->name])];

		$response = [
			'status'   => $status,
			'error'    => "{$action} Failed",
			'messages' => $this->model->errors(),
		];
		
		return $this->respond($response, $status, $message);
	}
}
