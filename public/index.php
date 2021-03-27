<?php

session_start();

use App\Config;
use App\Controller\LoginController;
use App\Controller\UsuarioController;
use App\Controller\VagaController;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set((new Config)->timezone());

$app = AppFactory::create();

$app->addErrorMiddleware(true, false, false);

// Vaga

$app->get('/vagas/novo', VagaController::class . ':create');

$app->post('/vagas/gravar', VagaController::class . ':store');

$app->post('/vagas/{id}/atualizar', VagaController::class . ':update');

$app->get('/vagas/{id}/editar', VagaController::class . ':show');

$app->get('/vagas/{id}/apagar', VagaController::class . ':destroy');

$app->get('/vagas/{id}', VagaController::class . ':show');

$app->get('/vagas', VagaController::class . ':index');

// Usuario

$app->get('/usuarios/novo', UsuarioController::class . ':create');

$app->post('/usuarios/gravar', UsuarioController::class . ':store');

$app->post('/usuarios/{id}/atualizar', UsuarioController::class . ':update');

$app->get('/usuarios/{id}/editar', UsuarioController::class . ':show');

$app->get('/usuarios/{id}/apagar', UsuarioController::class . ':destroy');

$app->get('/usuarios/{id}', UsuarioController::class . ':show');

$app->get('/usuarios', UsuarioController::class . ':index');

// Login

$app->post('/login', LoginController::class . ':login');

$app->get('/logout', LoginController::class . ':logout');

$app->get('/', LoginController::class . ':loginPage');

$app->run();