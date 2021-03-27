<?php

namespace App\Model;

use App\DB\Database;
use App\DB\QueryBuilder;
use PDO;

class Login extends Model
{
    protected static $table = 'USUARIOS_SISTEMA';
    
    public static function getUsuario($usuario)
    {
        $query = (new QueryBuilder())->select('*')->from(self::$table)->where("USUARIO = '{$usuario}'");
        $result = (new Database())->execute($query)->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}