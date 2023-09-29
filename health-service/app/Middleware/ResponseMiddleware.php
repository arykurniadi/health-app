<?php

namespace App\Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;

class ResponseMiddleware implements MiddlewareInterface
{
    public function call(Micro $application)
    {
        $returnedValue = $application->getReturnedValue();    
        
        $statusCode = $returnedValue['code'] ?? Status::HTTP_OK;
        $statusContext = $this->mapResponseStatus($statusCode);

        $responseBase = [
            'status' => [
                'code' => $statusCode,
                'response' => $returnedValue['statusContext'] ?? $statusContext,
                'message' => $returnedValue['message'] ?? '',
            ],
            'result' => isset($returnedValue['data']) ? $returnedValue['data'] : null,
        ];

        $application->response->setStatusCode($statusCode, null);
        $application->response->setJsonContent($responseBase);
        $application->response->send();

        return true;
    }

    private function mapResponseStatus($code) 
    {   
        if ($code >= Status::HTTP_OK && $code < Status::HTTP_MULTIPLE_CHOICES) {
            return "success";
        } elseif ($code >= Status::HTTP_BAD_REQUEST && $code < Status::HTTP_INTERNAL_SERVER_ERROR) {
            return "error";
        } else {
            return "failure";
        }        
    }
}