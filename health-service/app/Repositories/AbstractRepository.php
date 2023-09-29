<?php

namespace App\Repositories;

use App\Repositories\AbstractRepositoryInterface;

class AbstractRepository implements AbstractRepositoryInterface
{
    protected $model;
    
    public function getModel()
    {
        return $this->model;
    }
}
