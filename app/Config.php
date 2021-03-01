<?php

namespace App;

class Config
{
    private $config;

    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . '/../config/config.ini', true);
    }

    public function timezone()
    {
        return $this->config['TIMEZONE']['SET_TIMEZONE'];
    }

    public function database()
    {
        return $this->config['DATABASE'];
    }
}
