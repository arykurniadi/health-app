<?php 

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;

class BaseController extends Controller
{
	public function view($view, array $params = [], $code = 200)
	{
		$content = $this->view->render($view, $params);

		$this->response->setStatusCode($code, null);
		$this->response->setContent($content);
	}

	public function json($data = null, $code = Status::HTTP_OK, $message = '')
	{
		$data = [
            'status' => [
                'code' => $code,
                'response' => $this->mapResponseStatus($code),
                'message' => $message,
            ],
            'result' => $data,
        ];

        $this->response->setJsonContent($data);
		$this->response->setStatusCode($code, null);
        $this->response->send();
	}

	public function response($data = '', $code = 200, $type = null)
	{
		$this->response->setStatusCode($code, $type);
		$this->response->setContent($data);
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
