<?php

class Database
{
    public $connection;
    public $statement;

    public function __construct($username = 'root', $password = 'priom417')
    {
        $config = require('config.php');

        $dsn = 'mysql:' . http_build_query($config['database'], '', ';');

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params = [])
    {
        $statement = $this->connection->prepare($query);

        $statement->execute($params);

        $this->statement = $statement;

        return $this;
    }

    public function get(){

        $resut = $this->statement->fetchAll();

        return $resut;
    }

    public function find(){

        $resut = $this->statement->fetch();

        return $resut;
    }

    public function findOrFail(){

        $resut = $this->statement->fetch();

        if(!$resut){
            abort();
        }
        
        return $resut;
    }
}

//PDO::FETCH_ASSOC -> Fetch associative array
//PDO::FETCH_BOTH -> Fetch both (associative array and normal array)
//PDO::FETCH_CLASS -> Return class object
//PDO::FETCH_OBJ -> Return class object