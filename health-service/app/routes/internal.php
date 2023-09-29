<?php 

use Phalcon\Mvc\Micro\Collection as MicroCollection;
use App\Controllers\HomeController;

$collection = new MicroCollection();

$collection->setHandler(HomeController::class, true);

$collection->setPrefix('/v1/internal');

$collection->get('/status', 'status');
$collection->get('/driver', 'driver');

$this->app->mount($collection);