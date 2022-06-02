<?php

namespace Tatter\Forms\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\RESTful\ResourcePresenter as BasePresenter;
use Tatter\Forms\Traits\ResourceTrait;

class ResourcePresenter extends BasePresenter
{
    use ResourceTrait;

    protected $helpers = ['alerts', 'form'];

    //--------------------------------------------------------------------
    // CRUD Methods
    //--------------------------------------------------------------------

    public function new()
    {
        return view($this->request->isAJAX() ? "{$this->names}/form" : "{$this->names}/new");
    }

    public function create()
    {
        $data = $this->request->getPost();

        if (! $id = $this->model->insert($data)) {
            return $this->actionFailed('create');
        }

        $this->alert('success', lang('Forms.created', [$this->name]));

        return redirect()->to(site_url($this->names));
    }

    public function index()
    {
        return view("{$this->names}/index", [
            $this->names => $this->model->findAll(),
        ]);
    }

    public function show($id = null)
    {
        if (($object = $this->ensureExists($id)) instanceof RedirectResponse) {
            return $object;
        }

        return view("{$this->names}/show", [$this->name => $object]);
    }

    public function edit($id = null)
    {
        if (($object = $this->ensureExists($id)) instanceof RedirectResponse) {
            return $object;
        }

        return view($this->request->isAJAX() ? "{$this->names}/form" : "{$this->names}/edit", [
            $this->name => $object,
        ]);
    }

    public function update($id = null)
    {
        if (($object = $this->ensureExists($id)) instanceof RedirectResponse) {
            return $object;
        }

        $data = $this->request->getPost();

        if (! $this->model->update($id, $data)) {
            return $this->actionFailed('update');
        }

        $this->alert('success', lang('Forms.updated', [$this->name]));

        return redirect()->to(site_url("{$this->names}/{$id}"));
    }

    public function remove($id = null)
    {
        if (($object = $this->ensureExists($id)) instanceof RedirectResponse) {
            return $object;
        }

        return view($this->request->isAJAX() ? "{$this->names}/confirm" : "{$this->names}/remove", [
            $this->name => $object,
        ]);
    }

    public function delete($id = null)
    {
        if (($object = $this->ensureExists($id)) instanceof RedirectResponse) {
            return $object;
        }

        if (! $this->model->delete($id)) {
            return $this->actionFailed('delete');
        }

        $this->alert('success', lang('Forms.deleted', [$this->name]));

        return redirect()->to(site_url("{$this->names}"));
    }

    //--------------------------------------------------------------------
    // Support Methods
    //--------------------------------------------------------------------

    protected function ensureExists($id = null)
    {
        if ($object = $this->model->find($id)) {
            return $object;
        }

        $error = lang('Forms.notFound', [$this->name]);

        $this->alert('danger', $error);

        return redirect()->back()->withInput()->with('errors', [$error]);
    }

    protected function actionFailed(string $action)
    {
        $errors = $this->model->errors() ?: [
            lang("Forms.{$action}Failed", [$this->name]),
        ];

        foreach ($errors as $error) {
            $this->alert('warning', $error);
        }

        return redirect()->back()->withInput()->with('errors', $errors);
    }

    protected function alert($status, $message)
    {
        if ($alerts = service('alerts')) {
            $alerts->add($status, $message);
        }
    }
}
