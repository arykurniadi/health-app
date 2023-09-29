<?php

namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\AbstractRepository;
use App\Models\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function list()
    {     
        $users = $this->model->find();
        return $users;
    }
}
