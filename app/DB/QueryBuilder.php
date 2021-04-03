<?php

namespace App\DB;

class QueryBuilder
{
    private $command;
    private $fields     = [];
    private $conditions = [];
    private $from       = [];
    private $binds      = [];
    private $set;
    private $limit;

    public function __toString(): string
    {
        $from   = $this->from === [] ? '' : ' FROM ' . implode(', ', $this->from);
        $set    = $this->set == '' ? '' : ' SET ' . $this->set;
        $where  = $this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $this->conditions);
        $binds  = $this->binds === [] ? '' : ' (' . implode(', ', $this->fields) . ')'
                . ' VALUES ' . '(' . implode(', ', $this->binds) . ')';

        return $this->command
                . $set
                . $from
                . $binds
                . $where
                . $this->limit;
    }

    public function select(string ...$select): self
    {
        $this->fields = $select;
        $this->command = 'SELECT ' . implode(', ', $this->fields);
        return $this;
    }

    public function insert($table, $values = array())
    {
        $fields = array_keys($values);
        $binds  = array_pad([], count($fields), '?');

        $this->command = 'INSERT INTO ' . $table;
        $this->fields = $fields;
        $this->binds = $binds;
        return $this;
    }

    public function update($table)
    {
        $this->command  = 'UPDATE ' . $table;
        return $this;
    }

    public function delete(): self
    {   
        $this->command = 'DELETE ';
        return $this;
    }

    public function from(string $table, ?string $alias = null): self
    {
        if ($alias === null) {
            $this->from[] = $table;
        } else {
            $this->from[] = "${table} AS ${alias}";
        }
        return $this;
    }

    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    public function limit(int $init, int $max)
    {
        $this->limit = " LIMIT {$init}, {$max}";
        return $this;
    }

    public function set($values)
    {
        $columns = array_keys($values);
        $binds = array_pad([], count($values), '?');

        $set = '';
        for ($i=0; $i < count($columns); $i++) { 
            $set .= $columns[$i] . ' = ' . $binds[$i] . ', ';
        }
        
        $this->set = substr_replace($set, '', -2, 1);
        return $this;
    }
}