<?php 

namespace App\Models;

class Patient extends BaseModel
{
    public $id;
    public $nik;
    public $name;
    public $sex;
    public $religion;
    public $phone;
    public $address;

    public function initialize()
    {        
    }    

    public function getSource()
    {
        return 'patients';
    }    
}
