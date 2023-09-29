<?php

namespace App\Services\User;

class UserService
{
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        $userRepository = $this->repository->list();
        return $userRepository;
    }
}
