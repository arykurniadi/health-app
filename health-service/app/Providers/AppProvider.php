<?php

namespace App\Providers;

use Phalcon\DI\FactoryDefault;
use App\Providers\AbstractAppProvider;
use App\Repositories\User\UserRepository;
use App\Repositories\Patient\PatientRepository;
use App\Services\User\UserService;
use App\Services\Patient\PatientService;
use App\Models\User as UserModel;

class AppProvider extends AbstractAppProvider
{
    protected $di;
    
    public function __construct(FactoryDefault $di)
    {
        $this->di = $di;
    }
    
    public function repositories() 
    {
        $this->bindRepository('userRepository', UserRepository::class, [new UserModel]);
        $this->bindRepository('patientRepository', PatientRepository::class);
    }

    public function services() 
    {        
        $this->bindService('userService', UserService::class, [$this->getDi()->get('userRepository')]);
        $this->bindService('patientService', PatientService::class, [$this->getDi()->get('patientRepository')]);
    }
}