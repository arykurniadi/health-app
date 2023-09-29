<?php

namespace App\Middleware;

use Phalcon\Di;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class ApiKeyMiddleware implements MiddlewareInterface
{
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        $this->application = $application;
        $config = Di::getDefault()->get('config');

        if(dirname($this->application->request->getURI()) == '/internal') {
            if($this->application->request->getHeader('X-Api-Key') !== $config->auth->apiKey) {
                $this->unauthorized();
                die;                
            }
        }

        return true;
    }

    public function unauthorized() {
        $this->application->response->setJsonContent([
            'code'    => 401,
            'status' => 'unauthorized',
            'message' => 'Unauthorized',
            'data' => ''
        ]);
        $this->application->response->send();
    }

    public function call(Micro $application)
    {
        return true;
    }
}