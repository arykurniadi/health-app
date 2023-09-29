<?php

namespace App\Repositories\Patient;

use App\Repositories\AbstractRepository;
use Phalcon\Mvc\Model\Query\Builder;
use App\Requests\Patient\ListRequest;
use App\Requests\Patient\CreateRequest;
use App\Repositories\Exceptions\RecordNotFoundException;
use App\Repositories\Exceptions\RecordFoundException;

class PatientRepository extends AbstractRepository
{
    public function list(ListRequest $request)
    {     
        $offset = ($request->getPage() - 1) * $request->getPerPage();

        $query = new Builder();       
        $queryCount = new Builder();             

        $query = $query->from('App\Models\Patient');
        $queryCount = $queryCount->from('App\Models\Patient');
        if($request->getSearch()) {
            $query = $query->where("name LIKE :search:", ['search' => '%'.$request->getSearch().'%']);
            $queryCount = $queryCount->where("name LIKE :search:", ['search' => '%'.$request->getSearch().'%']);
        }
         
        $results = $query->limit($request->getPerPage(), $offset)->getQuery()->execute(); 
        $count = $queryCount->columns('COUNT(*) as count')->getQuery()->getSingleResult();
        
        return [
            'count' => $count['count'],
            'results' => $results,
        ];
    }

    public function getById($id) 
    {   
        $query = new Builder();
        $query = $query->from('App\Models\Patient')->where("id = :id:", ['id' => $id])->getQuery()->getSingleResult();
        if(!$query) {
            throw new RecordNotFoundException();
        }

        return $query;
    }

    public function create(CreateRequest $request)
    {
        try {
            $patient = \App\Models\Patient::findFirst([
                'conditions' => 'nik = :nik:',
                'bind' => [
                    'nik' => $request->getNik(),
                ],            
            ]);
            if($patient) {
                throw new RecordFoundException();
            }
    
            $patient = new \App\Models\Patient();
            $patient->nik = $request->getNik();
            $patient->name = $request->getName();
            $patient->sex = $request->getSex();
            $patient->religion = $request->getReligion();
            $patient->phone = $request->getPhone();
            $patient->address = $request->getAddress();            
            $patient->save();    

            return $patient;
        } catch(\Exception $e) {
            throw $e;
        }        
    }

    public function update(String $id, CreateRequest $request)
    {
        try {
            $patient = \App\Models\Patient::findFirst([
                'conditions' => 'id <> :id: AND nik = :nik:',
                'bind' => [
                    'id' => $id,
                    'nik' => $request->getNik(),
                ],            
            ]);
            if($patient) {
                throw new RecordFoundException();
            }            

            $patient = \App\Models\Patient::findFirst($id);
            if(!$patient) {
                throw new RecordNotFoundException();
            }

            $patient->nik = $request->getNik();
            $patient->name = $request->getName();
            $patient->sex = $request->getSex();
            $patient->religion = $request->getReligion();
            $patient->phone = $request->getPhone();
            $patient->address = $request->getAddress();
            $patient->save();   

            return $patient;
        } catch(\Exception $e) {
            throw($e);
        }
    }

    public function delete(String $id)
    {
        $patient = \App\Models\Patient::findFirst($id);
        if(!$patient) {
            throw new RecordNotFoundException();
        }

        return $patient->delete();
    }
}
