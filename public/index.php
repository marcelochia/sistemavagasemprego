<?php

use App\Config;
use App\Controller\VagaController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set((new Config)->timezone());

$app = AppFactory::create();

$app->addErrorMiddleware(true, false, false);

$app->get('/vagas', VagaController::class . ':index');

$app->post('/vagas/{id}/atualizar', VagaController::class . ':update');

$app->get('/vagas/{id}', VagaController::class . ':show');

$app->post('/vagas/novo', VagaController::class . ':create');

$app->delete('/vagas/{id}/apagar', VagaController::class . ':destroy');

$app->run();