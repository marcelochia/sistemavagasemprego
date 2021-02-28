<?php

namespace App\DB;

use PDO;
use PDOException;

class Database
{
    private $table;
    private $connection;

    public function __construct($table = null)
    {
        $this->table = $table;
        $this->connection();
    }

    private function connection()
    {
        $config    = parse_ini_file(__DIR__ . '/../../config/config.ini');
        $stringPDO = $config['DB_CONNECTION'] . ':' . 'host=' . $config['DB_HOST'] . ';' 
                             . 'dbname=' . $config['DB_DATABASE'];
        $userDB    = $config['DB_USERNAME'];
        $passDB    = $config['DB_PASSWORD'];

        try {
            $this->connection = new PDO($stringPDO, $userDB, $passDB);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro: ' . $e->getMessage());
        }
    }
    
    public function select($where = null, $fields = '*')
    {
        $where = isset($where) ? " WHERE " . $where : "";

        $query = "SELECT " . $fields . " FROM " . $this->table . $where;
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
        } catch (PDOException $e) {
            die('Erro:' . $e->getMessage());
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}