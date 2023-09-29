<?php 

namespace App\Models;

class User extends BaseModel
{
    public $id;
    public $name;
    public $password;
    public $phone;
    public $access_token;
    public $status;

    public function initialize()
    {
        $this->setSource("users");
    }    
}
