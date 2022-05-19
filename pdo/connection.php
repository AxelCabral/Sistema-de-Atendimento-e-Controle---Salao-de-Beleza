<?php
class connection{
    protected $pdo;

    function connect(){ // Faz a conexão com o banco de datos
        $this->pdo = new PDO("mysql:host=localhost; dbname=database", "root", "");
        return $this->pdo;
    }
}
