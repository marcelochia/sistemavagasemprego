<?php

namespace App\Model;

use App\DB\Database;
use App\DB\QueryBuilder;
use PDO;

class Usuario extends Model
{
    protected $table = 'USUARIOS_SISTEMA';
    
    public static function getUsuario($usuario)
    {
        $query = (new QueryBuilder())->select('*')->from($table)->where("USUARIO = '{$usuario}'");
        $result = (new Database())->execute($query)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}