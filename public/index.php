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

$app->get('/painel/vagas/novo', VagaController::class . ':create');

$app->post('/painel/vagas/gravar', VagaController::class . ':store');

$app->post('/painel/vagas/{id}/atualizar', VagaController::class . ':update');

$app->get('/painel/vagas/{id}/editar', VagaController::class . ':show');

$app->get('/painel/vagas/{id}/apagar', VagaController::class . ':destroy');

$app->get('/painel/vagas/{id}', VagaController::class . ':show');

$app->get('/painel/vagas', VagaController::class . ':index');

// Usuario

$app->get('/painel/usuarios/novo', UsuarioController::class . ':create');

$app->post('/painel/usuarios/gravar', UsuarioController::class . ':store');

$app->post('/painel/usuarios/{id}/atualizar', UsuarioController::class . ':update');

$app->get('/painel/usuarios/{id}/editar', UsuarioController::class . ':show');

$app->get('/painel/usuarios/{id}/apagar', UsuarioController::class . ':destroy');

$app->get('/painel/usuarios/{id}', UsuarioController::class . ':show');

$app->get('/painel/usuarios', UsuarioController::class . ':index');

// Login

$app->post('/painel/login', LoginController::class . ':login');

$app->get('/painel/logout', LoginController::class . ':logout');

$app->get('/painel', LoginController::class . ':loginPage');

$app->run();