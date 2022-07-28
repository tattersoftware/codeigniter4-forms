<?php

namespace Tatter\Forms\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\RESTful\ResourcePresenter as BasePresenter;
use Tatter\Forms\Traits\ResourceTrait;

class ResourcePresenter extends BasePresenter
{
    use ResourceTrait;

    protected $helpers = ['form'];

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

        return redirect()->to(site_url($this->names))->with('success', lang('Forms.created', [$this->name]));
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

        return redirect()->to(site_url("{$this->names}/{$id}"))->with('success', lang('Forms.updated', [$this->name]));
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

        return redirect()->to(site_url("{$this->names}"))->with('success', lang('Forms.updated', [$this->name]));
    }

    //--------------------------------------------------------------------
    // Support Methods
    //--------------------------------------------------------------------

    protected function ensureExists($id = null)
    {
        if ($object = $this->model->withDeleted()->find($id)) {
            return $object;
        }

        return redirect()->back()->withInput()->with('errors', [lang('Forms.notFound', [$this->name])]);
    }

    protected function actionFailed(string $action)
    {
        $errors = $this->model->errors() ?: [
            lang("Forms.{$action}Failed", [$this->name]),
        ];

        return redirect()->back()->withInput()->with('errors', $errors);
    }
}
