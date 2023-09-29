<?php

namespace App\Presenters\User;

use App\Presenters\AbstractPresenter;
use App\Models\User;

class UserPresenter extends AbstractPresenter
{
    public $id;
    public $name;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
    }
}
