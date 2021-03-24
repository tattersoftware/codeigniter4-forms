<?php namespace Tatter\Forms\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\RESTful\ResourcePresenter as BasePresenter;
use Tatter\Forms\Traits\ResourceTrait;

class ResourcePresenter extends BasePresenter
{
	use ResourceTrait;
	
	protected $helpers = ['alerts'];

	/************* CRUD METHODS *************/
	
	public function new()
	{
		helper('form');
		return $this->request->isAJAX() ?
			view("{$this->names}/form") :
			view("{$this->names}/new");
	}
	
	public function create()
	{
		$data = $this->request->getPost();
		
		if (! $id = $this->model->insert($data))
		{
			return $this->actionFailed('create');
		}

		$this->alert('success', lang('Forms.created', [$this->name]));
		
		return redirect()->to($this->names);
	}

	public function index()
	{
		$data = [$this->names => $this->model->findAll()];
		return view("{$this->names}/index", $data);
	}
	
	public function show($id = null)
	{
		if (($object = $this->ensureExists($id)) instanceof RedirectResponse)
		{
			return $object;
		}

		$data = [$this->name => $object];

		return view("{$this->names}/show", $data);
	}
	
	public function edit($id = null)
	{
		if (($object = $this->ensureExists($id)) instanceof RedirectResponse)
		{
			return $object;
		}
		
		$data = [$this->name => $object];
		
		helper('form');
		return $this->request->isAJAX() ?
			view("{$this->names}/form", $data) :
			view("{$this->names}/edit", $data);
	}
	
	public function update($id = null)
	{
		if (($object = $this->ensureExists($id)) instanceof RedirectResponse)
		{
			return $object;
		}
		
		$data = $this->request->getPost();

		if (! $this->model->update($id, $data))
		{
			return $this->actionFailed('update');
		}
		
		$this->alert('success', lang('Forms.updated', [$this->name]));
		
		return redirect()->to("{$this->names}/{$id}");
	}
	
	public function remove($id = null)
	{
		if (($object = $this->ensureExists($id)) instanceof RedirectResponse)
		{
			return $object;
		}
		
		$data = [$this->name => $object];
		
		helper('form');
		return $this->request->isAJAX() ?
			view("{$this->names}/confirm", $data) :
			view("{$this->names}/remove", $data);
	}
	
	public function delete($id = null)
	{
		if (($object = $this->ensureExists($id)) instanceof RedirectResponse)
		{
			return $object;
		}
		
		if (! $this->model->delete($id))
		{
			return $this->actionFailed('delete');			
		}
	}
	
	/************* SUPPORT METHODS *************/
	
	protected function ensureExists($id = null)
	{
		if ($object = $this->model->find($id))
		{
			return $object;
		}
		
		$error = lang('Forms.notFound', [$this->name]);

		$this->alert('danger', $error);

		return redirect()->back()->withInput()->with('errors', [$error]);
	}

	protected function actionFailed(string $action)
	{
		$errors = $this->model->errors() ?? [lang("Forms.{$action}Failed", [$this->name])];

		foreach ($errors as $error)
		{
			$this->alert('warning', $error);
		}
		
		return redirect()->back()->withInput()->with('errors', $errors);
	}
	
	protected function alert($status, $message)
	{
		if ($alerts = service('alerts'))
		{
			$alerts->add($status, $message);
		}
	}
}
