<?php

namespace App\DB;

use App\Config;
use PDO;
use PDOException;

class Database
{
    private $connection;

    public function __construct($table = null)
    {
        $this->table = $table;
        $this->connection();
    }

    protected function connection()
    {
        $configDB  = (new Config)->database();
        $stringPDO = $configDB['DB_CONNECTION'] . ':' . 'host=' . $configDB['DB_HOST'] . ';' 
                             . 'dbname=' . $configDB['DB_DATABASE'];
        $userDB    = $configDB['DB_USERNAME'];
        $passDB    = $configDB['DB_PASSWORD'];

        try {
            $this->connection = new PDO($stringPDO, $userDB, $passDB);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro: ' . $e->getMessage());
        }
    }

    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}