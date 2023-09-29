<?php 

namespace App\Repositories\Exceptions;

class RecordNotFoundException extends \Exception
{
    public $name;
    
    function __construct()
    {
        parent::__construct('Record not found.');
        $this->name = get_class($this);        
    }
}