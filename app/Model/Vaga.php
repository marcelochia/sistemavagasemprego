<?php

namespace App\Model;

use App\DB\Database;
use App\DB\QueryBuilder;
use PDO;

class Vaga
{
    protected $table = 'vagas';

    protected $columns = [
        'id',
        'titulo',
        'area',
        'tipo_contrato',
        'salario',
        'descricao',
        'status',
        'data_criacao',
        'data_alteracao'
    ];

    public function listarTodos()
    {
        $query = (new QueryBuilder())->select('*')->from($this->table);
        $result = (new Database())->execute($query)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function exibir(int $id)
    {
        $query = (new QueryBuilder())->select('*')->from($this->table)->where("{$this->columns[0]} = {$id}");
        $result = (new Database())->execute($query)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function inserir($values = array())
    {
        $query = (new QueryBuilder())->insert($this->table, $values);
        (new Database())->execute($query, array_values($values));
    }

    public function atualizar($id, $values = array())
    {
        $date = date('Y-m-d H:i:s');
        $values['data_alteracao'] = $date;
        
        $query = (new QueryBuilder())->update($this->table)->set($values)->where("{$this->columns[0]} = {$id}");
        (new Database())->execute($query, array_values($values));
    }

    public function apagar($id)
    {
        $query = (new QueryBuilder())->delete()->from($this->table)->where("{$this->columns[0]} = {$id}");
        (new Database())->execute($query);
    }
}
