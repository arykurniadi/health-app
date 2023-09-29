<?php

namespace App\Requests\Patient;

use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\PresenceOf;

class CreateRequest extends Validation
{
    public $nik;
    public $name;
    public $sex;
    public $religion;
    public $phone;
    public $address;

    public $post;

    public function __construct($posts)
    {
        foreach($posts as $key => $value) {
            $this->{$key} = $value;
        }        
        $this->posts = $posts;
    }

    public function getNik()
    {
        return $this->nik;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function getReligion()
    {
        return $this->religion;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function initialize()
    {
        $this->add(
            'nik',
            new PresenceOf(['message' => 'NIK is required'])
        );

        $this->add(
            'name',
            new PresenceOf(['message' => 'Name is required'])
        );

        $this->add(
            'sex',
            new InclusionIn([
                'message' => 'Invalid sex value',
                'domain' => ['male', 'female'],
            ])
        );

        $this->add(
            'religion',
            new InclusionIn([
                'message' => 'Invalid religion value',
                'domain' => ['islam', 'kristen', 'katolik', 'hindu', 'budha'],
            ])
        );

        $this->add(
            'phone',
            new Regex([
                'pattern' => '/^\d{10}$/',
                'message' => 'Invalid phone number format',
            ])
        );
    }    

    public function validate($data = null, $entity = null)
    {
        $this->initialize();
        return parent::validate($this->posts, null);
    }    
}
