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
        LoginController::verificaLogin(true);

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
        LoginController::verificaLogin(true);

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
        LoginController::verificaLogin(true);

        $usuario = new Usuario();
        $id = $args['id'];
        $usuario = $usuario->exibir($id);

        $usuario[0]['DATA_CRIACAO'] = date('d/m/Y - H:m:s', strtotime($usuario[0]['DATA_CRIACAO']));
        $usuario[0]['DATA_ALTERACAO'] = date('d/m/Y - H:m:s', strtotime($usuario[0]['DATA_ALTERACAO']));
        
        $loader = new FilesystemLoader(__DIR__ . '/../../views/admin');
        $twig = new Environment($loader);
        $template = $twig->load('usuarios/formulario.html');

        $content = $template->render($usuario[0]);
        echo $content;
        
        return $response;
    }

    public static function store(Request $request, Response $response)
    {
        $usuario = new Usuario();

        $values = $request->getParsedBody();

        foreach ($values as $key => $value) {
            if ($value == '') {
                throw new \Exception("O campo deve ser preenchido.");
            }
        }
        
        $values['senha'] = password_hash($values['senha'], PASSWORD_DEFAULT);
        $usuario->inserir($values);
        
        header('Location: /usuarios');
        exit;
    }

    public static function update(Request $request, Response $response, array $args)
    {
        $usuario = new Usuario();
        $id = $args['id'];

        $values = $request->getParsedBody();
        $values['senha'] = password_hash($values['senha'], PASSWORD_DEFAULT);
        $usuario->atualizar($id, $values);

        header('Location: /usuarios');
        exit;
    }

    public static function destroy(Request $request, Response $response, array $args)
    {
        $usuario = new Usuario();
        $id = $args['id'];
        $usuario->apagar($id);
        header('Location: /usuarios');
        exit;
    }
}