<?php 

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use App\Controllers\HealthCheckController;

$collection = new MicroCollection();

$collection->setHandler(HealthCheckController::class, true);

$collection->setPrefix('/v1');

// $collection->get('/', 'index');
$collection->get('/health-check', 'index');

$this->app->mount($collection);