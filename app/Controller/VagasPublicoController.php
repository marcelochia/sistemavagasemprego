<?php

namespace App\Controller;

use App\Model\Vaga;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

 class VagasPublicoController
 {
    public static function index(Request $request, Response $response)
    {
        $getParams = $request->getQueryParams();

        // Cálculo da páginação
        $qtde   = (int) 10;
        $pagina = (int) (isset($getParams['page'])) ? $getParams['page'] : 1 ;
        $paginaAtual = $pagina;
        $pagina = ($pagina - 1) * $qtde;
        $pagina = ($pagina < 0) ? $pagina = 0 : $pagina;

        $totalRegistros = (new Vaga())->listar('count(*) as total');
        $totalRegistros = $totalRegistros[0]['total'];
        $totalPaginas = ceil($totalRegistros / $qtde);
        $paginas = array();
        for ($i=$paginaAtual-3; $i <= $totalPaginas; $i++) {
            if (($i > 0) && $i < $paginaAtual + 3) {
                array_push($paginas, $i);
            }
        }
        //
        
        $vagas = (new Vaga())->listar('*', $pagina, $qtde);
        
        $loader = new FilesystemLoader(__DIR__ . '/../../views/site');
        $twig   = new Environment($loader);
        $template = $twig->load('vagas.html');
        
        $params = array();
        $params['vagas']        = $vagas;
        $params['paginaAtual']  = $paginaAtual;
        $params['paginas']      = $paginas;
        $params['totalPag']     = $totalPaginas;
        
        $content = $template->render($params);
        echo $content;

        return $response;
    }
 }