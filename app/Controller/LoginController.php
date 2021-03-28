<?php

namespace App\Controller;

use App\Model\Login;
use App\Model\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class LoginController extends Controller
{
    public static function verificaLogin($onlyAdmin = false)
    {
        if (!isset($_SESSION['UsuarioSistema']) 
            || !$_SESSION) {
            header('Location: /');
            exit;
        }
        
        if (($onlyAdmin) && ($_SESSION['UsuarioSistema']['ADMINISTRADOR'] === '0')) {
            header('Location: /vagas');
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
        $result = Login::getUsuario($_POST['usuario'], $_POST['senha']);

        if (count($result) === 0) {
            throw new \Exception("Verifique se o usuário ou a senha estão corretos");
        }

        $data = $result[0];

        if (password_verify($_POST['senha'], $data["SENHA"]) === true) {
            $usuario = new Usuario();
            $usuario->setData($data);

            $_SESSION['UsuarioSistema'] = $usuario->getValues();
            unset($_SESSION['UsuarioSistema']['SENHA']);

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