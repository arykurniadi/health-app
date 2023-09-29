<?php 

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use App\Controllers\AuthController;
use App\Controllers\PatientController;

$collection = new MicroCollection();

$collection->setHandler(PatientController::class, true);

$collection->setPrefix('/v1/crm');

$collection->get('/patient', 'index');
$collection->get('/patient/{id}', 'getById');
$collection->post('/patient', 'create');
$collection->put('/patient/{id}', 'update');
$collection->delete('/patient/{id}', 'delete');

$this->app->mount($collection);