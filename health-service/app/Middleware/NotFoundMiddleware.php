<?php

namespace App\Middleware;

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class NotFoundMiddleware implements MiddlewareInterface
{
    public function beforeNotFound(Event $event, Micro $application)
    {
        $returnedValue = $application->getReturnedValue();

        $data = [
            'code'    => 404,
            'status'  => 'not_found',
            'message' => 'Not Found',
            'data' => null,
        ];

        $application->response->setJsonContent($data);
        $application->response->send();

        return false;
    }

    public function call(Micro $application)
    {
        return true;
    }
}