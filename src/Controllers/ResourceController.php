<?php

namespace Tatter\Forms\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController as BaseController;
use Tatter\Forms\Traits\ResourceTrait;

class ResourceController extends BaseController
{
    use ResourceTrait;

    //--------------------------------------------------------------------
    // CRUD Methods
    //--------------------------------------------------------------------

    public function create()
    {
        $data = $this->request->getPost();

        if (! $id = $this->model->insert($data)) {
            return $this->actionFailed('create', 422);
        }

        return $this->respondCreated($this->model->find($id), lang('Forms.created', [ucfirst($this->name)]));
    }

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        if (($object = $this->ensureExists($id)) instanceof ResponseInterface) {
            return $object;
        }

        return $this->respond($object);
    }

    public function update($id = null)
    {
        if (($object = $this->ensureExists($id)) instanceof ResponseInterface) {
            return $object;
        }

        $data = $this->request->getPost();

        if (! $this->model->update($id, $data)) {
            return $this->actionFailed('update', 422);
        }

        return $this->respond($this->model->find($id), 200, lang('Forms.updated', [ucfirst($this->name)]));
    }

    public function delete($id = null)
    {
        if (($object = $this->ensureExists($id)) instanceof ResponseInterface) {
            return $object;
        }

        if (! $this->model->delete($id)) {
            return $this->actionFailed('delete');
        }

        return $this->respondDeleted($object, lang('Forms.deleted', [ucfirst($this->name)]));
    }

    //--------------------------------------------------------------------
    // Support Methods
    //--------------------------------------------------------------------

    /**
     * Fetches an object or returns a failure Response.
     *
     * @param int|string|null $id
     *
     * @return mixed
     */
    protected function ensureExists($id = null)
    {
        if (isset($id) && $object = $this->model->find($id)) {
            return $object;
        }

        return $this->failNotFound('Not Found', null, lang('Forms.notFound', [ucfirst($this->name)]));
    }

    /**
     * Creates a standardized failure Response.
     *
     * @return ResponseInterface
     */
    protected function actionFailed(string $action, int $status = 400)
    {
        $errors = $this->model->errors() ?: [lang("Forms.{$action}Failed", [ucfirst($this->name)])];

        $response = [
            'status'   => $status,
            'error'    => ucfirst($action) . ' Failed',
            'messages' => $this->model->errors(),
        ];

        return $this->respond($response, $status);
    }
}
