<?php


class DbConnection
{
    private $host, $dbname, $user, $pass, $dbHandle;


    function getConnection()
    {
        $this->host = 'poseidon.salford.ac.uk';
        $this->dbname = 'sgb778_';
        $this->user = 'sgb778';
        $this->pass = 'bFD6vgZHb1dSHdg';
        $this->dbHandle = new PDO("mysql:host=$this->host;dbname=$this->dbname",
            $this->user,$this->pass);
        return $this->dbHandle;
    }
}