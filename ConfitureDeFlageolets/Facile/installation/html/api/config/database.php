<?php

    class Database{

        private $host     = "localhost";
        private $port     = "5432";
        private $dbname   = "stdoctolib";
        private $user     = "postgres";
        private $password = "stdoctolib4ever<3";
        private $conx;


        function getConnection(){
            //permet d'acceder à la base de donnée via le concept objet facilite l'acces à la base de donnée
            $this->conx = NULL;

            $connection_string = "host={$this->host} port={$this->port} dbname={$this->dbname} user={$this->user} password={$this->password} ";
            $this->conx= pg_connect($connection_string);

            if($this->conx)
                return $this->conx;
            else
                echo "Connection error". $e->getMessage();
            }
        }



?>
