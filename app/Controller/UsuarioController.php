<?php

namespace App\Controller;

use App\Model\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class UsuarioController extends Controller
{
    const SESSION = "Usuario";

    public static function verificaLogin()
    {
        if (!isset($_SESSION['UsuarioSistema']) 
            || !$_SESSION) {
            header('Location: /');
            exit;
        }
    }
    
    public static function loginPage(Request $request, Response $response)
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../views');
        $twig = new Environment($loader);
        $template = $twig->load('login.html');

        $content = $template->render();
        echo $content;

        return $response;
    }

    public static function login()
    {
        $result = Usuario::getUsuario($_POST['usuario'], $_POST['senha']);

        if (count($result) === 0) {
            throw new \Exception("Verifique se o usuário ou a senha estão corretos");
        }

        $data = $result[0];

        if (password_verify($_POST['senha'], $data["SENHA"]) === true) {
            $usuario = new Usuario();
            $usuario->setData($data);

            $_SESSION['UsuarioSistema'] = $usuario->getValues();

            header("Location: /vagas");
            exit;
        } else {
            throw new \Exception("Usuário ou senha incorretas");
        } 
    }

    public static function logout()
    {
        session_unset();
        header('Location: /');
        exit;
    }
}