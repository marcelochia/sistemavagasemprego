<?php

namespace App\Controller;

use App\Model\Vaga;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VagaController
{
    public static function index(Request $request, Response $response)
    {
        $vagas = new Vaga();
        $vagas = json_encode($vagas->listarTodos(), JSON_PRETTY_PRINT);
        $response->getBody()->write($vagas);
        return $response;
    }

    public static function show(Request $request, Response $response, array $args)
    {
        $vaga = new Vaga();
        $id = $args['id'];
        $vaga = json_encode($vaga->listar($id), JSON_PRETTY_PRINT);
        $response->getBody()->write($vaga);
        return $response;
    }

    public static function create(Request $request, Response $response)
    {
        $vaga = new Vaga();
        $data = $request->getParsedBody();
        $vaga->inserir($data);
        return $response;
    }

    public static function update(Request $request, Response $response, array $args)
    {
        $vaga = new Vaga();
        $id = $args['id'];
        $values = $request->getParsedBody();
        // print_r($values);die;
        $vaga->atualizar($id, $values);
        return $response;
    }

    public static function destroy(Request $request, Response $response, array $args)
    {
        print_r($request);die;
        $vaga = new Vaga();
        $id = $args['id'];
        $vaga->apagar($id);
        return $response;
    }
}
