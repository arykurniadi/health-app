<?php

namespace App\Presenters\Patient;

use App\Presenters\AbstractPresenter;
use App\Models\Patient;

class PatientPresenter extends AbstractPresenter
{
    public $id;
    public $nik;
    public $name;
    public $sex;
    public $religion;
    public $phone;
    public $address;
    public $created_at;
    public $updated_at;

    public function __construct(Patient $patient)
    {
        $this->id = (int)$patient->id;
        $this->nik = $patient->nik;
        $this->name = $patient->name;
        $this->sex = $patient->sex;
        $this->religion = $patient->religion;
        $this->phone = $patient->phone;
        $this->address = $patient->address;
        $this->created_at = $patient->created_at;
        $this->updated_at = $patient->updated_at;
    }
}
