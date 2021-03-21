<?php

namespace App\Model;

use App\DB\Database;
use App\DB\QueryBuilder;
use PDO;

class Model {

    private $values = [];

    public function __call($name, $args)
    {
        $method     = substr($name, 0, 3);
        $fieldName  = substr($name, 3, strlen($name));

        switch ($method) {
            case 'get':
                return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
                break;
            case 'set':
                $this->values[$fieldName] = $args[0];
                break;
        }
    }

    public function setData($data = array())
    {
        foreach ($data as $key => $value) {
            $this->{"set" . $key}($value);
        }
    }

    public function getValues()
    {
        return $this->values;
    }

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