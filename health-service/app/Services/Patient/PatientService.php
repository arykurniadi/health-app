<?php

namespace App\Services\Patient;

use App\Requests\Patient\ListRequest;
use App\Requests\Patient\CreateRequest;

class PatientService
{
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function list(ListRequest $request)
    {
        $repository = $this->repository->list($request);
        return $repository;        
    }

    public function getById($id)
    {
        $repository = $this->repository->getById($id);
        return $repository;
    }

    public function create(CreateRequest $request)
    {
        $repository = $this->repository->create($request);
        return $repository;        
    }

    public function update(String $id, CreateRequest $request)
    {
        $repository = $this->repository->update($id, $request);
        return $repository;        
    }

    public function delete(String $id)
    {
        return $this->repository->delete($id);
    }
}
