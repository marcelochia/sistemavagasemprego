<?php

namespace App\Controller;

use App\Model\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class UsuarioController extends Controller
{
    public static function index(Request $request, Response $response)
    {
        LoginController::verificaLogin();

        $usuarios = new Usuario();
        $usuarios = $usuarios->listarTodos();
        
        $loader = new FilesystemLoader(__DIR__ . '/../../views/admin');
        $twig = new Environment($loader);
        $template = $twig->load('usuarios/usuarios.html');
        
        $params = array();
        $params['usuarios'] = $usuarios;
        $params['usuario_sistema'] = $_SESSION['UsuarioSistema'];

        $content = $template->render($params);
        echo $content;

        return $response;
    }
    
    public static function create(Request $request, Response $response)
    {
        LoginController::verificaLogin();

        $loader = new FilesystemLoader(__DIR__ . '/../../views/admin');
        $twig = new Environment($loader);
        $template = $twig->load('usuarios/formulario.html');

        $params['usuario_sistema'] = $_SESSION['UsuarioSistema'];
        $content = $template->render($params);
        echo $content;

        return $response;
    }

    public static function show(Request $request, Response $response, array $args)
    {
        LoginController::verificaLogin();
        
        $usuario = new Usuario();
        $id = $args['id'];
        $usuario = $usuario->exibir($id);

        $loader = new FilesystemLoader(__DIR__ . '/../../views/admin');
        $twig = new Environment($loader);
        $template = $twig->load('formulario.html');

        $content = $template->render($usuario[0]);
        echo $content;
        
        return $response;
    }

    public static function store(Request $request, Response $response)
    {
        $usuario = new Usuario();
        $data = $_POST;
        $usuario->inserir($data);
        header('Location: /vagas');
        exit;
    }

    public static function update(Request $request, Response $response, array $args)
    {
        $usuario = new Usuario();
        $id = $args['id'];
        $values = $request->getParsedBody();
        $usuario->atualizar($id, $values);
        header('Location: /vagas');
        exit;
    }

    public static function destroy(Request $request, Response $response, array $args)
    {
        $usuario = new Usuario();
        $id = $args['id'];
        $usuario->apagar($id);
        header('Location: /vagas');
        exit;
    }
}