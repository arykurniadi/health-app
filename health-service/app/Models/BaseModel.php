<?php

namespace App\Models;

use Carbon\Carbon;
use Phalcon\Mvc\Model;
use App\Presenters\Exceptions\PresenterNotFoundException;

class BaseModel extends Model
{
    public $created_at;
    public $updated_at;

    public function beforeValidationOnCreate() {
        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();
    }

    public function beforeValidationOnUpdate() {
        $this->updated_at = Carbon::now();
    }
}