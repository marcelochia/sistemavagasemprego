<?php

use App\Config;
use App\Controller\VagaController;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set((new Config)->timezone());

$app = AppFactory::create();

$app->addErrorMiddleware(true, false, false);

$app->get('/vagas/novo', VagaController::class . ':create');

$app->post('/vagas/gravar', VagaController::class . ':store');

$app->post('/vagas/{id}/atualizar', VagaController::class . ':update');

$app->get('/vagas/{id}/editar', VagaController::class . ':show');

$app->get('/vagas/{id}/apagar', VagaController::class . ':destroy');

$app->get('/vagas/{id}', VagaController::class . ':show');

$app->get('/vagas', VagaController::class . ':index');

$app->run();