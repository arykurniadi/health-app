<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Presenters\Patient\PatientPresenter;
use App\Utils\Pagination\Pagination as PaginationUtil;
use App\Requests\Patient\ListRequest;
use App\Requests\Patient\CreateRequest;
use App\Repositories\Exceptions\RecordFoundException;
use App\Repositories\Exceptions\RecordNotFoundException;
use App\Utils\MultipartFormData\MultipartFormDataParser;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;

class PatientController extends BaseController
{
	public function index()
	{
        try {
            $request = new ListRequest(
                $this->request->getQuery('search'),
                $this->request->getQuery('page') ?? 1,
                $this->request->getQuery('perPage') ?? 10
            );
    
            $listPatientService = $this->patientService->list($request);
    
            $patients = [];
            foreach($listPatientService['results'] as $item) {
                $presenter = new PatientPresenter($item);
                array_push($patients, $presenter);
            }
    
            $currentPage = $request->getPage(); 
            $perPage = $request->getPerPage();
            $count = $listPatientService['count']; 
            $data = $patients;
            $pagination = new PaginationUtil($currentPage, $perPage, $count, $data);
    
            return $this->json($pagination);                
        } catch(\Exception $e) {
            return $e;
        }
	}

    public function getById($id)
    {
        try {
            $getByIdService = $this->patientService->getById($id);
            $presenter = new PatientPresenter($getByIdService);
            $this->json($presenter);
        } catch(\Exception $e) {
            if($e instanceof RecordNotFoundException) {
                return [
                    'code' => Status::HTTP_BAD_REQUEST,
                    'message' => $e->getMessage()
                ];        
            }
            
            return $e;
        }
    }

    public function create()
    {
        try {
            $request = new CreateRequest($this->request->getPost());
            if(count($request->validate()) > 0) {
                $errors = [];
                foreach($request->validate() as $err) {
                    $errors[$err->getField()] = $err->getMessage();
                }
    
                return [
                    'code' => Status::HTTP_BAD_REQUEST,
                    'message' => 'One of the required field is invalid, please check your input',
                    'data' => [
                        'errorDetail' => $errors
                    ]
                ];                   
            }
    
            $patient = $this->patientService->create($request);    
            $presenter = new PatientPresenter($patient);
            $this->json($presenter, Status::HTTP_CREATED, 'Create data is success');
        } catch(\Exception $e) {
            if($e instanceof RecordFoundException) {
                return [
                    'code' => Status::HTTP_BAD_REQUEST,
                    'message' => 'NIK already been used'
                ];        
            }

            return $e;
        }
    }

    public function update($id)
    {
        try {
            $formData = MultipartFormDataParser::parse();
            $request = new CreateRequest($formData->params);
            if(count($request->validate()) > 0) {
                $errors = [];
                foreach($request->validate() as $err) {
                    $errors[$err->getField()] = $err->getMessage();
                }
    
                return [
                    'code' => Status::HTTP_BAD_REQUEST,
                    'message' => 'One of the required field is invalid, please check your input',
                    'data' => [
                        'errorDetail' => $errors
                    ]                
                ];
            }
    
            $patient = $this->patientService->update($id, $request);
            $presenter = new PatientPresenter($patient);
            $this->json($presenter, Status::HTTP_OK, 'Update is success');
        } catch(\Exception $e) {
            if($e instanceof RecordNotFoundException) {
                return [
                    'code' => Status::HTTP_BAD_REQUEST,
                    'message' => $e->getMessage()
                ];        
            }

            if($e instanceof RecordFoundException) {
                return [
                    'code' => Status::HTTP_BAD_REQUEST,
                    'message' => 'NIK already been used'
                ];
            }
            
            return $e;
        }
    }

    public function delete($id)
    {
        try {
            $deleteService = $this->patientService->delete($id);            
            $this->json(null, Status::HTTP_OK, 'Delete data is success');
        } catch(\Exception $e) {
            if($e instanceof RecordNotFoundException) {
                return [
                    'code' => Status::HTTP_BAD_REQUEST,
                    'message' => $e->getMessage()
                ];        
            }
            
            return $e;
        }
    }
}
