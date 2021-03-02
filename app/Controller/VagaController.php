<?php

namespace App\Controller;

use App\Model\Vaga;

class VagaController
{
    public static function index()
    {
        $vagas = new Vaga();
        return $vagas->listarTodos();
    }

    public static function show($id)
    {
        $vaga = new Vaga();
        return $vaga->listar($id);
    }

    public static function insert($valores)
    {
        $vaga = new Vaga();
        $vaga->inserir($valores);   
    }

    public static function update($id, $values)
    {
        $vaga = new Vaga();
        $vaga->atualizar($id, $values);
    }

    public static function destroy($id)
    {
        $vaga = new Vaga();
        $vaga->apagar($id);
    }
}
