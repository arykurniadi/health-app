<?php 

namespace App\Repositories\Exceptions;

class RecordFoundException extends \Exception
{
    public $name;
    
    function __construct()
    {
        parent::__construct('Record found.');
        $this->name = get_class($this);        
    }
}