<?php

namespace App\DAO;

abstract class Conexao
{

    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct()
    {
        $host = getenv('VENDAMAIS_MYSQL_HOST');
        $port = getenv('VENDAMAIS_MYSQL_PORT');
        $user = getenv('VENDAMAIS_MYSQL_USER');
        $pass = getenv('VENDAMAIS_MYSQL_PASSWORD');
        $dbname = getenv('VENDAMAIS_MYSQL_DBNAME');

        $dsn = "mysql:host={$host};dbname={$dbname};port={$port}";

        $this->pdo = new \PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}