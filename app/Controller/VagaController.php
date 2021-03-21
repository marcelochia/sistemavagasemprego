<?php

namespace App\Controller;

use App\Model\Vaga;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class VagaController
{
    public static function index(Request $request, Response $response)
    {
        UsuarioController::verificaLogin();

        $vagas = new Vaga();
        $vagas = $vagas->listarTodos();
        
        $loader = new FilesystemLoader(__DIR__ . '/../../views/admin');
        $twig = new Environment($loader);
        $template = $twig->load('vagas.html');
        
        $params = array();
        $params['vagas'] = $vagas;
        $params['usuario_sistema'] = $_SESSION['UsuarioSistema'];

        $content = $template->render($params);
        echo $content;

        return $response;
    }
    
    public static function create(Request $request, Response $response)
    {
        UsuarioController::verificaLogin();

        $loader = new FilesystemLoader(__DIR__ . '/../../views/admin');
        $twig = new Environment($loader);
        $template = $twig->load('formulario.html');

        $params['usuario_sistema'] = $_SESSION['UsuarioSistema'];
        $content = $template->render($params);
        echo $content;

        return $response;
    }

    public static function show(Request $request, Response $response, array $args)
    {
        UsuarioController::verificaLogin();
        
        $uri = $_SERVER['REQUEST_URI'];
        $vaga = new Vaga();
        $id = $args['id'];
        $vaga = $vaga->exibir($id);

        $loader = new FilesystemLoader(__DIR__ . '/../../views/admin');
        $twig = new Environment($loader);
        $template = $twig->load('formulario.html');

        $content = $template->render($vaga[0]);
        echo $content;
        
        return $response;
    }

    public static function store(Request $request, Response $response)
    {
        $vaga = new Vaga();
        $data = $_POST;
        $vaga->inserir($data);
        header('Location: /vagas');
        exit;
    }

    public static function update(Request $request, Response $response, array $args)
    {
        $vaga = new Vaga();
        $id = $args['id'];
        $values = $request->getParsedBody();
        $vaga->atualizar($id, $values);
        header('Location: /vagas');
        exit;
    }

    public static function destroy(Request $request, Response $response, array $args)
    {
        $vaga = new Vaga();
        $id = $args['id'];
        $vaga->apagar($id);
        header('Location: /vagas');
        exit;
    }
}
