<?php

namespace App\Providers;

use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

abstract class AbstractAppProvider implements InjectionAwareInterface
{
    protected $di;

    public function setDi(DiInterface $di)
    {
        $this->di = $di;
    }

    public function getDi()
    {
        return $this->di;
    }

    public function bind($name, $class)
    {
        $this->getDi()->set($name, $class);
    }

    public function bindRepository($name, $repository, array $params = [])
    {
        $this->bind($name, function() use($repository, $params) {
            return new $repository(...$params);
        });
    }

    public function bindService($name, $service, array $params = [])
    {
        $this->bind($name, function() use($service, $params) {
            return new $service(...$params);
        });
    }

    public function registerServices()
    {
        $this->repositories();
        $this->services();
    }

    public function repositories() 
    {
        
    }

    public function services() 
    {
        
    }
}